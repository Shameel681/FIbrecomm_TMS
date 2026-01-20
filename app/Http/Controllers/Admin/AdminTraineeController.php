<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminTraineeController extends Controller
{
    public function index()
    {
        // Fetch all trainees with their user account details
        $trainees = Trainee::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.managetrainee', compact('trainees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'trainee',
            ]);

            Trainee::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'active',
            ]);
        });

        return redirect()->back()->with('success', 'Trainee deployed successfully.');
    }

    public function update(Request $request, $id)
    {
        $trainee = Trainee::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $trainee->user_id,
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required',
        ]);

        DB::transaction(function () use ($request, $trainee) {
            $trainee->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $trainee->update($request->only(['name', 'email', 'start_date', 'end_date', 'status']));
        });

        return redirect()->back()->with('success', 'Personnel file updated.');
    }

    public function destroy($id)
    {
        $trainee = Trainee::findOrFail($id);
        DB::transaction(function () use ($trainee) {
            $trainee->user->delete();
            $trainee->delete();
        });

        return redirect()->back()->with('success', 'Trainee record terminated.');
    }
}