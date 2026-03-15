<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeSetting extends Model
{
    protected $fillable = ['grade', 'division', 'min_score', 'max_score', 'remarks'];

    /**
     * Compute grade label for a given score using stored settings.
     * Returns default 'F' if no matching interval found.
     */
    public static function gradeFor(float $score): ?self
    {
        return self::where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->orderByDesc('min_score')
            ->first();
    }
}
