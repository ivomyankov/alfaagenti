<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_users()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'user' => $user->user,
            'role' => 'admin',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/dashboard/users');

        $response->assertStatus(200);
    }

    public function test_not_admin_can_not_view_dashboard_users()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'user' => $user->user,
            'role' => 'agent',
            'password' => 'password',
        ]);

        $response = $this->get('/dashboard/users');

        $response->assertRedirect('/dashboard');
    }
}
