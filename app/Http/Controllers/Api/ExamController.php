<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Exam;
use App\Mcq;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request, Exam $exam)
    {
        $request->validate([
            'mcqs' => 'required|array',
            'mcqs.*.id' => 'required|numeric',
            'mcqs.*.answers' => 'array',
            'mcqs.*.answers.*' => 'numeric',
        ]);

        $mcqs = Mcq::with('options')->where('lesson_id', $exam->lesson_id)->get()->keyBy('id');

        $submissions = $request->get('mcqs');

        $answers = [];

        foreach ($submissions as $key => $submission) {
            $mcq = $mcqs[$submission['id']];
            $corrects = $mcq->options->filter(function($opt) { return $opt->is_answer; })->keyBy('id');

            foreach($submission['answers'] as $answer) {
                $answers[] = new Answer([
                    'mcq_id' => $submission['id'],
                    'exam_id' => $exam->id,
                    'option_id' => $answer,
                    'verdict' => isset($corrects[$answer])
                ]);
            }
        }

        // In the case of resubmission, we care only the latest submissions from the user
        // So first we remove all previous answers
        // And then save the new answers
        // In case of failure, using transaction so we do not lose previous submissions
        DB::transaction(function() use($exam, $answers){
            $exam->answers()->delete();
            $exam->answers()->saveMany($answers);
        });

        $results = collect($answers)->groupBy('mcq_id')->map(function ($answers, $mcq_id) {
            return [
                'mcq_id' => $mcq_id,
                'verdict' => $answers->every(function($ans) { return $ans->verdict; }),
                'answers' => $answers,
            ];
        });

        $score = $results->filter(function($result) { return $result['verdict']; })->count();

        return [
            'answers' => $results,
            'score' => $score,
            'total' => $mcqs->count()
        ];
    }
}
