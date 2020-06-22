<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'user_id', 'lesson_id'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @param array $submissions
     * @param int $submissions.id
     * @param int[] $submission.answers
     */
    public function saveAnswers($answers)
    {
        // In the case of resubmission, we care only the latest submissions from the user
        // So first we remove all previous answers
        // And then save the new answers
        // In case of failure, using transaction so we do not lose previous submissions
        DB::transaction(function() use($answers){
            $this->answers()->delete();
            $this->answers()->saveMany($answers);
        });
    }

    /**
     * 
     */
    public function calculate_score($answers = null)
    {
        if (is_null($answers)) {
            $answers = $this->answers;
        }

        $results = collect($answers)->groupBy('mcq_id')->map(function ($answers, $mcq_id) {
            return [
                'mcq_id' => $mcq_id,
                'verdict' => $answers->every(function($ans) { return $ans->verdict; }),
                'answers' => $answers,
            ];
        });

        $score = $results->filter(function($result) { return $result['verdict']; })->count();

        return [ 'answers' => $results, 'score' => $score ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
