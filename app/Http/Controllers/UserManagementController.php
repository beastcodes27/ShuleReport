<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('super_admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:academic_master,academic_department,teacher,super_admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', "Role for {$user->name} updated successfully to " . ucwords(str_replace('_', ' ', $request->role)) . ".");
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'academic_masters' => User::where('role', '=', 'academic_master')->count(),
            'academic_departments' => User::where('role', '=', 'academic_department')->count(),
            'teachers' => User::where('role', '=', 'teacher')->count(),
        ];
        
        return view('super_admin.dashboard', compact('stats'));
    }
}
