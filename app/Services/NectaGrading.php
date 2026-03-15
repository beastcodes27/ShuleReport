<?php

namespace App\Services;

use App\Models\GradeSetting;
use Illuminate\Support\Str;

class NectaGrading
{
    /**
     * Check if a class is subject to NECTA aggregate/division rules.
     * Only "Form 2" and "Form 4" (case-insensitive) are NECTA classes.
     */
    public static function isNectaClass(string $className): bool
    {
        $lowerName = strtolower($className);
        return Str::contains($lowerName, 'form 2') || Str::contains($lowerName, 'form 4');
    }

    /**
     * Convert a score to a NECTA grade point (A=1, B=2, C=3, D=4, F=5).
     * Uses dynamic GradeSettings from the database.
     */
    public static function scoreToPoints(float $score): int
    {
        $setting = GradeSetting::gradeFor($score);
        if (!$setting) return 5;

        return match ($setting->grade) {
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
            default => 5, // F and any unrecognized grade
        };
    }

    /**
     * Compute NECTA aggregate from an array/collection of scores.
     * Uses the best 7 subjects (lowest points = best).
     */
    public static function aggregate(iterable $scores, int $bestN = 7): int
    {
        $points = collect($scores)
            ->map(fn($score) => self::scoreToPoints((float) $score))
            ->sort()
            ->take($bestN)
            ->values();

        return $points->sum();
    }

    /**
     * Determine division from aggregate points (NECTA standard).
     */
    public static function division(int $aggregate, int $subjectCount, int $requiredSubjects = 7): string
    {
        // If the student has fewer subjects than required, cannot compute a valid division
        if ($subjectCount < $requiredSubjects) {
            return 'Incomplete';
        }

        return match (true) {
            $aggregate <= 17 => 'Division I',
            $aggregate <= 21 => 'Division II',
            $aggregate <= 25 => 'Division III',
            $aggregate <= 33 => 'Division IV',
            default          => 'Division V (Fail)',
        };
    }

    /**
     * Full summary: given a collection of marks, return grade, points, aggregate, division.
     */
    public static function summarize(iterable $marks, int $bestN = 7): array
    {
        $scores     = collect($marks)->pluck('score');
        $count      = $scores->count();
        $average    = $count > 0 ? $scores->avg() : 0;
        
        $aggregate  = self::aggregate($scores, $bestN);
        $division   = self::division($aggregate, $count, $bestN);

        $gradeSetting = GradeSetting::gradeFor($average);
        $grade        = $gradeSetting?->grade ?? 'F';
        $remarks      = $gradeSetting?->remarks ?? 'Fail';

        return compact('average', 'aggregate', 'division', 'grade', 'remarks', 'count');
    }
}
