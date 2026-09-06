<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    |
    | When enabled (DEMO_MODE=true), the login page lists demo accounts that
    | auto-fill credentials and the database seeder creates them together
    | with sample school data.
    |
    */

    'enabled' => env('DEMO_MODE', false),

    /*
    | Demo accounts. Passwords are seeded as-is (never changed on re-seed).
    */
    'accounts' => [
        [
            'role' => 'super_admin',
            'name' => 'Super Admin',
            'email' => 'superadmin@shulereport.com',
            'password' => 'password',
            'icon' => 'bi-shield-lock-fill',
            'hint' => 'Full control',
        ],
        [
            'role' => 'academic_master',
            'name' => 'Academic Master',
            'email' => 'admin@shulereport.com',
            'password' => 'password',
            'icon' => 'bi-mortarboard-fill',
            'hint' => 'Teachers, students, reports',
        ],
        [
            'role' => 'academic_department',
            'name' => 'Department',
            'email' => 'department@shulereport.com',
            'password' => 'password',
            'icon' => 'bi-building-fill',
            'hint' => 'Classes & subjects',
        ],
        [
            'role' => 'teacher',
            'name' => 'Teacher',
            'email' => 'teacher@shulereport.com',
            'password' => 'password',
            'icon' => 'bi-person-badge-fill',
            'hint' => 'Enter marks',
        ],
    ],

];
