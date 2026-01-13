<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\TraineeForm;
use App\Models\Supervisor; 
use App\Models\HR; 
use App\Models\User; // Added to support manageTrainees logic
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class HRDashboardController extends Controller
{
    public function index()
    {
        return view('hr.dashboard', [
            'totalTrainees' => TraineeForm::count(),
            'totalApplicants' => TraineeForm::count(),
            'totalSupervisors' => Supervisor::count(),
            'totalHR' => HR::count(),
        ]);
    }

    public function applicants()
    {
        $applicants = TraineeForm::latest()->get();
        return view('hr.applicants', compact('applicants'));
    }

    public function show($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        $applicant->update(['is_read' => true]);
        return response()->json($applicant);
    }

    public function downloadApplicantForm($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        $pdf = Pdf::loadView('pdf.applicant_form', compact('applicant'));
        return $pdf->download('Form_' . str_replace(' ', '_', $applicant->full_name) . '.pdf');
    }

    public function downloadCV($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        if ($applicant->cv_path && Storage::disk('public')->exists($applicant->cv_path)) {
            return Storage::disk('public')->download($applicant->cv_path);
        }
        return back()->with('error', 'CV file not found.');
    }

    public function downloadLetter($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        if ($applicant->uni_letter_path && Storage::disk('public')->exists($applicant->uni_letter_path)) {
            return Storage::disk('public')->download($applicant->uni_letter_path);
        }
        return back()->with('error', 'University letter not found.');
    }

    public function destroy($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        
        // Optional: Delete associated files from storage if they exist
        if ($applicant->cv_path) Storage::disk('public')->delete($applicant->cv_path);
        if ($applicant->uni_letter_path) Storage::disk('public')->delete($applicant->uni_letter_path);
        
        $applicant->delete();

        return redirect()->route('hr.applicants')->with('success', 'Application deleted successfully.');
    }

    /**
     * Manage Registered Trainees (Active Interns)
     */
    public function manageTrainees()
    {
    $now = now();
    
    // Total registered accounts from the trainees table
    $totalRegistered = \App\Models\Trainee::count();

    // Active means today is between their start_date and end_date
    $activeCount = \App\Models\Trainee::whereDate('start_date', '<=', $now)
        ->whereDate('end_date', '>=', $now)
        ->count();

    // Get all trainees for the list
    $trainees = \App\Models\Trainee::orderBy('start_date', 'desc')->get();

    return view('hr.trainees', compact('activeCount', 'totalRegistered', 'trainees'));
    }
}