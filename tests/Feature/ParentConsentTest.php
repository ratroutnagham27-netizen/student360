<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\ParentConsent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParentConsentTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_view_consent_page(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        $response = $this->actingAs($parent)->get(route('parent.consent'));

        $response->assertOk();
        $response->assertSee('I Agree');
    }

    public function test_parent_consent_is_recorded_when_agreed(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        $response = $this->actingAs($parent)->post(route('parent.consent.store'));

        $response->assertRedirect(route('parent.dashboard'));

        $this->assertDatabaseHas('parent_consents', [
            'user_id' => $parent->id,
        ]);

        $this->assertNotNull(
            ParentConsent::where('user_id', $parent->id)->first()->agreed_at
        );
    }

    public function test_consent_creates_audit_log_entry(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        $this->actingAs($parent)->post(route('parent.consent.store'));

        $this->assertDatabaseHas('audit_logs', [
            'user_id'        => $parent->id,
            'auditable_type' => ParentConsent::class,
            'field'          => 'agreed_at',
        ]);
    }

    public function test_non_parent_cannot_access_consent_page(): void
    {
        $teacher = User::factory()->create(['role' => UserRole::TEACHER]);

        $response = $this->actingAs($teacher)->get(route('parent.consent'));

        $response->assertForbidden();
    }

        public function test_parent_without_consent_is_redirected_from_dashboard(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        $response = $this->actingAs($parent)->get(route('parent.dashboard'));

        $response->assertRedirect(route('parent.consent'));
    }

    public function test_parent_without_consent_is_redirected_from_student_profile(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        $response = $this->actingAs($parent)->get(route('student.profile'));

        $response->assertRedirect(route('parent.consent'));
    }

    public function test_parent_with_consent_can_access_dashboard_and_profile(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        ParentConsent::create([
            'user_id'   => $parent->id,
            'agreed_at' => now(),
        ]);

        // Parent dashboard — student may be null, but should be 200
        $this->actingAs($parent)
            ->get(route('parent.dashboard'))
            ->assertOk();

        // Student profile — parent has no student linked, expects 403
        $this->actingAs($parent)
            ->get(route('student.profile'))
            ->assertStatus(403);
    }

    public function test_pressing_consent_twice_creates_only_one_row(): void
    {
        $parent = User::factory()->create(['role' => UserRole::PARENT]);

        $this->actingAs($parent)->post(route('parent.consent.store'));
        $this->actingAs($parent)->post(route('parent.consent.store'));

        $this->assertEquals(
            1,
            ParentConsent::where('user_id', $parent->id)->count()
        );

        $this->assertEquals(
            1,
            \App\Models\AuditLog::where('user_id', $parent->id)
                ->where('auditable_type', ParentConsent::class)
                ->count()
        );
    }

    public function test_teacher_and_admin_are_not_blocked_by_consent_middleware(): void
    {
        $teacher = User::factory()->create(['role' => UserRole::TEACHER]);
        $admin   = User::factory()->create(['role' => UserRole::ADMIN]);

        // Neither has a consent record
        $this->actingAs($teacher)->get(route('teacher.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }
}