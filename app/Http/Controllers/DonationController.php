<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use App\Models\UserDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest()->paginate();
        return view('dashboard', compact('donations'));
    }

    public function create()
    {
        return view('donations.create');
    }

    public function edit(Donation $donation)
    {
        return view('donations.edit', compact('donation'));
    }

    public function createContributionForm(Donation $donation)
    {
        return view('donations.contribute', compact('donation'));
    }

    public function contribute(Request $request, Donation $donation)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            // Update the donation's current_amount
            $donation->update(['current_amount' => $donation->current_amount + $validatedData['amount']]);

            // Create a new contribution record
            UserDonation::create([
                'donation_id' => $donation->id,
                'user_id' => auth()->id(),
                'amount' => $validatedData['amount'],
            ]);

            // Automatically mark as completed if target is reached
            if ($donation->isCompleted()) {
                $donation->completed = true;
                $donation->save();
            }

            return redirect()->route('dashboard', $donation)->with('success', 'Contribution added successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating contribution: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to contribute. Please try again.']);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'target_amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        $validatedData['user_id'] = auth()->id();

        try {
            $donation = Donation::create($validatedData);

            return redirect()->route('dashboard')->with('success', 'Donation created successfully');
        } catch (\Exception $e) {
            \Log::error('Error creating donation: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create donation'], 500);
        }
    }

    public function show(Donation $donation)
    {
        return $donation->load('user');
    }

    public function update(Request $request, Donation $donation)
    {
        $validatedData = $request->validate([
            'target_amount' => 'sometimes|numeric|min:0.01',
            'description' => 'sometimes|nullable|string|max:255',
        ]);

        $donation->update($validatedData);

        if ($donation->isCompleted()) {
            $donation->completed = true;
            $donation->save();
        }

        return redirect()->route('users.donations', $donation->user)->with('message', 'Donation updated successfully');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('dashboard')->with(['message' => 'Donation deleted successfully'], 200);
    }

    public function markAsComplete(Donation $donation)
    {
        $donation->update(['completed' => true]);
        return response()->json(['message' => 'Donation target reached.'], 200);
    }

    public function getUserDonations(User $user)
    {
        $user_donations = Auth::user()->donations()->latest()->paginate();
        return view('users.donations', compact('user_donations'));
    }
}
