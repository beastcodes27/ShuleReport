<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = \App\Models\TeacherSubject::with(['user', 'subject', 'schoolClass'])->get();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $teachers = \App\Models\User::where('role', 'teacher')->get();
        $subjects = \App\Models\Subject::all();
        $classes = \App\Models\SchoolClass::all();
        return view('assignments.create', compact('teachers', 'subjects', 'classes'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $existing = \App\Models\TeacherSubject::where('subject_id', $request->subject_id)
            ->where('school_class_id', $request->school_class_id)
            ->first();

        if ($existing && !$request->has('confirm_reassign')) {
            return redirect()->back()
                ->withInput()
                ->with('reassign_warning', [
                    'message' => "This subject is already assigned to {$existing->user->name} in this class. Do you want to move it to the new teacher?",
                    'existing_id' => $existing->id
                ]);
        }

        if ($existing && $request->has('confirm_reassign')) {
            $existing->update(['user_id' => $request->user_id]);
            return redirect()->route('assignments.index')->with('success', 'Assignment moved successfully!');
        }

        \App\Models\TeacherSubject::create($request->all());

        return redirect()->route('assignments.index')->with('success', 'Teacher assigned successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $assignment = \App\Models\TeacherSubject::findOrFail($id);
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment removed successfully!');
    }
}
