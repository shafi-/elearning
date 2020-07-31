<?php

namespace Tests\Feature;

use App\Course;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected $headers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([ 'user_type' => User::$ADMIN_USER ]);

        // $this->assertDatabaseHas($this->user->getTable(), $this->user->toArray());

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            // 'Authorization' => 'Bearer ' . $this->user->api_token,
        ];
    }

    public function testList()
    {
        $response = $this->get('/api/courses');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data',
            'per_page',
            'prev_page_url',
            'current_page'
        ]);
    }

    public function testAdd()
    {
        $course = factory(Course::class)->make();

        $data = $course->toArray();

        unset($data['slug']);

        $response = $this->actingAs($this->user, 'api')
            ->withHeaders($this->headers)
                ->json('POST', '/api/courses', $data);

        $response->assertCreated();

        $this->assertDatabaseHas($course->getTable(), $data);
    }

    public function testGetById()
    {
        $course = factory(Course::class)->create();

        $res = $this->withHeaders($this->headers)
            ->actingAs($this->user, 'api')
                ->get('/api/courses/' . $course->id);

        $res->assertStatus(200);

        $res->assertJson($course->toArray());

        $res->assertJson([ 'slug' => \Str::slug($course->title) ]);
    }

    public function edit()
    {

    }

    public function testDelete()
    {
        $course = factory(Course::class)->create();

        $res = $this->withHeaders($this->headers)
            ->actingAs($this->user, 'api')
                ->delete('/api/courses/' . $course->id);

        $res->assertNoContent();

        $this->assertDeleted($course);
    }
}
