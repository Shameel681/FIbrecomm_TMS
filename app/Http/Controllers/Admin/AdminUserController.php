<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HR;
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

    public function manageHr()
    {
        $hrs = User::where('role', 'hr')
            ->with('hrProfile') 
            ->latest()
            ->get();

        return view('admin.managehr', compact('hrs'));
    }

    public function storeHr(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'employee_id' => 'required|string|unique:hrs,employee_id',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create User Login (This is where the real password goes)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'hr',
            ]);

            // 2. Create HR Profile 
            // We pass a dummy string to 'password' to stop the SQL "No Default Value" error
            HR::create([
                'user_id' => $user->id,
                'employee_id' => $request->employee_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => 'linked_to_users_table', 
            ]);

            DB::commit();
            return back()->with('success', 'HR Officer deployed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create HR: ' . $e->getMessage());
        }
    }

    public function updateHr(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'nullable|min:8',
        'employee_id' => 'required|string|unique:hrs,employee_id,'.$user->hrProfile->id,
    ]);

    try {
        DB::beginTransaction();

        // Update User Table
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update HR Table
        HR::where('user_id', $user->id)->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email
        ]);

        DB::commit();

        // IF THE REQUEST IS AJAX (Inline Edit), RETURN JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Updated successfully']);
        }

        return back()->with('success', 'HR information updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
        
        return back()->with('error', 'Update failed: ' . $e->getMessage());
    }
}

    public function destroyHr($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            HR::where('user_id', $user->id)->delete();
            $user->delete();
            DB::commit();
            return back()->with('success', 'HR account removed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Deletion failed.');
        }
    }
}