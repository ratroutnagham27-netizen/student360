<?php

use App\Enums\UserRole;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::view('/parent/dashboard', 'dashboards.parent')
    ->middleware(['auth', 'role:parent'])
    ->name('parent.dashboard'); 

