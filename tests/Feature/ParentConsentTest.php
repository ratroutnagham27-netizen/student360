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
}