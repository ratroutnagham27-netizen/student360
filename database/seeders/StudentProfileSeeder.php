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
            // 1. Supporting users
            $teacher = User::where('email', 'teacher@student360.test')->firstOrFail();
            $demoParent = User::where('email', 'parent@student360.test')->firstOrFail();

            $parents = [
                'khalil' => $this->makeParent('parent.khalil@student360.test', 'Mr. Khalil'),
                'hassan' => $this->makeParent('parent.hassan@student360.test', 'Mrs. Hassan Ali'),
                'nassar' => $this->makeParent('parent.nassar@student360.test', 'Mr. Nassar Omar'),
            ];

            // 2. Clean previous demo data
            StudentBehaviorNote::query()->delete();
            StudentAcademicRecord::query()->delete();
            StudentProfile::query()->delete();
            Student::query()->delete();

            // 3. Demo dataset — 4 students within KG to Grade 6
            $students = [
                [
                    'personal' => [
                        'name'          => 'Ahmad Khalil',
                        'date_of_birth' => '2015-03-15',
                        'class_name'    => '5A',
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
                        'date_of_birth' => '2014-07-22',
                        'class_name'    => '6B',
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
                        'date_of_birth' => '2016-11-08',
                        'class_name'    => '4C',
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
                [
                    'personal' => [
                        'name'          => 'Sara Demo',
                        'date_of_birth' => '2018-04-10',
                        'class_name'    => '3A',
                        'parent_id'     => $demoParent->id,
                    ],
                    'academic' => [
                        ['subject' => 'Mathematics', 'term' => 'Semester 1', 'score' => 80],
                        ['subject' => 'Mathematics', 'term' => 'Semester 2', 'score' => 86],
                    ],
                    'behavior' => [
                        ['category' => 'Participation', 'note' => 'Participates enthusiastically in classroom activities.'],
                    ],
                ],
            ];

            // 4. Insert student data
            foreach ($students as $data) {
                $student = Student::create($data['personal']);

                foreach ($data['academic'] as $record) {
                    StudentAcademicRecord::create([
                        'student_id' => $student->id,
                        'subject'    => $record['subject'],
                        'term'       => $record['term'],
                        'score'      => $record['score'],
                    ]);
                }

                foreach ($data['behavior'] as $note) {
                    StudentBehaviorNote::create([
                        'student_id' => $student->id,
                        'teacher_id' => $teacher->id,
                        'category'   => $note['category'],
                        'note'       => $note['note'],
                    ]);
                }

                $latestAcademic = $data['academic'][1];
                $firstBehavior = $data['behavior'][0];

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
     * Create or update a demo parent account.
     */
    private function makeParent(string $email, string $name): User
    {
        return User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => $name,
                'password' => 'password',
                'role'     => UserRole::PARENT,
            ]
        );
    }
}