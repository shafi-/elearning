<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Exam;
use App\Mcq;
use App\Http\Controllers\Controller;
use DB;
use Gate;
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
        Gate::authorize('submit', $exam);

        $request->validate([
            'mcqs' => 'required|array',
            'mcqs.*.id' => 'required|numeric',
            'mcqs.*.answers' => 'array',
            'mcqs.*.answers.*' => 'numeric',
        ]);

        $mcqs = $exam->lesson->mcqs()->with('options')->get()->keyBy('id');

        $answers = $this->prepare_answers($request->get('mcqs'), $mcqs);

        $exam->saveAnswers($answers);

        $results = $exam->calculate_score($answers);
        $results['total'] = $mcqs->count();

        return $results;
    }

    private function prepare_answers(array $submissions, $mcqs)
    {
        $answers = [];

        foreach ($submissions as $submission) {
            $mcq = $mcqs[$submission['id']];
            $corrects = $mcq->options->filter(function($opt) { return $opt->is_answer; })->keyBy('id');

            foreach($submission['answers'] as $answer) {
                $answers[] = new Answer([
                    'mcq_id' => $submission['id'],
                    'option_id' => $answer,
                    'verdict' => isset($corrects[$answer])
                ]);
            }
        }

        return $answers;
    }
}
