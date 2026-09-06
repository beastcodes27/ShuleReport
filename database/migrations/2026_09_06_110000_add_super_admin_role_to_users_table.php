<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Relax the users.role column so it can store the super_admin role.
     *
     * Fresh installs already create the column as VARCHAR (see the users
     * migration). Databases created before this change still use an ENUM
     * restricted to three roles, so we widen it (MySQL only).
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(20) NOT NULL DEFAULT 'teacher'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('academic_master', 'academic_department', 'teacher', 'super_admin') NOT NULL DEFAULT 'teacher'");
        }
    }
};
