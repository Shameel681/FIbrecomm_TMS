<?php
namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\Trainee;
use Illuminate\Http\Request;

class ManageSupervisorController extends Controller
{
    public function index()
    {
        // Fetch only supervisors who currently have NO trainees assigned
        $availableSVs = Supervisor::doesntHave('trainees')->get();
        
        // Fetch trainees who do not have a supervisor yet
        $unassignedTrainees = Trainee::whereNull('supervisor_id')->get();

        return view('hr.managesv', compact('availableSVs', 'unassignedTrainees'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:supervisors,id',
            'trainee_id' => 'required|exists:trainees,id',
        ]);

        $trainee = Trainee::findOrFail($request->trainee_id);
        $trainee->update(['supervisor_id' => $request->supervisor_id]);

        return back()->with('success', 'Trainee assigned successfully!');
    }
}