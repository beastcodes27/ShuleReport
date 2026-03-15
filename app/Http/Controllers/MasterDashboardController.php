<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Mark;

class MasterDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalClasses  = SchoolClass::count();
        $totalSubjects = Subject::count();
        $activeYear    = AcademicYear::where('is_active', true)->first();

        // Pass Rate
        $marks    = Mark::all();
        $passRate = 0;
        if ($marks->count() > 0) {
            $passed   = $marks->where('score', '>=', 40)->count();
            $passRate = round(($passed / $marks->count()) * 100);
        }

        // Grade Distribution (all marks)
        $gradeCounts = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'F' => 0];
        foreach ($marks as $mark) {
            if ($mark->score >= 80)      $gradeCounts['A']++;
            elseif ($mark->score >= 60)  $gradeCounts['B']++;
            elseif ($mark->score >= 40)  $gradeCounts['C']++;
            elseif ($mark->score >= 30)  $gradeCounts['D']++;
            else                         $gradeCounts['F']++;
        }

        // Class Average Scores (for bar chart)
        $classes = SchoolClass::with('students')->get();
        $classLabels   = [];
        $classAverages = [];
        foreach ($classes as $cls) {
            $classLabels[] = $cls->class_name;
            $studentIds    = $cls->students->pluck('id');
            $classMarks    = Mark::whereIn('student_id', $studentIds)
                ->when($activeYear, fn($q) => $q->where('academic_year_id', $activeYear->id))
                ->get();
            $classAverages[] = $classMarks->count() > 0
                ? round($classMarks->avg('score'), 1)
                : 0;
        }

        // Top 5 Students
        $topStudents = [];
        if ($activeYear) {
            $studentsData = Student::with('schoolClass')->get();
            foreach ($studentsData as $st) {
                $stMarks = Mark::where('student_id', $st->id)
                    ->where('academic_year_id', $activeYear->id)
                    ->get();
                $count = $stMarks->count();
                if ($count > 0) {
                    $st->average  = $stMarks->sum('score') / $count;
                    $topStudents[] = $st;
                }
            }
            usort($topStudents, fn($a, $b) => $b->average <=> $a->average);
            $topStudents = array_slice($topStudents, 0, 5);
        }

        return view('master.dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalClasses', 'totalSubjects',
            'activeYear', 'passRate', 'topStudents',
            'gradeCounts', 'classLabels', 'classAverages'
        ));
    }
}
