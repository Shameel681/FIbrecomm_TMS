<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TraineeDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Safety check: ensure user has a trainee profile
        // This prevents the "Attempt to read property on null" error in image_11ad8e.png
        if (!$user || !$user->trainee) {
            abort(403, 'User is not linked to a Trainee profile.');
        }

        $trainee = $user->trainee;
        
        // Calculate days remaining in internship
        $daysLeft = 0;
        
        if ($trainee->end_date) {
            $end = Carbon::parse($trainee->end_date)->endOfDay();
            $today = now()->startOfDay();

            // Use diffInDays without the false parameter to get a clean whole number
            // or use floor() to remove decimals.
            $diff = $today->diffInDays($end, false); 
            
            // FIX: Use floor to ensure no decimals (e.g., 131 instead of 131.61)
            $daysLeft = $diff > 0 ? floor($diff) : 0;
        }

        return view('trainee.dashboard', [
            'trainee' => $trainee,
            'daysLeft' => (int) $daysLeft, // Cast to int for extra safety
        ]);
    }
}