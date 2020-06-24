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

        /*
        // Single Raw query to get exams
        //      with lesson title,
        //      mcqs count,
        //      user submitted answer count,
        //      correct answer count

        $single_query = "select *, 
            (select title from lessons where lessons.id = exams.lesson_id) as lesson_title,
            (select count(*)
                from `elearning`.`mcqs`
                inner join `elearning`.`lessons`
                on `elearning`.`lessons`.`id` = `elearning`.`mcqs`.`lesson_id`
                where `elearning`.`exams`.`lesson_id` = `elearning`.`lessons`.`id`) as mcqs_count,
            (select count(*)
                from answers
                where answers.exam_id = exams.id and answers.verdict = 1) as correct,
            (select count(*)
                from answers
                where answers.exam_id = exams.id) as answered
            from exams";
        $exams1 = \DB::select($single_query);
        $exams1 = collect($exams1)->map(function ($exam) {
            return [
                'id' => $exam->id,
                'lesson' => collect([ 'title' => $exam->lesson_title ]),
                'result' => [
                    'total' => $exam->mcqs_count,
                    'answered' => $exam->answered,
                    'score' => $exam->correct
                ]
            ];
        });
        */

        $query = Exam::select('id', 'user_id', 'lesson_id')
            ->with('answers:id,exam_id,verdict', 'lesson:id,title')
            ->withCount('mcqs');


        if (!$user->is_admin()) $query = $query->where('user_id', $user->id);

        $exams = $query->simplePaginate();

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
        \Gate::authorize('show', $exam);

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
