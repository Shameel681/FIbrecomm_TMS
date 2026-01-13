<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraineeForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TraineeFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'         => 'required|string|max:255',
            'email'             => ['required', 'email', 'regex:/^.+@.+\.com$/i'],
            'phone'             => 'required|digits_between:10,11',
            'address'           => 'required|string',
            'institution'       => 'required|string',
            'major'             => 'required|string',
            'study_level'       => 'required|string',
            'grad_date'         => 'required|date',
            'duration'          => 'required|numeric',
            'start_date'        => 'required|date',
            'expected_end_date' => 'required|date|after:start_date',
            'interest'          => 'required|string',
            'coursework_req'    => 'required|in:yes,no',
            'cv_file'           => 'required|mimes:pdf|max:2048', 
            'uni_letter'        => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->study_level === 'others') { $validated['study_level'] = $request->study_level_other; }
        if ($request->interest === 'Others') { $validated['interest'] = $request->interest_other; }

        try {
            if ($request->hasFile('cv_file')) {
                $validated['cv_path'] = $request->file('cv_file')->store('uploads/cvs', 'public');
            }
            if ($request->hasFile('uni_letter')) {
                $validated['uni_letter_path'] = $request->file('uni_letter')->store('uploads/letters', 'public');
            }

            TraineeForm::create($validated);
            return back()->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Trainee Form Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong.');
        }
    }
}