<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\GradeSetting;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    private int $studentCounter = 0;

    private int $admCounter = 1;

    public function run(): void
    {
        if (! config('demo.enabled')) {
            return;
        }

        $this->seedDemoAccounts();

        // Only create sample organisational data when the database is empty of it.
        $isClean = AcademicYear::count() === 0
            && SchoolClass::count() === 0
            && Subject::count() === 0;

        if (! $isClean) {
            return;
        }

        $this->seedSchoolBasics();
        $this->seedClassesAndSubjects();
        $this->seedStudents();
    }

    protected function seedDemoAccounts(): void
    {
        foreach (config('demo.accounts') as $account) {
            User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => $account['password'],
                    'role' => $account['role'],
                ]
            );
        }
    }

    protected function seedSchoolBasics(): void
    {
        AcademicYear::firstOrCreate(
            ['year_name' => '2026/2027'],
            ['is_active' => true]
        );

        if (GradeSetting::count() === 0) {
            $grades = [
                ['grade' => 'A', 'division' => 'Division I', 'min_score' => 80, 'max_score' => 100, 'remarks' => 'Excellent'],
                ['grade' => 'B', 'division' => 'Division II', 'min_score' => 60, 'max_score' => 79, 'remarks' => 'Very Good'],
                ['grade' => 'C', 'division' => 'Division III', 'min_score' => 40, 'max_score' => 59, 'remarks' => 'Good'],
                ['grade' => 'D', 'division' => 'Division IV', 'min_score' => 30, 'max_score' => 39, 'remarks' => 'Fair'],
                ['grade' => 'F', 'division' => 'Division V', 'min_score' => 0, 'max_score' => 29, 'remarks' => 'Fail'],
            ];
            foreach ($grades as $g) {
                GradeSetting::create($g);
            }
        }

        if (Setting::count() === 0) {
            Setting::set('school_name', 'ShuleReport Demonstration School');
            Setting::set('school_number', 'S0000');
            Setting::set('district', 'Kinondoni');
            Setting::set('region', 'Dar es Salaam');
            Setting::set('report_template', 'standard');
        }
    }

    protected function seedClassesAndSubjects(): void
    {
        $this->seedSubject('Kiswahili', 'SWA');
        $this->seedSubject('English', 'ENG');
        $this->seedSubject('Mathematics', 'MATH');
        $this->seedSubject('Physics', 'PHY');
        $this->seedSubject('Chemistry', 'CHEM');
        $this->seedSubject('Biology', 'BIO');
        $this->seedSubject('History', 'HIS');
        $this->seedSubject('Geography', 'GEO');
        $this->seedSubject('Civics', 'CIV');
        $this->seedSubject('Basic Applied Mathematics', 'BAM');

        $teacher = User::where('email', 'teacher@shulereport.com')->first();

        $classes = [
            ['class_name' => 'Form One', 'stream' => 'A'],
            ['class_name' => 'Form One', 'stream' => 'B'],
            ['class_name' => 'Form Two', 'stream' => 'A'],
            ['class_name' => 'Form Three'],
            ['class_name' => 'Form Four', 'stream' => 'A'],
            ['class_name' => 'Form Five', 'combination' => 'PCM', 'stream' => 'A'],
            ['class_name' => 'Form Five', 'combination' => 'PCB'],
            ['class_name' => 'Form Six', 'combination' => 'PCM'],
        ];

        foreach ($classes as $data) {
            $class = SchoolClass::firstOrCreate([
                'class_name' => $data['class_name'],
                'stream' => $data['stream'] ?? null,
                'combination' => $data['combination'] ?? null,
            ], $data);

            $subjects = $this->subjectsForClass($class);

            foreach ($subjects as $subject) {
                TeacherSubject::firstOrCreate([
                    'user_id' => $teacher->id,
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                ]);
            }
        }
    }

    protected function seedStudents(): void
    {
        $year = AcademicYear::where('is_active', true)->first() ?? AcademicYear::first();
        if (! $year) {
            return;
        }

        $firstNames = ['Amina', 'Baraka', 'Chausiku', 'Daudi', 'Ester', 'Farida', 'Godfrey', 'Halima', 'Ibrahim', 'Joyce', 'Khadija', 'Lucas', 'Mariam', 'Neema', 'Oscar', 'Pendo', 'Rehema', 'Salim', 'Tatu', 'Upendo'];
        $lastNames = ['Mwangi', 'Okafor', 'Kimaro', 'Mushi', 'Masoud', 'Massawe', 'Msaki', 'Nyerere', 'Shija', 'Temu', 'Lyimo', 'Mbise', 'Kessy', 'Mollel', 'Omary', 'Suleiman', 'Mpanda', 'Chilambo', 'Mahenge', 'Kitulu'];

        $classes = SchoolClass::orderBy('id')->get();
        $teacher = User::where('email', 'teacher@shulereport.com')->first();

        foreach ($classes as $class) {
            $count = 8;
            $assigned = TeacherSubject::where('school_class_id', $class->id)
                ->where('user_id', $teacher->id)
                ->with('subject')
                ->get();

            for ($i = 0; $i < $count; $i++) {
                $this->studentCounter++;
                $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];

                $student = Student::create([
                    'admission_number' => 'ADM-' . str_pad((string) $this->admCounter++, 4, '0', STR_PAD_LEFT),
                    'name' => $name,
                    'gender' => $i % 2 === 0 ? 'Male' : 'Female',
                    'school_class_id' => $class->id,
                    'academic_year_id' => $year->id,
                ]);

                if ($class->is_a_level || in_array(strtolower($class->class_name), ['form two', 'form four'], true)) {
                    $student->update([
                        'registration_number' => 'S0000/' . str_pad((string) $this->studentCounter, 4, '0', STR_PAD_LEFT) . '/2026',
                    ]);
                }

                foreach ($assigned as $assignment) {
                    Mark::create([
                        'student_id' => $student->id,
                        'subject_id' => $assignment->subject_id,
                        'academic_year_id' => $year->id,
                        'semester' => 1,
                        'score' => mt_rand(28, 97),
                    ]);
                }
            }
        }
    }

    protected function seedSubject(string $name, string $abbreviation): Subject
    {
        return Subject::firstOrCreate(
            ['subject_name' => $name],
            ['subject_code' => $abbreviation, 'abbreviation' => $abbreviation]
        );
    }

    protected function subjectsForClass(SchoolClass $class): array
    {
        $names = match (strtoupper($class->combination ?? '')) {
            'PCM' => ['Physics', 'Chemistry', 'Basic Applied Mathematics'],
            'PCB' => ['Physics', 'Chemistry', 'Biology'],
            default => ['Kiswahili', 'English', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'History', 'Geography', 'Civics'],
        };

        return Subject::whereIn('subject_name', $names)->get()->all();
    }
}
