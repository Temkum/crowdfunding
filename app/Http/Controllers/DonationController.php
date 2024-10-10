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


    public function contribute1(Donation $donation, Request $request)
    {
        $validatedData = $request->validate([
            'target_amount' => 'required|numeric|min:0.01',
        ]);

        $donation->amount += $validatedData['target_amount'];
        $donation->save();

        return response()->json(['message' => 'Contribution added successfully', 'donation' => $donation], 201);
    }

    public function contribute2(Request $request, Donation $donation)
    {
        $amount = $request->input('target_amount', 0);

        if ($amount <= 0) {
            return response()->json(['error' => 'Contribution amount must be greater than zero'], 422);
        }

        $newAmount = min($donation->remainingAmount(), $amount);

        // Create a new contribution record
        $donation->contributors()->attach(auth()->id(), ['target_amount' => $newAmount]);

        // Increment the donation's current amount
        $donation->increment('current_amount', $newAmount);

        // Automatically mark as completed if target is reached
        if ($donation->isCompleted()) {
            $donation->completed = true;
            $donation->save();
        }

        return response()->json(['message' => 'Donation contributed successfully', 'donation' => $donation]);
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

            // return response()->json(['message' => 'Donation created successfully', 'donation' => $donation], 201);

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
            'amount' => 'sometimes|numeric|min:0.01',
            'description' => 'sometimes|nullable|string|max:255',
        ]);

        $donation->update($validatedData);

        return response()->json(['message' => 'Donation updated successfully', 'donation' => $donation]);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return response()->json(['message' => 'Donation deleted successfully'], 200);
    }

    public function markAsComplete(Donation $donation)
    {
        $donation->update(['completed' => true]);
        return response()->json(['message' => 'Donation marked as completed'], 200);
    }

    public function getUserDonations(User $user)
    {
        return $user->donations()->latest()->paginate();
    }

    public function UserDonations()
    {
        $userDonations = Auth::user()->donations()->latest()->paginate();
        return view('users.donations', compact('userDonations'));
    }
}
