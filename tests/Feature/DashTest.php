<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_authenticated_can_view_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'user' => $user->user,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_not_authenticated_can_not_view_dashboard()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'user' => $user->user,
            'password' => 'wrong-password',
        ]);

        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
