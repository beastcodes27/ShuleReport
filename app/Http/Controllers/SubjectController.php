<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = \App\Models\Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:20|unique:subjects',
            'abbreviation' => 'required|string|max:10'
        ]);

        \App\Models\Subject::create([
            'subject_name' => $request->subject_name,
            'subject_code' => $request->subject_code,
            'abbreviation' => $request->abbreviation
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $subject = \App\Models\Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $subject = \App\Models\Subject::findOrFail($id);

        $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code,' . $id,
            'abbreviation' => 'required|string|max:10'
        ]);

        $subject->update([
            'subject_name' => $request->subject_name,
            'subject_code' => $request->subject_code,
            'abbreviation' => $request->abbreviation
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
    }

    public function destroy(string $id)
    {
        $subject = \App\Models\Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully!');
    }
}
