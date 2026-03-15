<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = \App\Models\Invitation::orderBy('created_at', 'desc')->get();
        return view('master.invitations.index', compact('invitations'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email|unique:invitations,email',
        ]);

        $token = \Illuminate\Support\Str::random(32);

        \App\Models\Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'role' => 'teacher'
        ]);

        return redirect()->back()->with('success', 'Invitation link generated successfully! Share the generated link with the teacher.');
    }

    public function showRegistrationForm($token)
    {
        $invitation = \App\Models\Invitation::where('token', $token)->whereNull('accepted_at')->firstOrFail();

        return view('auth.invitations.register', compact('invitation'));
    }

    public function register(\Illuminate\Http\Request $request, $token)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $invitation = \App\Models\Invitation::where('token', $token)->whereNull('accepted_at')->firstOrFail();

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $invitation->role,
        ]);

        $invitation->update(['accepted_at' => now()]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/teacher/dashboard')->with('success', 'Registration successful! Welcome to ShuleReport.');
    }
}
