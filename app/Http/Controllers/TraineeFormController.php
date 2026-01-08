<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraineeForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TraineeFormController extends Controller
{
    /**
     * Handle the internship application submission.
     */
    public function store(Request $request)
    {
        // 1. Validation Logic
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => ['required', 'email', 'regex:/^.+@.+\.com$/i'],
            'phone'          => 'required|digits_between:10,11',
            'address'        => 'required|string',
            'institution'    => 'required|string',
            'major'          => 'required|string',
            'study_level'    => 'required|string',
            'grad_date'      => 'required|date',
            'duration'       => 'required|numeric',
            'start_date'     => 'required|date',
            'interest'       => 'required|string',
            'coursework_req' => 'required|in:yes,no',
            
            // Validation for the new files (Requirement 13 & 14)
            'cv_file'        => 'required|mimes:pdf|max:2048', 
            'uni_letter'     => 'required|mimes:pdf|max:2048',
        ], [
            'email.regex' => 'The email address must end with .com',
            'phone.digits_between' => 'The phone number must be between 10 and 11 digits.',
            'cv_file.required' => 'Please upload your CV/Resume.',
            'uni_letter.required' => 'Please upload your University Letter.',
        ]);

        // 2. Handle "Others" for Level of Study
        if ($request->study_level === 'others') {
            $request->validate(['study_level_other' => 'required|string|max:255']);
            $validated['study_level'] = $request->study_level_other;
        }

        // 3. Handle "Others" for Area of Interest
        if ($request->interest === 'Others') {
            $request->validate(['interest_other' => 'required|string|max:255']);
            $validated['interest'] = $request->interest_other;
        }

        try {
            // 4. Handle File Uploads
            // Store files in 'public/uploads' and save the path string to the database
            if ($request->hasFile('cv_file')) {
                $validated['cv_path'] = $request->file('cv_file')->store('uploads/cvs', 'public');
            }

            if ($request->hasFile('uni_letter')) {
                $validated['uni_letter_path'] = $request->file('uni_letter')->store('uploads/letters', 'public');
            }

            // 5. Save to Database
            TraineeForm::create($validated);

            return back()->with('success', 'Your application and documents have been submitted successfully!');
            
        } catch (\Exception $e) {
            Log::error('Trainee Form Error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'There was a problem saving your application. Please try again.');
        }
    }
}