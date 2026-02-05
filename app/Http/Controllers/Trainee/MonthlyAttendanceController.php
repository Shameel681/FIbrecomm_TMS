<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\MonthlySubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MonthlyAttendanceController extends Controller
{
    /**
     * Show trainee monthly attendance summary in calendar form.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $trainee = $user->trainee ?? null;

        if (!$trainee) {
            abort(403, 'User is not linked to a Trainee profile.');
        }

        // Default to last month for reporting
        $target = Carbon::now()->subMonth();
        $month = (int) $request->get('month', $target->month);
        $year  = (int) $request->get('year', $target->year);

        $records = Attendance::where('trainee_id', $trainee->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        $approvedCount = $records->where('status', 'approved')->count();

        // Build calendar-style grouping by date
        $calendarByDate = $records->groupBy(function ($record) {
            return Carbon::parse($record->date)->toDateString();
        });

        return view('trainee.submit.monthly', [
            'trainee'       => $trainee,
            'records'       => $records,
            'approvedCount' => $approvedCount,
            'month'         => $month,
            'year'          => $year,
            'targetDate'    => Carbon::create($year, $month, 1),
            'calendarByDate'=> $calendarByDate,
        ]);
    }

    /**
     * Submit monthly attendance report to HR.
     * Creates a submission record that HR will be notified about.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $trainee = $user->trainee ?? null;

        if (!$trainee) {
            abort(403, 'User is not linked to a Trainee profile.');
        }

        $month = (int) $request->get('month');
        $year  = (int) $request->get('year');

        if (!$month || !$year) {
            return redirect()->back()->with('error', 'Please select a month and year before submitting.');
        }

        // Create or update monthly submission record
        MonthlySubmission::updateOrCreate(
            [
                'trainee_id' => $trainee->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'is_read' => false, // Mark as unread for HR notification
            ]
        );

        return redirect()
            ->route('trainee.monthly.index', [
                'month' => $month,
                'year'  => $year,
            ])
            ->with('success', 'Monthly attendance report has been sent to HR for processing.');
    }

    /**
     * Export the trainee's own monthly attendance as PDF
     * using the same layout as HR.
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $trainee = $user->trainee ?? null;

        if (!$trainee) {
            abort(403, 'User is not linked to a Trainee profile.');
        }

        $month = (int) $request->get('month');
        $year  = (int) $request->get('year');

        if (!$month || !$year) {
            return redirect()->back()->with('error', 'Please choose a month and year before exporting.');
        }

        $records = Attendance::where('trainee_id', $trainee->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        $selectedDate = Carbon::create($year, $month, 1);

        $pdf = Pdf::loadView('hr.submissions.trainee_monthly_pdf', [
            'trainee'      => $trainee,
            'records'      => $records,
            'selectedDate' => $selectedDate,
        ])->setPaper('a4', 'portrait');

        $fileName = 'My_Attendance_'.$selectedDate->format('M_Y').'.pdf';

        return $pdf->download($fileName);
    }
}

