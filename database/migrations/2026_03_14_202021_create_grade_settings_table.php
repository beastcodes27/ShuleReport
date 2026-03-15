<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id();
            $table->string('grade', 2);          // e.g. A, B, C, D, F
            $table->string('division', 20);       // e.g. Division I, Division II
            $table->unsignedTinyInteger('min_score'); // e.g. 80
            $table->unsignedTinyInteger('max_score'); // e.g. 100
            $table->string('remarks', 100);       // e.g. Excellent, Good
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_settings');
    }
};
