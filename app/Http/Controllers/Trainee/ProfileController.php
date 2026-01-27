<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\Trainee;
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
        $trainee = Trainee::where('email', $user->email)->first();

        // 3. Initialize variables
        $daysLeft = 0;

        if ($trainee) {
            // 4. Load the relationship for the "Background Info" section
            $trainee->load('applicationDetails');

            // 5. Calculate Days Remaining (Whole Number Fix)
            if ($trainee->end_date) {
                $today = now()->startOfDay();
                $end = Carbon::parse($trainee->end_date)->endOfDay();

                // Get difference in days as a whole number
                $diff = $today->diffInDays($end, false);
                
                // Ensure we don't show negative numbers if the date has passed
                $daysLeft = $diff > 0 ? (int)floor($diff) : 0;
            }
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
}