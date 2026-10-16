<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\StudentAcademicRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentProfileDataTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(User $parent): Student
    {
        return Student::create([
            'name' => 'Ahmad Khalil',
            'date_of_birth' => '2015-03-15',
            'class_name' => '5A',
            'parent_id' => $parent->id,
        ]);
    }

    private function assertSampleLabels(string $html): void
    {
        $this->assertMatchesRegularExpression(
            '/Behavioral (?:&amp;|&) Participation.*?Sample data.*?Participation/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/Attendance.*?96%.*?Sample data/s',
            $html
        );
    }

    public function test_parent_sees_sample_labels_for_fixed_values(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $this->createStudent($parent);

        $response = $this->actingAs($parent)
            ->get(route('student.profile'))
            ->assertOk();

        $this->assertSampleLabels($response->getContent());
    }

    public function test_teacher_sees_sample_labels_for_fixed_values(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $this->createStudent($parent);

        $response = $this->actingAs($teacher)
            ->get(route('student.profile'))
            ->assertOk();

        $this->assertSampleLabels($response->getContent());
    }

    public function test_parent_and_teacher_see_database_scores_and_term_averages(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $student = $this->createStudent($parent);

        foreach ([
            ['subject' => 'Mathematics', 'term' => 'Semester 1', 'score' => 61],
            ['subject' => 'Science', 'term' => 'Semester 1', 'score' => 73],
            ['subject' => 'Mathematics', 'term' => 'Semester 2', 'score' => 95],
        ] as $record) {
            StudentAcademicRecord::create([
                'student_id' => $student->id,
                ...$record,
            ]);
        }

        foreach ([$parent, $teacher] as $user) {
            $this->actingAs($user)
                ->get(route('student.profile'))
                ->assertOk()
                ->assertSee('Mathematics')
                ->assertSee('Science')
                ->assertSee('61.00%')
                ->assertSee('73.00%')
                ->assertSee('95.00%')
                ->assertSee('Overall Average — Semester 1')
                ->assertSee('67.00%')
                ->assertSee('Overall Average — Semester 2')
                ->assertDontSee('84%')
                ->assertDontSee('Arabic');
        }
    }
}