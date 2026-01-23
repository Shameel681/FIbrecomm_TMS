<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Trainee View: Show Clock-In button and History
     */
    public function index(Request $request)
    {
        // 1. Get the currently logged-in User's linked Trainee profile
        $user = Auth::user();
        $trainee = $user->trainee;

        // Safety: If for some reason a non-trainee accesses this
        if (!$trainee) {
            return redirect()->back()->with('error', 'No Trainee profile found for this user.');
        }

        // 2. Check if they already clocked in TODAY
        $today = Carbon::today()->toDateString();
        $todayRecord = Attendance::where('trainee_id', $trainee->id)
                                 ->where('date', $today)
                                 ->first();

        // 3. History Filtering Logic (Step 7)
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $history = Attendance::where('trainee_id', $trainee->id)
                             ->whereMonth('date', $month)
                             ->whereYear('date', $year)
                             ->with('approver') // Optimize query
                             ->orderBy('date', 'desc')
                             ->paginate(10);

        return view('trainee.attendance.index', compact('todayRecord', 'history', 'month', 'year'));
    }

    /**
     * Trainee Action: Clock In
     */
    public function clockIn(Request $request)
    {
        $trainee = Auth::user()->trainee;
        $today = now()->toDateString();

        // VALIDATION 1: Supervisor Assignment
        // We check the 'supervisor_id' column in the trainees table
        if (!$trainee->supervisor_id) {
            return back()->with('error', 'You cannot clock in yet. Please wait for HR to assign your supervisor.');
        }

        // VALIDATION 2: Prevent Double Clock-In
        $exists = Attendance::where('trainee_id', $trainee->id)
                            ->where('date', $today)
                            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already clocked in for today.');
        }

        // EXECUTION: Create the record
        Attendance::create([
            'trainee_id' => $trainee->id,
            'date' => $today,
            'clock_in' => now()->toTimeString(),
            'status' => 'pending', // Waiting for supervisor
        ]);

        return back()->with('success', 'Clock-in successful! Awaiting supervisor approval.');
    }

    /**
     * Supervisor View: Show list of pending approvals
     */
    public function supervisorIndex()
    {
        $supervisorId = Auth::id(); // The Supervisor is also a User
        
        // Find all attendances where the RELATED Trainee is assigned to THIS Supervisor
        $pendingAttendances = Attendance::whereHas('trainee', function($query) use ($supervisorId) {
            $query->where('supervisor_id', $supervisorId);
        })
        ->where('status', 'pending')
        ->with('trainee') // Eager load to show Trainee Name
        ->orderBy('date', 'desc')
        ->get();

        return view('supervisor.attendance.approvals', compact('pendingAttendances'));
    }

    /**
     * Supervisor Action: Approve
     */
    public function approve($id)
    {
        $attendance = Attendance::findOrFail($id);
        
        // Security: Ensure this supervisor actually owns this trainee
        if($attendance->trainee->supervisor_id != Auth::id()) {
             return back()->with('error', 'Unauthorized action.');
        }

        $attendance->update([
            'status' => 'approved',
            'approved_by' => Auth::id()
        ]);

        return back()->with('success', 'Attendance approved successfully.');
    }

    /**
     * Supervisor Action: Reject
     */
    public function reject(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        if($attendance->trainee->supervisor_id != Auth::id()) {
             return back()->with('error', 'Unauthorized action.');
        }

        $attendance->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'remarks' => $request->remarks // Optional rejection reason
        ]);

        return back()->with('success', 'Attendance rejected.');
    }
}