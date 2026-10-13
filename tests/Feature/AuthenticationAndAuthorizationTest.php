<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\ParentConsent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_page(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Student360')
            ->assertSee('Login');
    }

    public function test_public_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register')->assertNotFound();
    }

    public function test_guests_cannot_access_role_dashboards(): void
    {
        $dashboards = [
            '/admin/dashboard',
            '/teacher/dashboard',
            '/parent/dashboard',
        ];

        foreach ($dashboards as $dashboard) {
            $this->get($dashboard)->assertRedirect(route('login'));
        }
    }

    public function test_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_teacher_is_redirected_to_teacher_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('teacher.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_parent_is_redirected_to_parent_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('parent.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_each_role_can_only_access_its_own_dashboard(): void
    {
        $cases = [
            [
                UserRole::ADMIN,
                '/admin/dashboard',
                ['/teacher/dashboard', '/parent/dashboard'],
            ],
            [
                UserRole::TEACHER,
                '/teacher/dashboard',
                ['/admin/dashboard', '/parent/dashboard'],
            ],
            [
                UserRole::PARENT,
                '/parent/dashboard',
                ['/admin/dashboard', '/teacher/dashboard'],
            ],
        ];

        foreach ($cases as [$role, $allowedDashboard, $forbiddenDashboards]) {
            $user = User::factory()->create(['role' => $role]);

            if ($role === UserRole::PARENT) {
                ParentConsent::create([
                    'user_id'   => $user->id,
                    'agreed_at' => now(),
                ]);
            }

            $this->actingAs($user)
                ->get($allowedDashboard)
                ->assertOk();

            foreach ($forbiddenDashboards as $dashboard) {
                $this->get($dashboard)->assertForbidden();
            }

            $this->post('/logout');
        }
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}