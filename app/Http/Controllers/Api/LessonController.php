<?php

namespace App\Http\Controllers\Api;

use App\Lesson;
use App\Http\Requests\LessonRequest;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(Lesson::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        $course = \App\Course::find($request->get('course_id'));

        $lesson = $course->lessons()->create($request->validated());
        // $lesson = Lesson::create($request->validated());

        if (!$lesson) $this->error('Could not create. Try again', 400, $request->validated());
        return $this->success($lesson, 201, 'Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        return $this->success($lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        $this->success($lesson, 203, 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return $this->success(null, 204, 'Deleted');
    }
}
