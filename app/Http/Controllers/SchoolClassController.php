<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::withCount('students')->orderBy('class_name')->get();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateClass($request);

        SchoolClass::create($data);

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
        $schoolClass = SchoolClass::findOrFail($id);

        return view('classes.edit', compact('schoolClass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);

        $data = $this->validateClass($request, $schoolClass->id);

        $schoolClass->update($data);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully!');
    }

    protected function validateClass(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'class_name' => 'required|string|max:255',
            'stream' => 'nullable|string|max:20',
            'combination' => 'nullable|string|max:20',
        ]);

        $data['class_name'] = trim($data['class_name'] ?? '');
        $data['stream'] = !empty(trim((string) ($data['stream'] ?? ''))) ? strtoupper(trim($data['stream'])) : null;
        $data['combination'] = !empty(trim((string) ($data['combination'] ?? ''))) ? strtoupper(trim($data['combination'])) : null;

        $isALevel = $this->isALevel($data['class_name']);

        // Only A-Level (Form 5/6) classes carry a combination, and it is required there.
        if ($isALevel && !$data['combination']) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'combination' => 'A combination is required for A-Level (Form 5/6) classes.',
            ]);
        }

        if (!$isALevel) {
            $data['combination'] = null;
        }

        $exists = SchoolClass::where('class_name', $data['class_name'])
            ->where('stream', $data['stream'])
            ->where('combination', $data['combination'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'class_name' => 'A class with this level, stream and combination already exists.',
            ]);
        }

        return $data;
    }

    protected function isALevel(string $className): bool
    {
        $name = strtolower($className);
        $name = preg_replace('/\bform\s*(five|v)\b/', 'form 5', $name);
        $name = preg_replace('/\bform\s*(six|vi)\b/', 'form 6', $name);

        return (bool) preg_match('/\bform\s*[56]\b/', $name);
    }
}
