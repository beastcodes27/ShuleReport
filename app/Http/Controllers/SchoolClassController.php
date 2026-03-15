<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = \App\Models\SchoolClass::all();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255'
        ]);

        \App\Models\SchoolClass::create([
            'class_name' => $request->class_name
        ]);

        return redirect()->route('classes.index')->with('success', 'Class added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schoolClass = \App\Models\SchoolClass::findOrFail($id);
        $schoolClass->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully!');
    }
}
