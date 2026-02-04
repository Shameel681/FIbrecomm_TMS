<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\TraineeForm;
use App\Models\Supervisor; 
use App\Models\HR; 
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\ApplicantApproved;
use App\Mail\ApplicantRejected;
use App\Mail\TraineeAccountCreated; 
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SupervisorAssignedMail;
use App\Mail\TraineeAssignedMail;

class HRDashboardController extends Controller
{
    /**
     * Display HR Dashboard stats.
     */
    public function index()
    {
        return view('hr.dashboard', [
            'totalTrainees' => Trainee::count(),
            'totalApplicants' => TraineeForm::count(),
            'totalSupervisors' => Supervisor::count(),
            'totalHR' => HR::count(),
        ]);
    }

    /**
     * Display the list of applicants (ONLY PENDING).
     */
    public function applicants()
    {
        $applicants = TraineeForm::where(function($query) {
            $query->where('status', 'pending')
                  ->orWhereNull('status');
        })->latest()->get();

        return view('hr.applicants', compact('applicants'));
    }

    /**
     * Show details of a specific application (AJAX/Modal).
     */
    public function show($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        $applicant->update(['is_read' => true]);
        return response()->json($applicant);
    }

    /**
     * Move applicant to "Approved" status and send offer email.
     */
    public function approve($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        $hr = Auth::user(); 

        Mail::to($applicant->email)->send(new ApplicantApproved($applicant, $hr->name));

        $applicant->update(['status' => 'approved']);

        return redirect()->route('hr.applicants')->with('success', 'Applicant approved! They have been moved to Trainee Management.');
    } 

    /**
     * Reject applicant, delete their files, and remove record.
     */
    public function reject($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        $hr = Auth::user();

        Mail::to($applicant->email)->send(new ApplicantRejected($applicant, $hr->name));

        // Delete uploaded documents from storage
        if ($applicant->cv_path) Storage::disk('public')->delete($applicant->cv_path);
        if ($applicant->uni_letter_path) Storage::disk('public')->delete($applicant->uni_letter_path);
        
        $applicant->delete();

        return redirect()->route('hr.applicants')->with('info', 'Application rejected.');
    }

    /**
     * Download application details as PDF.
     */
    public function downloadApplicantForm($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        $pdf = Pdf::loadView('pdf.applicant_form', compact('applicant'));
        return $pdf->download('Form_' . str_replace(' ', '_', $applicant->full_name) . '.pdf');
    }

    /**
     * Download CV file.
     */
    public function downloadCV($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        if ($applicant->cv_path && Storage::disk('public')->exists($applicant->cv_path)) {
            return Storage::disk('public')->download($applicant->cv_path);
        }
        return back()->with('error', 'CV file not found.');
    }

    /**
     * Download University Letter.
     */
    public function downloadLetter($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        if ($applicant->uni_letter_path && Storage::disk('public')->exists($applicant->uni_letter_path)) {
            return Storage::disk('public')->download($applicant->uni_letter_path);
        }
        return back()->with('error', 'University letter not found.');
    }

    /**
     * Permanently delete an application.
     */
    public function destroy($id)
    {
        $applicant = TraineeForm::findOrFail($id);
        if ($applicant->cv_path) Storage::disk('public')->delete($applicant->cv_path);
        if ($applicant->uni_letter_path) Storage::disk('public')->delete($applicant->uni_letter_path);
        $applicant->delete();
        return redirect()->route('hr.applicants')->with('success', 'Application deleted.');
    }

    /**
     * Manage Trainees page: Active list and Onboarding queue.
     */
    public function manageTrainees()
    {
        $now = now();
        $totalRegistered = Trainee::count();
        
        // Count active based on status and dates
        $activeCount = Trainee::where('status', 'active')
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->count();

        $trainees = Trainee::orderBy('start_date', 'desc')->get();
        
        // Approved applicants who need accounts created
        $onboardingQueue = TraineeForm::where('status', 'approved')->latest()->get();

        return view('hr.trainees', compact('activeCount', 'totalRegistered', 'trainees', 'onboardingQueue'));
    }

    /**
     * Finalize onboarding: Create User record and linked Trainee profile.
     */
    public function storeAccount(Request $request)
{
    $request->validate([
        'applicant_id' => 'required|exists:trainee_forms,id',
        'name'         => 'required|string|max:255',
        'email'        => 'required|email',
        'start_date'   => 'required',
        'end_date'     => 'required',
    ]);

    try {
        DB::beginTransaction();

        $tempPassword = 'internship2026';

        // 1. Fetch the applicant record to pass to the email
        $traineeForm = TraineeForm::findOrFail($request->applicant_id);

        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($tempPassword),
                'role' => 'trainee'
            ]
        );

        Trainee::create([
            'user_id'    => $user->id,
            'name'       => $request->name,
            'email'      => $request->email,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => 'active',
        ]);

        $traineeForm->update(['status' => 'onboarded']);

        // 2. Pass the $traineeForm record to the mailer
        Mail::to($user->email)->send(new TraineeAccountCreated($user, $tempPassword, $traineeForm));

        DB::commit();

        return redirect()->route('hr.trainees')->with('success', 'Account created and email sent to trainee!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Onboarding Error: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Creation failed: ' . $e->getMessage()]);
    }
}

public function showAssignPage()
{
    // Fetch all trainees with their current supervisor
    $trainees = Trainee::with('supervisor')->get();

    // All supervisor user accounts
    $supervisors = User::where('role', 'supervisor')->get();

    // Supervisors that are already linked to any trainee (one trainee per supervisor rule)
    $assignedSupervisorIds = Trainee::whereNotNull('supervisor_id')
        ->pluck('supervisor_id')
        ->toArray();

    return view('hr.assign-supervisor', compact('trainees', 'supervisors', 'assignedSupervisorIds'));
}

public function assignSupervisor(Request $request, $id)
{
    $request->validate([
        'supervisor_id' => ['required', 'exists:users,id'],
    ]);

    $trainee = Trainee::findOrFail($id);
    $supervisor = User::where('role', 'supervisor')->findOrFail($request->supervisor_id);

    // Enforce: one trainee per supervisor.
    $alreadyHasTrainee = Trainee::where('supervisor_id', $supervisor->id)
        ->where('id', '!=', $trainee->id)
        ->exists();

    if ($alreadyHasTrainee) {
        return back()->with('error', 'This supervisor is already assigned to another trainee.');
    }

    // Update the trainee's supervisor assignment
    $trainee->update([
        'supervisor_id' => $supervisor->id,
    ]);

    // Notify both parties
    Mail::to($supervisor->email)->send(new SupervisorAssignedMail($trainee, $supervisor));
    Mail::to($trainee->email)->send(new TraineeAssignedMail($trainee, $supervisor));

    return back()->with('success', 'Supervisor assigned and notifications sent successfully!');
}
}