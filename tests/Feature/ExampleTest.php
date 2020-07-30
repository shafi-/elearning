<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/api');

        $response->assertNotFound();
    }

    public function testAuthUser()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user, 'api')->get('/api/user');

        $response->assertStatus(200);

        $response->assertJson($user->toArray());
    }
}
