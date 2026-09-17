<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\StudentAcademicRecord;
use App\Models\StudentBehaviorNote;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // ─────────────────────────────────────────────
            // 1. Supporting users (teacher + parents)
            // ─────────────────────────────────────────────
            $teacher = User::where('email', 'teacher@student360.test')->firstOrFail();

            $parents = [
                'khalil' => $this->makeParent('parent.khalil@student360.test',  'Mr. Khalil Khalil'),
                'hassan' => $this->makeParent('parent.hassan@student360.test',  'Mrs. Hassan Ali'),
                'nassar' => $this->makeParent('parent.nassar@student360.test',  'Mr. Nassar Omar'),
            ];

            // ─────────────────────────────────────────────
            // 2. Clean previous demo data (idempotent)
            // ─────────────────────────────────────────────
            StudentBehaviorNote::query()->delete();
            StudentAcademicRecord::query()->delete();
            StudentProfile::query()->delete();
            Student::query()->delete();

            // ─────────────────────────────────────────────
            // 3. Demo dataset — 3 students, 3 sections each
            // ─────────────────────────────────────────────
            $students = [
                [
                    'personal' => [
                        'name'          => 'Ahmad Khalil',
                        'date_of_birth' => '2011-03-15',
                        'class_name'    => '9A',
                        'parent_id'     => $parents['khalil']->id,
                    ],
                    'academic' => [
                        ['subject' => 'Mathematics', 'term' => 'Semester 1', 'score' => 85],
                        ['subject' => 'Mathematics', 'term' => 'Semester 2', 'score' => 92],
                        ['subject' => 'English',     'term' => 'Semester 1', 'score' => 78],
                        ['subject' => 'English',     'term' => 'Semester 2', 'score' => 82],
                        ['subject' => 'Science',     'term' => 'Semester 1', 'score' => 88],
                        ['subject' => 'Science',     'term' => 'Semester 2', 'score' => 90],
                    ],
                    'behavior' => [
                        ['category' => 'Participation', 'note' => 'Actively participates in group activities.'],
                        ['category' => 'Talent',        'note' => 'Shows strong analytical skills in mathematics.'],
                    ],
                ],
                [
                    'personal' => [
                        'name'          => 'Layla Hassan',
                        'date_of_birth' => '2010-07-22',
                        'class_name'    => '10B',
                        'parent_id'     => $parents['hassan']->id,
                    ],
                    'academic' => [
                        ['subject' => 'English',     'term' => 'Semester 1', 'score' => 95],
                        ['subject' => 'English',     'term' => 'Semester 2', 'score' => 97],
                        ['subject' => 'Mathematics', 'term' => 'Semester 1', 'score' => 70],
                        ['subject' => 'Mathematics', 'term' => 'Semester 2', 'score' => 75],
                        ['subject' => 'Science',     'term' => 'Semester 1', 'score' => 80],
                        ['subject' => 'Science',     'term' => 'Semester 2', 'score' => 85],
                    ],
                    'behavior' => [
                        ['category' => 'Talent',        'note' => 'Exceptional creativity in writing and literature.'],
                        ['category' => 'Participation', 'note' => 'Quiet in class but contributes thoughtfully when called on.'],
                    ],
                ],
                [
                    'personal' => [
                        'name'          => 'Omar Nassar',
                        'date_of_birth' => '2012-11-08',
                        'class_name'    => '8C',
                        'parent_id'     => $parents['nassar']->id,
                    ],
                    'academic' => [
                        ['subject' => 'Mathematics', 'term' => 'Semester 1', 'score' => 60],
                        ['subject' => 'Mathematics', 'term' => 'Semester 2', 'score' => 65],
                        ['subject' => 'English',     'term' => 'Semester 1', 'score' => 72],
                        ['subject' => 'English',     'term' => 'Semester 2', 'score' => 78],
                        ['subject' => 'Science',     'term' => 'Semester 1', 'score' => 65],
                        ['subject' => 'Science',     'term' => 'Semester 2', 'score' => 70],
                    ],
                    'behavior' => [
                        ['category' => 'Talent',        'note' => 'Demonstrates outstanding visual arts abilities.'],
                        ['category' => 'Focus',         'note' => 'Needs encouragement to stay focused during long lessons.'],
                        ['category' => 'Participation', 'note' => 'Shows gradual improvement in class participation.'],
                    ],
                ],
            ];

            // ─────────────────────────────────────────────
            // 4. Insert everything
            // ─────────────────────────────────────────────
            foreach ($students as $data) {

                // (a) Normalized: students table
                $student = Student::create($data['personal']);

                // (b) Normalized: academic records
                foreach ($data['academic'] as $record) {
                    StudentAcademicRecord::create([
                        'student_id' => $student->id,
                        'subject'    => $record['subject'],
                        'term'       => $record['term'],
                        'score'      => $record['score'],
                    ]);
                }

                // (c) Normalized: behavior notes
                foreach ($data['behavior'] as $note) {
                    StudentBehaviorNote::create([
                        'student_id' => $student->id,
                        'teacher_id' => $teacher->id,
                        'category'   => $note['category'],
                        'note'       => $note['note'],
                    ]);
                }

                // (d) Flat: student_profiles — ONE row per student
                //     with a representative academic + behavior snapshot
                $latestAcademic = $data['academic'][1]; // Semester 2
                $firstBehavior  = $data['behavior'][0];

                StudentProfile::create([
                    'name'          => $data['personal']['name'],
                    'date_of_birth' => $data['personal']['date_of_birth'],
                    'class_name'    => $data['personal']['class_name'],
                    'parent_id'     => $data['personal']['parent_id'],
                    'subject'       => $latestAcademic['subject'],
                    'term'          => $latestAcademic['term'],
                    'score'         => $latestAcademic['score'],
                    'category'      => $firstBehavior['category'],
                    'behavior_note' => $firstBehavior['note'],
                    'teacher_id'    => $teacher->id,
                ]);
            }
        });
    }

    /**
     * Create a demo parent user if not already present.
     */
    private function makeParent(string $email, string $name): User
    {
        return User::firstOrCreate(
            ['email' => $email],
            [
                'name'     => $name,
                'password' => 'password',
                'role'     => UserRole::PARENT,
            ]
        );
    }
}