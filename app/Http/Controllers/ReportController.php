<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Mark;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\GradeSetting;
use App\Models\Setting;
use App\Services\NectaGrading;

class ReportController extends Controller
{
    /**
     * Display class rankings using NECTA-based division.
     */
    public function index(Request $request)
    {
        $classes      = SchoolClass::all();
        $academicYears = AcademicYear::all();

        $selectedClass    = $request->query('class_id');
        $selectedYear     = $request->query('year_id');
        $selectedSemester = $request->query('semester', 1);

        $students = [];
        $isNecta = false;
        if ($selectedClass && $selectedYear) {
            $class = SchoolClass::find($selectedClass);
            $isNecta = $class ? NectaGrading::isNectaClass($class->class_name) : false;

            $students = Student::where('school_class_id', '=', $selectedClass)
                ->where('academic_year_id', '=', $selectedYear)
                ->get();

            foreach ($students as $student) {
                $marks = Mark::where('student_id', '=', $student->id)
                    ->where('academic_year_id', '=', $selectedYear)
                    ->where('semester', '=', $selectedSemester)
                    ->get();

                $summary = NectaGrading::summarize($marks);

                $student->total_marks = $marks->sum('score');
                $student->average     = number_format($summary['average'], 2);
                $student->grade       = $summary['grade'];
                
                if ($isNecta) {
                    $student->aggregate   = $summary['aggregate'];
                    $student->division    = $summary['division'];
                }
                
                $student->remarks     = $summary['remarks'];
            }

            // Sort logic: Aggregate ascending for Necta (lower = better), Average descending for others
            if ($isNecta) {
                $students = $students->sortBy('aggregate')->values();
            } else {
                $students = $students->sortByDesc('average')->values();
            }
        }

        return view('reports.index', compact(
            'classes', 'academicYears', 'students',
            'selectedClass', 'selectedYear', 'selectedSemester', 'isNecta'
        ));
    }

    /**
     * Show individual student report card using NECTA grading.
     */
    public function show(Request $request, string $id)
    {
        $student = Student::with('schoolClass')->findOrFail($id);

        $selectedYear     = $request->query('year_id');
        $selectedSemester = $request->query('semester', 1);

        $academicYear = $selectedYear
            ? AcademicYear::find($selectedYear)
            : AcademicYear::where('is_active', '=', true)->first();

        $marks = Mark::with('subject')
            ->where('student_id', '=', $student->id)
            ->where('semester', '=', $selectedSemester)
            ->when($academicYear, fn($q) => $q->where('academic_year_id', '=', $academicYear->id))
            ->get();
          // NECTA summary
        $summary    = NectaGrading::summarize($marks);
        $average    = $summary['average'];
        $grade      = $summary['grade'];
        $remarks    = $summary['remarks'];
        $totalScore = $marks->sum('score');
        
        $isNecta    = NectaGrading::isNectaClass($student->schoolClass->class_name);
        $aggregate  = $isNecta ? $summary['aggregate'] : null;
        $division   = $isNecta ? $summary['division'] : null;

        // Class rank (sorted by aggregate for Necta, average for others)
        $classmates = Student::where('school_class_id', '=', $student->school_class_id)
            ->where('academic_year_id', '=', $student->academic_year_id)
            ->get();

        $classmatesRanked = $classmates->map(function ($s) use ($selectedSemester, $academicYear, $isNecta) {
            $m = Mark::where('student_id', '=', $s->id)
                ->where('semester', '=', $selectedSemester)
                ->when($academicYear, fn($q) => $q->where('academic_year_id', '=', $academicYear->id))
                ->get();
            
            if ($isNecta) {
                $s->rank_val = NectaGrading::aggregate($m->pluck('score'));
            } else {
                $s->rank_val = $m->count() > 0 ? $m->avg('score') : 0;
            }
            return $s;
        });

        if ($isNecta) {
            $classmatesRanked = $classmatesRanked->sortBy('rank_val')->values();
        } else {
            $classmatesRanked = $classmatesRanked->sortByDesc('rank_val')->values();
        }

        $rank         = $classmatesRanked->search(fn($s) => $s->id === $student->id) + 1;
        $totalInClass = $classmatesRanked->count();

        $academicYears = AcademicYear::all();

        $schoolName = Setting::get('school_name', config('app.name'));
        $schoolNumber = Setting::get('school_number', 'S0101');
        $district = Setting::get('district', '');
        $region = Setting::get('region', '');
        $template = Setting::get('report_template', 'standard');
        $viewPath = $template === 'standard' ? 'reports.show' : 'reports.templates.' . $template;

        return view($viewPath, compact(
            'student', 'marks', 'totalScore', 'average', 'grade',
            'aggregate', 'division', 'remarks', 'isNecta',
            'rank', 'totalInClass', 'academicYear', 'selectedSemester', 'academicYears',
            'schoolName', 'schoolNumber', 'district', 'region'
        ));
    }

    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
