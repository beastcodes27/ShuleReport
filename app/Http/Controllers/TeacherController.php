<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $teachers = User::where('role', 'teacher')
            ->withCount('teacherSubjects')
            ->when($search, fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->get();

        return view('master.teachers.index', compact('teachers', 'search'));
    }

    public function create()
    {
        return view('master.teachers.create');
    }    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'teacher',
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher account created successfully!');
    }

    public function edit(string $id)
    {
        $teacher = User::findOrFail($id);

        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        return view('master.teachers.edit', compact('teacher'));
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function update(Request $request, string $id)
    {
        $teacher = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($teacher->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', "Teacher {$teacher->name} updated successfully!");
    }

    public function destroy(string $id)
    {
        $teacher = User::findOrFail($id);

        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        $assignments = TeacherSubject::where('user_id', $teacher->id)->count();
        TeacherSubject::where('user_id', $teacher->id)->delete();
        $teacher->delete();

        $message = "Teacher {$teacher->name} deleted successfully.";
        if ($assignments > 0) {
            $message .= " {$assignments} subject assignment(s) removed.";
        }

        return redirect()->route('teachers.index')->with('success', $message);
    }
}
