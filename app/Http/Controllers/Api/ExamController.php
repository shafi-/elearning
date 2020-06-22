<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Exam;
use App\Mcq;
use App\Http\Controllers\Controller;
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
                $answers[] = Answer::updateOrCreate([
                    'mcq_id' => $submission['id'],
                    'exam_id' => $exam->id,
                ], [
                    'option_id' => $answer,
                    'verdict' => isset($corrects[$answer])
                ]);
            }
        }

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
