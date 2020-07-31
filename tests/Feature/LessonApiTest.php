<?php

namespace Tests\Feature;

use App\Lesson;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected \App\Course $course;

    protected $headers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([ 'user_type' => User::$ADMIN_USER ]);

        $this->course = factory(\App\Course::class)->create();

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->user->api_token
        ];
    }

    public function testList()
    {
        $response = $this->withHeaders($this->headers)->get('/api/lessons');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data',
            'per_page',
            'prev_page_url',
            'current_page'
        ]);
    }

    public function testValidations()
    {
        $response = $this->withHeaders($this->headers)->post('/api/lessons', []);

        $response->assertJsonValidationErrors([
            'title',
            'description',
        ]);
    }

    public function testAdd()
    {
        $data = $this->prepareLesson();

        $response = $this->withHeaders($this->headers)->postJson('/api/lessons', $data);

        $response->assertCreated();

        $this->assertDatabaseHas('lessons', $data);
    }

    public function testGetById()
    {
        $lesson = $this->course->lessons()->create($this->prepareLesson());

        $res = $this->withHeaders($this->headers)->get('/api/lessons/' . $lesson->id);

        $res->assertStatus(200);

        $res->assertJson($lesson->toArray());
    }

    public function testEdit()
    {
        $lesson = $this->course->lessons()->create($this->prepareLesson());

        $updates = [
            'title' => 'updated lesson title',
            'course_id' => $lesson->course_id - 1, // this should be ignored
        ];

        $res = $this->withHeaders($this->headers)
            ->json('PATCH', 'api/lessons/' . $lesson->id, $updates);

        $res->assertSuccessful();

        $lesson->title = 'updated lesson title';
        $this->assertDatabaseHas($lesson->getTable(), $lesson->toArray());
    }

    public function tes1tDelete()
    {
        $lesson = $this->course->lessons()->create($this->prepareLesson());

        $res = $this->withHeaders($this->headers)->delete('/api/lessons/' . $lesson->id);

        $res->assertNoContent();

        $this->assertDeleted($lesson);
    }

    private function prepareLesson(): Array
    {
        $lesson = factory(Lesson::class)->make();

        $data = $lesson->toArray();

        $data['course_id'] = $this->course->id;

        return $data;
    }
}
