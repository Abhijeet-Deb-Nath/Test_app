<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use App\Models\HeartConnection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HeartConnectionController extends Controller
{
    /**
     * Show the send heart connection form.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Check if user is already in a couple
        if ($user->isInCouple()) {
            return redirect()->route('dashboard')->with('error', 'You are already in a couple! 💕');
        }

        return view('heart-connections.create');
    }

    /**
     * Send a heart connection request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user is already in a couple
        if ($user->isInCouple()) {
            return redirect()->route('dashboard')->with('error', 'You are already in a couple!');
        }

        $validated = $request->validate([
            'receiver_email' => 'required|email|exists:users,email',
            'message' => 'nullable|string|max:500',
        ]);

        $receiver = User::where('email', $validated['receiver_email'])->first();

        // Validation checks
        if ($receiver->id === $user->id) {
            return back()->withErrors(['receiver_email' => 'You cannot send a heart connection to yourself!']);
        }

        if ($receiver->isInCouple()) {
            return back()->withErrors(['receiver_email' => 'This user is already in a couple.']);
        }

        // Check if there's already a pending request
        $existingRequest = HeartConnection::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)->where('receiver_id', $user->id);
        })->where('status', 'pending')->first();

        if ($existingRequest) {
            return back()->withErrors(['receiver_email' => 'There is already a pending heart connection with this user.']);
        }

        // Create the heart connection request
        HeartConnection::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Heart connection request sent! 💌');
    }

    /**
     * Accept a heart connection request.
     */
    public function accept(HeartConnection $heartConnection)
    {
        $user = Auth::user();

        // Verify the user is the receiver
        if ($heartConnection->receiver_id !== $user->id) {
            abort(403);
        }

        // Check if already responded
        if (!$heartConnection->isPending()) {
            return redirect()->route('dashboard')->with('error', 'This request has already been responded to.');
        }

        // Check if either user is already in a couple
        if ($user->isInCouple() || $heartConnection->sender->isInCouple()) {
            return redirect()->route('dashboard')->with('error', 'One of you is already in a couple.');
        }

        DB::transaction(function () use ($heartConnection) {
            // Update the heart connection
            $heartConnection->update([
                'status' => 'accepted',
                'responded_at' => now(),
            ]);

            // Create the couple
            Couple::create([
                'user_one_id' => $heartConnection->sender_id,
                'user_two_id' => $heartConnection->receiver_id,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Heart connection accepted! Welcome to your shared love space! 💑');
    }

    /**
     * Decline a heart connection request.
     */
    public function decline(HeartConnection $heartConnection)
    {
        $user = Auth::user();

        // Verify the user is the receiver
        if ($heartConnection->receiver_id !== $user->id) {
            abort(403);
        }

        // Check if already responded
        if (!$heartConnection->isPending()) {
            return redirect()->route('dashboard')->with('error', 'This request has already been responded to.');
        }

        $heartConnection->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Heart connection declined.');
    }
}
