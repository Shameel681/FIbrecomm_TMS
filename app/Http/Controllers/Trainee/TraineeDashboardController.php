<?php
namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TraineeDashboardController extends Controller
{
    public function index()
    {
        $trainee = Auth::guard('trainee')->user();
        
        // Calculate days remaining in internship
        $end = Carbon::parse($trainee->end_date);
        $daysLeft = now()->diffInDays($end, false);

        return view('trainee.dashboard', [
            'trainee' => $trainee,
            'daysLeft' => $daysLeft > 0 ? $daysLeft : 0,
        ]);
    }
}