<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $assignments = \App\Models\TeacherSubject::with(['schoolClass', 'subject'])
            ->where('user_id', '=', auth()->id())
            ->get();
            
        return view('teacher.dashboard', compact('assignments'));
    }
}
