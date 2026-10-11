<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TeacherUpdate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function show(Request $request): View
    {
        $teacherId = $request->user()->id;

        $studentCount = Student::count();

        $myUpdatesCount = TeacherUpdate::where('teacher_id', $teacherId)->count();

        $myRecentUpdatesCount = TeacherUpdate::where('teacher_id', $teacherId)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return view('dashboards.teacher', [
            'studentCount'         => $studentCount,
            'myUpdatesCount'       => $myUpdatesCount,
            'myRecentUpdatesCount' => $myRecentUpdatesCount,
        ]);
    }
}