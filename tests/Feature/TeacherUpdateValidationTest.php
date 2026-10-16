<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherUpdateValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $teacher;
    private User $parent;
    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $this->parent = User::factory()->create([
            'role' => 'parent',
        ]);

        $this->student = Student::create([
            'name' => 'Test Child',
            'date_of_birth' => '2018-04-10',
            'class_name' => '3A',
            'parent_id' => $this->parent->id,
            'homeroom_teacher_id' => $this->teacher->id,
        ]);
    }

    private function validPayload(): array
    {
        return [
            'student_id' => $this->student->id,
            'category' => 'academic',
            'note' => 'The student participated well in class.',
            'visible_to_parent' => true,
        ];
    }

    private function assertInvalidPayload(array $payload, string $field): void
    {
        $this->actingAs($this->teacher)
            ->from(route('teacher.updates.create'))
            ->post(route('teacher-updates.store'), $payload)
            ->assertRedirect(route('teacher.updates.create'))
            ->assertSessionHasErrors([$field]);

        $this->assertDatabaseCount('teacher_updates', 0);
    }

    public function test_missing_note_is_rejected(): void
    {
        $payload = $this->validPayload();
        unset($payload['note']);

        $this->assertInvalidPayload($payload, 'note');
    }

    public function test_missing_category_is_rejected(): void
    {
        $payload = $this->validPayload();
        unset($payload['category']);

        $this->assertInvalidPayload($payload, 'category');
    }

    public function test_invalid_category_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['category'] = 'invalid-category';

        $this->assertInvalidPayload($payload, 'category');
    }

    public function test_note_longer_than_2000_characters_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['note'] = str_repeat('a', 2001);

        $this->assertInvalidPayload($payload, 'note');
    }

    public function test_nonexistent_student_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['student_id'] = $this->student->id + 1000;

        $this->assertInvalidPayload($payload, 'student_id');
    }

    public function test_invalid_visible_to_parent_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['visible_to_parent'] = 'abc';

        $this->assertInvalidPayload($payload, 'visible_to_parent');
    }

    public function test_parent_cannot_submit_an_update(): void
    {
        $this->actingAs($this->parent)
            ->post(route('teacher-updates.store'), $this->validPayload())
            ->assertForbidden();

        $this->assertDatabaseCount('teacher_updates', 0);
    }

    public function test_admin_cannot_submit_an_update(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('teacher-updates.store'), $this->validPayload())
            ->assertForbidden();

        $this->assertDatabaseCount('teacher_updates', 0);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->post(route('teacher-updates.store'), $this->validPayload())
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('teacher_updates', 0);
    }

    public function test_valid_input_saves_visible_to_parent_true(): void
    {
        $payload = $this->validPayload();
        $payload['visible_to_parent'] = true;

        $this->actingAs($this->teacher)
            ->from(route('teacher.updates.create'))
            ->post(route('teacher-updates.store'), $payload)
            ->assertRedirect(route('teacher.updates.create'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('teacher_updates', 1);

        $this->assertDatabaseHas('teacher_updates', [
            'student_id' => $this->student->id,
            'teacher_id' => $this->teacher->id,
            'category' => $payload['category'],
            'note' => $payload['note'],
            'visible_to_parent' => 1,
        ]);
    }

    public function test_valid_input_saves_visible_to_parent_false(): void
    {
        $payload = $this->validPayload();
        $payload['visible_to_parent'] = false;

        $this->actingAs($this->teacher)
            ->from(route('teacher.updates.create'))
            ->post(route('teacher-updates.store'), $payload)
            ->assertRedirect(route('teacher.updates.create'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('teacher_updates', 1);

        $this->assertDatabaseHas('teacher_updates', [
            'student_id' => $this->student->id,
            'teacher_id' => $this->teacher->id,
            'category' => $payload['category'],
            'note' => $payload['note'],
            'visible_to_parent' => 0,
        ]);
    }
}