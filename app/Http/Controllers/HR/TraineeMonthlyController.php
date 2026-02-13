<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\MonthlySubmission;
use App\Models\SystemSetting;
use App\Models\Trainee;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TraineeMonthlyController extends Controller
{
    /**
     * HR view of trainee monthly attendance.
     * Step 1: Choose time period
     * Step 2: Choose active trainee
     * Step 3: View calendar-style info + export PDF
     */
    public function index(Request $request)
    {
        $month = $request->get('month');
        $year  = $request->get('year');
        $selectedTraineeId = $request->get('trainee_id');

        $periodChosen = $month && $year;

        $trainees = collect();
        $inactiveTrainees = collect();
        $selectedTrainee = null;
        $traineeRecords  = collect();
        $calendarByDate  = collect();
        $selectedDate    = $periodChosen ? Carbon::create((int) $year, (int) $month, 1) : null;

        // Fetch unread monthly submissions for notifications
        $unreadSubmissions = MonthlySubmission::where('is_read', false)
            ->with('trainee')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($periodChosen) {
            $month = (int) $month;
            $year  = (int) $year;

            // Step 2: active trainees only (main list)
            $trainees = Trainee::where('status', 'active')
                ->with('supervisor')
                ->orderBy('name')
                ->get()
                ->map(function ($trainee) use ($month, $year) {
                    $records = Attendance::where('trainee_id', $trainee->id)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->get();

                    $trainee->monthly_records_count = $records->count();
                    $trainee->monthly_approved_count = $records->where('status', 'approved')->count();

                    // Check if this trainee has submitted for this period
                    $submission = MonthlySubmission::where('trainee_id', $trainee->id)
                        ->where('month', $month)
                        ->where('year', $year)
                        ->first();
                    $trainee->has_submitted = $submission !== null;
                    $trainee->submission_is_unread = $submission && !$submission->is_read;

                    return $trainee;
                });

            // Step 2b: inactive/deactivated trainees for reference list
            $inactiveTrainees = Trainee::with(['supervisor', 'user'])
                ->whereHas('user', function ($q) {
                    $q->where('is_active', false);
                })
                ->orderBy('name')
                ->get()
                ->map(function ($trainee) use ($month, $year) {
                    $records = Attendance::where('trainee_id', $trainee->id)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->get();

                    $trainee->monthly_records_count = $records->count();
                    $trainee->monthly_approved_count = $records->where('status', 'approved')->count();

                    $submission = MonthlySubmission::where('trainee_id', $trainee->id)
                        ->where('month', $month)
                        ->where('year', $year)
                        ->first();
                    $trainee->has_submitted = $submission !== null;

                    return $trainee;
                });

            // Step 3: selected trainee (active or inactive) + calendar data
            if ($selectedTraineeId) {
                $selectedTrainee = Trainee::with(['supervisor', 'user'])
                    ->find($selectedTraineeId);

                if ($selectedTrainee) {
                    $traineeRecords = Attendance::where('trainee_id', $selectedTrainee->id)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->orderBy('date', 'asc')
                        ->get();

                    $calendarByDate = $traineeRecords->groupBy(function ($record) {
                        return Carbon::parse($record->date)->toDateString();
                    });

                    // Mark submission as read when HR views the trainee's details
                    MonthlySubmission::where('trainee_id', $selectedTrainee->id)
                        ->where('month', $month)
                        ->where('year', $year)
                        ->update(['is_read' => true]);
                }
            }
        }

        // Get global default rate and company network IPs (for trainee auto-approve on clock-in)
        $globalDefaultRate = (float) SystemSetting::get('allowance_rate_per_day', 30);
        $companyClockInIps = SystemSetting::get('company_clock_in_ips', '');

        return view('hr.submissions.traineemonthly', [
            'periodChosen'      => $periodChosen,
            'trainees'          => $trainees,
            'inactiveTrainees'  => $inactiveTrainees,
            'selectedTrainee'   => $selectedTrainee,
            'traineeRecords'    => $traineeRecords,
            'calendarByDate'    => $calendarByDate,
            'month'             => $month,
            'year'              => $year,
            'selectedDate'      => $selectedDate,
            'selectedTraineeId' => $selectedTraineeId,
            'unreadSubmissions'   => $unreadSubmissions,
            'globalDefaultRate'  => $globalDefaultRate,
            'companyClockInIps'  => $companyClockInIps,
        ]);
    }

    /**
     * Update company network IPs for auto-approve (trainee clock-in on company WiFi).
     * Value: comma-separated IPs or prefixes, e.g. "192.168.1.,10.0.0."
     */
    public function setCompanyNetworkIps(Request $request)
    {
        $validated = $request->validate([
            'ips' => ['nullable', 'string', 'max:500'],
        ]);
        $value = trim($validated['ips'] ?? '');
        SystemSetting::set('company_clock_in_ips', $value);
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Company network IPs updated.']);
        }
        return redirect()->route('hr.submissions.traineeMonthly')->with('success', 'Company network IPs updated.');
    }

    /**
     * Export PDF for a trainee's monthly attendance.
     */
    public function exportPdf(Request $request, $traineeId)
    {
        $month = (int) $request->get('month');
        $year  = (int) $request->get('year');

        if (!$month || !$year) {
            return redirect()->back()->with('error', 'Please choose a month and year before exporting.');
        }

        $trainee = Trainee::with('supervisor')->findOrFail($traineeId);

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

    /**
     * Update global allowance rate for all trainees.
     */
    public function setGlobalRate(Request $request)
    {
        $validated = $request->validate([
            'rate' => ['required', 'numeric', 'min:0', 'max:9999.99'],
        ]);

        SystemSetting::set('allowance_rate_per_day', $validated['rate']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Global allowance rate updated successfully.',
                'rate' => number_format($validated['rate'], 2),
            ]);
        }

        return redirect()
            ->route('hr.submissions.traineeMonthly')
            ->with('success', 'Global allowance rate updated successfully.');
    }
}


