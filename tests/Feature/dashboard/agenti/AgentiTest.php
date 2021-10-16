<?php

namespace Tests\Feature\Dashboard\Agenti;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\DashboardController;
use App\Service\ImotiService;
use Tests\TestCase;

class AgentiTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @test
     */
    public function agents_Page_test()
    {
        $response = $this->get('dashboard/agenti');

        $response->assertStatus(200);
    }

    
}
