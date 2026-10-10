<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\TeacherUpdate;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherUpdateSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::where('email', 'teacher@student360.test')->firstOrFail();

        TeacherUpdate::query()->delete();

        foreach (Student::all() as $student) {
            $updates = [
                [
                    'category'          => 'academic',
                    'note'              => "{$student->name} showed strong improvement in Mathematics this month.",
                    'visible_to_parent' => true,
                    'created_at'        => now()->subWeek(),
                ],
                [
                    'category'          => 'behavioral',
                    'note'              => "Excellent participation during group activities.",
                    'visible_to_parent' => true,
                    'created_at'        => now()->subDays(3),
                ],
                [
                    'category'          => 'personal',
                    'note'              => "Demonstrated kindness by helping a classmate with homework.",
                    'visible_to_parent' => true,
                    'created_at'        => now()->subDay(),
                ],
                [
                    'category'          => 'personal',
                    'note'              => "Confidential: {$student->name} has been quieter than usual — follow-up with counselor.",
                    'visible_to_parent' => false,
                    'created_at'        => now(),
                ],
            ];

            foreach ($updates as $data) {
                TeacherUpdate::create([
                    'student_id'        => $student->id,
                    'teacher_id'        => $teacher->id,
                    'category'          => $data['category'],
                    'note'              => $data['note'],
                    'visible_to_parent' => $data['visible_to_parent'],
                    'created_at'        => $data['created_at'],
                ]);
            }
        }
    }
}