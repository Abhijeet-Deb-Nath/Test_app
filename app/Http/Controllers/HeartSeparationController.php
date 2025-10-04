<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use App\Models\HeartSeparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HeartSeparationController extends Controller
{
    /**
     * Show the heart separation request form.
     */
    public function create()
    {
        $user = Auth::user();
        $couple = $user->couple();

        if (!$couple) {
            return redirect()->route('dashboard')->with('error', 'You are not in a couple.');
        }

        if ($couple->hasPendingSeparation()) {
            return redirect()->route('dashboard')->with('error', 'There is already a pending separation request.');
        }

        return view('heart-separations.create', compact('couple'));
    }

    /**
     * Store a heart separation request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $couple = $user->couple();

        if (!$couple) {
            return redirect()->route('dashboard')->with('error', 'You are not in a couple.');
        }

        if ($couple->hasPendingSeparation()) {
            return redirect()->route('dashboard')->with('error', 'There is already a pending separation request.');
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $partner = $couple->getPartner($user);

        HeartSeparation::create([
            'couple_id' => $couple->id,
            'requester_id' => $user->id,
            'responder_id' => $partner->id,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('info', 'Heart separation request has been sent. Waiting for response... 💔');
    }

    /**
     * Approve a heart separation request.
     */
    public function approve(HeartSeparation $heartSeparation)
    {
        $user = Auth::user();

        // Verify the user is the responder
        if ($heartSeparation->responder_id !== $user->id) {
            abort(403);
        }

        if (!$heartSeparation->isPending()) {
            return redirect()->route('dashboard')->with('error', 'This request has already been responded to.');
        }

        DB::transaction(function () use ($heartSeparation) {
            // Update the separation request
            $heartSeparation->update([
                'status' => 'approved',
                'responded_at' => now(),
            ]);

            $couple = $heartSeparation->couple;

            // Delete the couple relationship (this will cascade delete all shared content)
            $couple->delete();
        });

        return redirect()->route('dashboard')->with('success', 'Heart separation completed. Take care of yourself. 🌸');
    }

    /**
     * Decline a heart separation request.
     */
    public function decline(HeartSeparation $heartSeparation)
    {
        $user = Auth::user();

        // Verify the user is the responder
        if ($heartSeparation->responder_id !== $user->id) {
            abort(403);
        }

        if (!$heartSeparation->isPending()) {
            return redirect()->route('dashboard')->with('error', 'This request has already been responded to.');
        }

        $heartSeparation->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Heart separation request declined. Your bond continues. 💕');
    }

    /**
     * Cancel a pending separation request (by the requester).
     */
    public function cancel(HeartSeparation $heartSeparation)
    {
        $user = Auth::user();

        // Verify the user is the requester
        if ($heartSeparation->requester_id !== $user->id) {
            abort(403);
        }

        if (!$heartSeparation->isPending()) {
            return redirect()->route('dashboard')->with('error', 'This request has already been responded to.');
        }

        $heartSeparation->delete();

        return redirect()->route('dashboard')->with('success', 'Separation request cancelled.');
    }
}
