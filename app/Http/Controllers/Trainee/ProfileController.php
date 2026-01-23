<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
}