<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function show(): View
    {
        return view('dashboards.admin', [
            'totalStudents' => Student::count(),
            'totalTeachers' => User::where('role', UserRole::TEACHER->value)->count(),
            'totalParents' => User::where('role', UserRole::PARENT->value)->count(),
        ]);
    }
}