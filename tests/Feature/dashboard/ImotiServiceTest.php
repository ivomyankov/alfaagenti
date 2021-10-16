<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Auth;

class ImotiServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     */
    public function getUserTest()
    {
        if (Auth::user()) {    
            $user = Auth::user();
        } else {
            $user = 'guest';
        }
        $this->assertEquals('guest', $user, "If not logged, should be guest");
    }

    
}
