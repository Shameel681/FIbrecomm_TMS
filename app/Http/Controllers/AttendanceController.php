<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\SystemSetting;
use App\Models\Trainee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OutsideClockInPendingMail;

class AttendanceController extends Controller
{
    /**
     * Check if the request IP is considered "on company network" for auto-approve.
     * Uses system setting "company_clock_in_ips": comma-separated IPs or prefixes (e.g. "192.168.1.,10.0.0.").
     */
    private static function isOnCompanyNetwork(string $clientIp): bool
    {
        $allowed = SystemSetting::get('company_clock_in_ips', '');
        if ($allowed === '') {
            return false;
        }
        $list = array_map('trim', explode(',', $allowed));
        foreach ($list as $entry) {
            if ($entry === $clientIp) {
                return true;
            }
            if (str_ends_with($entry, '.') && str_starts_with($clientIp, $entry)) {
                return true;
            }
            if (!str_ends_with($entry, '.') && str_starts_with($clientIp, $entry . '.')) {
                return true;
            }
        }
        return false;
    }
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

        // Fetch rejected attendances with remarks (for inbox)
        $rejectedAttendances = Attendance::where('trainee_id', $trainee->id)
                                        ->where('status', 'rejected')
                                        ->whereNotNull('remarks')
                                        ->with('approver')
                                        ->orderBy('date', 'desc')
                                        ->orderBy('updated_at', 'desc')
                                        ->limit(10)
                                        ->get();

        return view('trainee.attendance.index', compact('todayRecord', 'history', 'month', 'year', 'rejectedAttendances'));
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

        // VALIDATION 2: Prevent double clock-in unless today's record is rejected (allow resubmit)
        $todayRecord = Attendance::where('trainee_id', $trainee->id)
                                 ->where('date', $today)
                                 ->first();

        if ($todayRecord && $todayRecord->status !== 'rejected') {
            return back()->with('error', 'You have already clocked in for today.');
        }

        // VALIDATION 3: Require trainee remarks
        $validated = $request->validate([
            'trainee_remark' => ['required', 'string', 'min:5', 'max:500'],
            'client_ip'      => ['nullable', 'string', 'max:45'], // IPv4 or IPv6 from api.ipify.org
        ]);

        // Use trainee's IP from api.ipify.org (sent by frontend) if valid, else fall back to request IP
        $clientIp = $request->input('client_ip');
        if (!$clientIp || !preg_match('/^[a-fA-F0-9.:]+$/', $clientIp)) {
            $clientIp = $request->ip() ?? '';
        }
        $onCompanyNetwork = self::isOnCompanyNetwork($clientIp);

        if ($todayRecord && $todayRecord->status === 'rejected') {
            // Resubmit: update the rejected record and send again for approval (or auto-approve if on network)
            $todayRecord->update([
                'clock_in'         => now()->toTimeString(),
                'status'           => $onCompanyNetwork ? 'approved' : 'pending',
                'is_auto_approved' => $onCompanyNetwork,
                'approved_by'      => null,
                'remarks'          => null,
                'trainee_remark'   => $validated['trainee_remark'],
            ]);
            if ($onCompanyNetwork) {
                return back()->with('success', 'Resubmission successful! You are on company network — attendance has been auto-approved.');
            }
            $trainee->load('supervisor');
            if ($trainee->supervisor && $trainee->supervisor->email) {
                Mail::to($trainee->supervisor->email)->send(new OutsideClockInPendingMail($trainee, $trainee->supervisor, $todayRecord->fresh()));
            }
            return back()->with('success', 'Attendance resubmitted. Your supervisor will review this request again.');
        }

        if ($onCompanyNetwork) {
            Attendance::create([
                'trainee_id'       => $trainee->id,
                'date'             => $today,
                'clock_in'         => now()->toTimeString(),
                'status'           => 'approved',
                'is_auto_approved' => true,
                'approved_by'      => null,
                'trainee_remark'   => $validated['trainee_remark'],
            ]);
            return back()->with('success', 'Clock-in successful! You are on company network — attendance has been auto-approved.');
        }

        // Outside clock-in: needs supervisor approval
        $attendance = Attendance::create([
            'trainee_id'       => $trainee->id,
            'date'             => $today,
            'clock_in'         => now()->toTimeString(),
            'status'           => 'pending',
            'is_auto_approved' => false,
            'trainee_remark'   => $validated['trainee_remark'],
        ]);

        $trainee->load('supervisor');
        if ($trainee->supervisor && $trainee->supervisor->email) {
            Mail::to($trainee->supervisor->email)->send(new OutsideClockInPendingMail($trainee, $trainee->supervisor, $attendance));
        }

        return back()->with('success', 'Clock-in recorded. You are outside company network — your supervisor will review and approve this request.');
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
        ->with(['trainee', 'trainee.user'])
        ->orderBy('date', 'desc')
        ->get();

        // Fetch all assigned trainees with their attendance data for calendar view
        $assignedTrainees = Trainee::where('supervisor_id', $supervisorId)
            ->with(['attendances', 'user'])
            ->get()
            ->map(function ($trainee) {
                // Group attendances by date
                $trainee->calendarByDate = $trainee->attendances->groupBy(function ($attendance) {
                    return Carbon::parse($attendance->date)->toDateString();
                });
                
                // Parse start and end dates
                $trainee->startDate = $trainee->start_date ? Carbon::parse($trainee->start_date) : null;
                $trainee->endDate = $trainee->end_date ? Carbon::parse($trainee->end_date) : null;
                
                return $trainee;
            });

        return view('supervisor.attendance.approvals', compact('pendingAttendances', 'assignedTrainees'));
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

        // Validate that remarks are required
        $validated = $request->validate([
            'remarks' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        $attendance->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'remarks' => $validated['remarks']
        ]);

        return back()->with('success', 'Attendance rejected.');
    }

    /**
     * Supervisor Action: Export a trainee's monthly attendance summary as PDF.
     * Uses the same PDF layout as HR / Trainee monthly exports.
     */
    public function exportMonthlyPdf(Request $request, Trainee $trainee)
    {
        $supervisorId = Auth::id();

        // Only allow export if this trainee is actually assigned to the logged-in supervisor
        if ((int) $trainee->supervisor_id !== (int) $supervisorId) {
            abort(403, 'You are not authorized to export this trainee\'s attendance.');
        }

        $month = (int) $request->get('month');
        $year  = (int) $request->get('year');

        if (!$month || !$year) {
            return redirect()
                ->back()
                ->with('error', 'Please select a month before exporting the summary.');
        }

        $records = Attendance::where('trainee_id', $trainee->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        $selectedDate = Carbon::create($year, $month, 1);

        // Use global system setting for default rate
        $allowanceRate = (float) SystemSetting::get('allowance_rate_per_day', 30);

        $pdf = Pdf::loadView('hr.submissions.trainee_monthly_pdf', [
            'trainee'       => $trainee,
            'records'       => $records,
            'selectedDate'  => $selectedDate,
            'allowanceRate' => $allowanceRate,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Trainee_Attendance_'.$trainee->name.'_'.$selectedDate->format('M_Y').'.pdf';

        return $pdf->download($fileName);
    }
}