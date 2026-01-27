<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SupervisorDashboardController extends Controller
{
    /**
     * Show the main Command Overview dashboard.
     */
    public function index()
    {
        // Count only trainees assigned to this specific supervisor
        $totalTrainees = Trainee::where('supervisor_id', Auth::id())->count();
        
        $pendingAttendance = 0; // Logic for attendance pending approval placeholder

        return view('supervisor.dashboard', compact('totalTrainees', 'pendingAttendance'));
    }

    /**
     * Display the list of trainees under this supervisor.
     */
    public function trainees()
    {
        // Fetch trainees assigned to the logged-in supervisor
        $trainees = Trainee::where('supervisor_id', Auth::id())->get();

        // NOTE: This currently triggers a "View not found" error because the file is missing 
        return view('supervisor.trainees', compact('trainees'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('supervisor.profile_edit', compact('user'));
    }

    public function tasks()
    {
        return view('supervisor.tasks');
    }
}