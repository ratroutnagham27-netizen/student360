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
            // Each student gets a few demo updates
            $updates = [
                [
                    'category' => 'academic',
                    'note'     => "{$student->name} showed strong improvement in Mathematics this month.",
                ],
                [
                    'category' => 'behavioral',
                    'note'     => "Excellent participation during group activities.",
                ],
                [
                    'category' => 'personal',
                    'note'     => "Demonstrated kindness by helping a classmate with homework.",
                ],
            ];

            foreach ($updates as $data) {
                TeacherUpdate::create([
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'category'   => $data['category'],
                    'note'       => $data['note'],
                ]);
            }
        }
    }
}