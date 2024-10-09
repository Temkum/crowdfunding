<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        return Donation::with('user')->latest()->paginate();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $donation = Donation::create($validatedData);

        return response()->json(['message' => 'Donation created successfully', 'donation' => $donation], 201);
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
}
