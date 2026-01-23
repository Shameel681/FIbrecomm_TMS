<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TraineeDashboardController extends Controller
{
    public function index()
    {
        // FIX: Use the standard web guard to get the User, then access the trainee profile
        $user = Auth::user();
        
        // Safety check: ensure this user actually has a trainee profile linked
        if (!$user->trainee) {
            abort(403, 'User is not linked to a Trainee profile.');
        }

        $trainee = $user->trainee;
        
        // Calculate days remaining in internship
        $daysLeft = 0;
        if ($trainee->end_date) {
            $end = Carbon::parse($trainee->end_date);
            // 'false' ensures we get a positive/negative number, not absolute
            $diff = now()->diffInDays($end, false); 
            $daysLeft = $diff > 0 ? $diff : 0;
        }

        return view('trainee.dashboard', [
            'trainee' => $trainee,
            'daysLeft' => $daysLeft,
        ]);
    }
}