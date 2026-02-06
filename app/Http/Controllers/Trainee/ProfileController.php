<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\Trainee;
use App\Models\TraineeForm;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the trainee's profile.
     */
    public function index()
    {
        // 1. Get the currently authenticated user
        $user = Auth::user();

        // 2. Fetch the trainee record associated with the user's email
        // We use first() to get the actual Trainee object
        $trainee = Trainee::where('email', $user->email)
            ->with(['applicationDetails', 'attendances', 'supervisor'])
            ->first();

        // 3. Initialize variables
        $daysLeft = 0;

        if ($trainee) {
            // 4. Calculate Days Remaining (Whole Number Fix)
            if ($trainee->end_date) {
                $today = now()->startOfDay();
                $end = Carbon::parse($trainee->end_date)->endOfDay();

                // Get difference in days as a whole number
                $diff = $today->diffInDays($end, false);
                
                // Ensure we don't show negative numbers if the date has passed
                $daysLeft = $diff > 0 ? (int)floor($diff) : 0;
            }

            // 5. Add attendance statistics
            $trainee->total_attendances = $trainee->attendances->count();
            $trainee->approved_attendances = $trainee->attendances->where('status', 'approved')->count();
            $trainee->pending_attendances = $trainee->attendances->where('status', 'pending')->count();
            $trainee->rejected_attendances = $trainee->attendances->where('status', 'rejected')->count();
        }

        // 6. Return the view with the trainee data and the calculated days
        return view('trainee.profile', [
            'trainee' => $trainee,
            'daysLeft' => $daysLeft,
        ]);
    }

    /**
     * Show the form for editing the trainee's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $trainee = Trainee::where('email', $user->email)->first();

        return view('trainee.profile-edit', [
            'user' => $user,
            'trainee' => $trainee,
        ]);
    }

    /**
     * Update the trainee's profile information.
     */
    public function update()
    {
        $user = Auth::user();
        $trainee = Trainee::where('email', $user->email)->first();

        // Validate the input
        $validated = request()->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => ['nullable', Password::defaults()],
            'current_password' => ['required_with:password', 'current_password'],
        ]);

        // Update email if changed
        if ($validated['email'] !== $user->email) {
            $user->email = $validated['email'];
            if ($trainee) {
                $trainee->email = $validated['email'];
                $trainee->save();
            }
        }

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('trainee.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the trainee's password.
     */
    public function updatePassword()
    {
        $user = Auth::user();

        $validated = request()->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('trainee.profile')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Update the trainee's personal information and background details.
     */
    public function updatePersonalInfo()
    {
        $user = Auth::user();
        $trainee = Trainee::where('email', $user->email)->first();

        if (!$trainee) {
            return redirect()->route('trainee.profile')
                ->with('error', 'Trainee profile not found.');
        }

        $validated = request()->validate([
            // Personal Information
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:50'],
            // Academic Information
            'institution' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'study_level' => ['required', 'string', 'max:50'],
            'grad_date' => ['required', 'date'],
            // Internship Details
            'duration' => ['required', 'integer', 'min:1'],
            'interest' => ['required', 'string', 'max:255'],
            'coursework_req' => ['required', 'in:yes,no'],
        ]);

        try {
            DB::beginTransaction();

            // Update bank details in trainees table
            $trainee->update([
                'bank_name' => $validated['bank_name'] ?? null,
                'account_number' => $validated['account_number'] ?? null,
            ]);

            // Update all fields in trainee_forms table (applicationDetails)
            $applicationDetails = TraineeForm::where('email', $trainee->email)->first();
            if ($applicationDetails) {
                $applicationDetails->update([
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'institution' => $validated['institution'],
                    'major' => $validated['major'],
                    'study_level' => $validated['study_level'],
                    'grad_date' => $validated['grad_date'],
                    'duration' => $validated['duration'],
                    'interest' => $validated['interest'],
                    'coursework_req' => $validated['coursework_req'],
                ]);
            }

            DB::commit();

            return redirect()->route('trainee.profile')
                ->with('success', 'Personal information updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('trainee.profile')
                ->with('error', 'Failed to update personal information. Please try again.');
        }
    }
}