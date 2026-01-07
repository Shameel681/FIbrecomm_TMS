<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraineeForm;
use Illuminate\Support\Facades\Log;

class TraineeFormController extends Controller
{
    /**
     * Handle the internship application submission.
     */
    public function store(Request $request)
    {
        // 1. Validation Logic
        // This ensures all parts of the form are filled out (Requirement 5)
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            
            // Requirement 2: Email must have @ and end with .com
            'email'          => ['required', 'email', 'regex:/^.+@.+\.com$/i'],
            
            // Requirement 1: Phone number 10-11 characters only
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
        ], [
            // Custom error messages for better user experience
            'email.regex' => 'The email address must end with .com',
            'phone.digits_between' => 'The phone number must be between 10 and 11 digits.',
        ]);

        // 2. Requirement 3: Handle "Others" for Level of Study
        // If "others" radio is clicked, we swap the value with the text input
        if ($request->study_level === 'others') {
            $request->validate(['study_level_other' => 'required|string|max:255']);
            $validated['study_level'] = $request->study_level_other;
        }

        // 3. Requirement 4: Handle "Others" for Area of Interest
        // If "Others" is selected in dropdown, we swap the value with the text input
        if ($request->interest === 'Others') {
            $request->validate(['interest_other' => 'required|string|max:255']);
            $validated['interest'] = $request->interest_other;
        }

        // 4. Save to Database
        try {
            // This line triggers the MassAssignmentException if $fillable is not set in the Model
            TraineeForm::create($validated);

            return back()->with('success', 'Your application has been submitted successfully!');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Trainee Form Error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'There was a problem saving your application. Please try again.');
        }
    }
}