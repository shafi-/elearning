<?php

namespace App\Http\Controllers;

use Auth;
use App\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|numeric'
        ]);

        $exam = Exam::create([
            'lesson_id' => $request->get('lesson_id'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('exam.show', [ 'exam' => $exam->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $exam->load('lesson.mcqs.options');

        return $exam;
        // return view('take_exam')->with(compact('exam'));
    }
}
