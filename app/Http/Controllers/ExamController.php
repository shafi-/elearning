<?php

namespace App\Http\Controllers;

use Auth;
use App\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin()) $exams = Exam::all();
        else $exams = $user->exams();

        return view('frontend.exam_list')->with([ 'exams' => $exams ]);
    }

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

        $mcqs = $exam->lesson->mcqs->map(function($mcq){

            $options = $mcq->options->map(function($opt) {
                return [ 'id' => $opt->id, 'body' => $opt->body, 'selected' => false ];
            });

            return [ 'id' => $mcq->id, 'question' => $mcq->question, 'options' => $options ];
        });

        // return $exam;
        return view('frontend.take_exam')->with([ 'exam' => $exam, 'mcqs' => $mcqs ]);
    }
}
