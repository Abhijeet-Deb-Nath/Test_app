<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $couple = $user->couple();
        $partner = $user->partner();
        $pendingRequests = $user->pendingHeartConnections;

        return view('dashboard', compact('user', 'couple', 'partner', 'pendingRequests'));
    }
}
