<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', [App\Http\Controllers\UserManagementController::class, 'dashboard'])->name('super_admin.dashboard');
    Route::get('/users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [App\Http\Controllers\UserManagementController::class, 'updateRole'])->name('users.update-role');
});

// Academic Master Routes
Route::middleware(['auth', 'role:academic_master'])->group(function () {
    Route::get('/master/dashboard', [App\Http\Controllers\MasterDashboardController::class, 'index'])->name('master.dashboard');
    Route::resource('academic-years', App\Http\Controllers\AcademicYearController::class);
    Route::resource('reports', App\Http\Controllers\ReportController::class);
    Route::resource('grade-settings', App\Http\Controllers\GradeSettingController::class);
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    Route::post('/students/generate-necta', [App\Http\Controllers\StudentController::class, 'generateNectaNumbers'])->name('students.generate-necta');
    Route::resource('promotions', App\Http\Controllers\PromotionController::class);
    Route::post('/promotions', [App\Http\Controllers\PromotionController::class, 'promote'])->name('promotions.promote');
    Route::get('/invitations', [App\Http\Controllers\InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/invitations', [App\Http\Controllers\InvitationController::class, 'store'])->name('invitations.store');
});

// Guest Routes for Invitations
Route::middleware('guest')->group(function () {
    Route::get('/register/invite/{token}', [App\Http\Controllers\InvitationController::class, 'showRegistrationForm'])->name('register.invite');
    Route::post('/register/invite/{token}', [App\Http\Controllers\InvitationController::class, 'register'])->name('register.invite.store');
});

// Academic Department Routes
Route::middleware(['auth', 'role:academic_department'])->group(function () {
    Route::get('/department/dashboard', [App\Http\Controllers\DepartmentDashboardController::class, 'index'])->name('department.dashboard');
    Route::resource('students', App\Http\Controllers\StudentController::class);
    Route::resource('classes', App\Http\Controllers\SchoolClassController::class);
    Route::resource('subjects', App\Http\Controllers\SubjectController::class);
    Route::resource('assignments', App\Http\Controllers\TeacherSubjectController::class);
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [App\Http\Controllers\TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::resource('marks', App\Http\Controllers\MarkController::class);
});

// Common Auth Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/export/class-results', [App\Http\Controllers\ExportController::class, 'exportClassResults'])->name('export.class-results');
    Route::get('/export/subject-results', [App\Http\Controllers\ExportController::class, 'exportSubjectResults'])->name('export.subject-results');
});
