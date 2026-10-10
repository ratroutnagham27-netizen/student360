<?php

use App\Enums\UserRole;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TeacherUpdateController;
use App\Http\Controllers\ParentConsentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ParentDashboardController;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $route = match (Auth::user()->role) {
        UserRole::ADMIN => 'admin.dashboard',
        UserRole::TEACHER => 'teacher.dashboard',
        UserRole::PARENT => 'parent.dashboard',
    };

    return redirect()->route($route);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::view('/admin/dashboard', 'dashboards.admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

Route::view('/teacher/dashboard', 'dashboards.teacher')
    ->middleware(['auth', 'role:teacher'])
    ->name('teacher.dashboard');

Route::get('/parent/dashboard', [ParentDashboardController::class, 'show'])
    ->middleware(['auth', 'role:parent'])
    ->name('parent.dashboard');

Route::get('/student-profile', [StudentProfileController::class, 'show'])
    ->middleware(['auth', 'role:admin,teacher,parent'])
    ->name('student.profile');

Route::get('/parent/consent', [ParentConsentController::class, 'show'])
    ->middleware(['auth', 'role:parent'])
    ->name('parent.consent');

Route::post('/parent/consent', [ParentConsentController::class, 'store'])
    ->middleware(['auth', 'role:parent'])
    ->name('parent.consent.store');    

Route::post('/teacher-updates', [TeacherUpdateController::class, 'store'])
    ->middleware(['auth', 'role:teacher'])
    ->name('teacher-updates.store');
    Route::get('/students/{student}/teacher-updates', [TeacherUpdateController::class, 'index'])
    ->middleware(['auth', 'role:parent'])
    ->name('teacher-updates.index');

  