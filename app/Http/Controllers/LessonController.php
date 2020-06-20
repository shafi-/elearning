<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Course $course)
    {
        $lessons = $course->lessons()->withCount('mcqs')->orderBy('id', 'desc')->paginate(5);

        return view('lesson.list')->with([ 'course' => $course, 'lessons' => $lessons ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Course $course)
    {
        return view('lesson.add')->with([ 'course' => $course ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|max:110',
            'description' => 'required'
        ]);

        $lesson = new Lesson([
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]);

        $course->lessons()->save($lesson);

        return redirect()->route('course.lesson.index', [ 'course' => $course->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $course_id, $lesson_id)
    {
        return redirect()->route('course.lesson.index', [ 'course' => $course_id ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $lesson_id)
    {
        $lesson = Lesson::where('course_id', $course_id)->findOrFail($lesson_id);

        return view('lesson.edit')->with([ 'lesson' => $lesson ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $lesson_id)
    {
        $lesson = Lesson::where('course_id', $course_id)->findOrFail($lesson_id);

        $request->validate([
            'title' => 'max:110',
            'description' => 'string'
        ]);

        $lesson->title = $request->get('title', $lesson->title);
        $lesson->description = $request->get('description', $lesson->description);

        $lesson->save();

        return redirect()->route('course.lesson.index', ['course' => $course_id ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $lesson_id)
    {
        Lesson::where('course_id', $course_id)->where('id', $lesson_id)->delete();

        return redirect()->route('course.lesson.index', [ 'course' => $course_id ]);
    }
}
