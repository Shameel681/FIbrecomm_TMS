<?php
namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Trainee; // Assuming trainees are linked to SV

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        // For now, we'll just show a count of all trainees
        // Later you can filter this by: where('supervisor_id', Auth::id())
        $traineeCount = Trainee::count(); 

        return view('supervisor.dashboard', compact('traineeCount'));
    }
}