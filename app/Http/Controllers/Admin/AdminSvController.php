<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSvController extends Controller
{
    public function manageSv()
    {
    // Change svProfile to supervisorProfile to match your User Model
    $svs = User::where('role', 'supervisor')
        ->with('supervisorProfile') 
        ->latest()
        ->get();

    return view('admin.managesv', compact('svs'));
    }

    public function storeSv(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'employee_id' => 'required|string|unique:supervisors,employee_id',
        ]);

        try {
            DB::beginTransaction();

            // 2. Create the main User account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'supervisor',
            ]);

            // 3. Create the Supervisor Profile
            // This matches the HR table logic you requested
            Supervisor::create([
                'user_id'     => $user->id,
                'employee_id' => $request->employee_id, // Passed from form
                'name'        => $request->name,
                'email'       => $request->email,
                'password'    => 'linked_to_users_table',
                'department'  => 'General', 
                'position'    => 'Supervisor',
            ]);

            DB::commit();
            return back()->with('success', 'Supervisor deployed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // This will now catch and show details if the database rejects the insert
            return back()->with('error', 'Failed to create SV: ' . $e->getMessage());
        }
    }

    public function updateSv(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Handle the unique validation for employee_id safely
        $profileId = $user->svProfile ? $user->svProfile->id : null;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8',
            'employee_id' => 'required|string|unique:supervisors,employee_id,'.$profileId,
        ]);

        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Use updateOrCreate to sync the user_id with the profile details
            Supervisor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_id' => $request->employee_id,
                    'name'        => $request->name,
                    'email'       => $request->email
                ]
            );

            DB::commit();
            return back()->with('success', 'Supervisor records updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroySv($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            
            Supervisor::where('user_id', $user->id)->delete();
            $user->delete();
            
            DB::commit();
            return back()->with('success', 'Supervisor account removed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Deletion failed.');
        }
    }
}