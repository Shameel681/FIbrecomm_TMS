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
        // Fetch trainees assigned to the logged-in supervisor with all related data
        $trainees = Trainee::where('supervisor_id', Auth::id())
            ->with(['applicationDetails', 'attendances'])
            ->get()
            ->map(function ($trainee) {
                // Add attendance statistics
                $trainee->total_attendances = $trainee->attendances->count();
                $trainee->approved_attendances = $trainee->attendances->where('status', 'approved')->count();
                $trainee->pending_attendances = $trainee->attendances->where('status', 'pending')->count();
                $trainee->rejected_attendances = $trainee->attendances->where('status', 'rejected')->count();
                
                // Calculate days remaining
                if ($trainee->end_date) {
                    $endDate = \Carbon\Carbon::parse($trainee->end_date)->startOfDay();
                    $now = \Carbon\Carbon::now()->startOfDay();
                    $trainee->days_remaining = max(0, (int) $now->diffInDays($endDate, false));
                } else {
                    $trainee->days_remaining = null;
                }
                
                return $trainee;
            });

        return view('supervisor.trainees', compact('trainees'));
    }

    public function tasks()
    {
        return view('supervisor.tasks');
    }
}