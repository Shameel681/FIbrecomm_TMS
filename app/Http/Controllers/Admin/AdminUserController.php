<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HR;
use App\Models\Supervisor;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->get();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,hr,supervisor,trainee',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create Login Account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'), // Default password
                'role' => $request->role,
            ]);

            // 2. Create the Specific Profile based on role
            if ($request->role === 'hr') {
                HR::create(['user_id' => $user->id, 'name' => $request->name]);
            } elseif ($request->role === 'supervisor') {
                Supervisor::create(['user_id' => $user->id, 'name' => $request->name, 'email' => $request->email]);
            } elseif ($request->role === 'trainee') {
                Trainee::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addMonths(3),
                ]);
            }

            DB::commit();
            return back()->with('success', 'User and Profile created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Creation failed: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Note: If you set up cascading deletes in migration, profiles will delete automatically
        $user->delete();
        return back()->with('success', 'User account removed.');
    }
}