<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolClassFactory> */
    use HasFactory;

    protected $fillable = ['class_name', 'stream', 'combination'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Whether this class belongs to A-Level (Form 5/6) and therefore uses combinations.
     */
    public function getIsALevelAttribute(): bool
    {
        $name = strtolower($this->class_name);
        $name = preg_replace('/\bform\s*(five|v)\b/', 'form 5', $name);
        $name = preg_replace('/\bform\s*(six|vi)\b/', 'form 6', $name);

        return (bool) preg_match('/\bform\s*[56]\b/', $name);
    }

    /**
     * Human-readable label combining level, combination and stream.
     * e.g. "Form Five (PCM) A" or "Form One A".
     */
    public function getDisplayNameAttribute(): string
    {
        $label = $this->class_name;

        if ($this->combination) {
            $label .= ' (' . strtoupper($this->combination) . ')';
        }

        if ($this->stream) {
            $label .= ' ' . strtoupper($this->stream);
        }

        return $label;
    }
}
