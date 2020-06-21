<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Mcq;
use Illuminate\Http\Request;

class McqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function index(Lesson $lesson)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @param  \App\Mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson, Mcq $mcq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @param  \App\Mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lesson_id, $mcq_id)
    {
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array',
            'options.*.body' => 'required|string',
            'options.*.id' => 'required|numeric',
            'options.*.is_answer' => 'required|boolean'
        ]);

        $mcq = Mcq::where('lesson_id', $lesson_id)->findOrFail($mcq_id);

        $mcq->question = $request->get('question') ?? $mcq->question;

        foreach ($request->get('options') as $i => $option) {
            $mcq->options()->updateOrCreate(
                ['id' => $option['id']],
                [
                    'body' => $option['body'],
                    'is_answer' => $option['is_answer']
                ]
            );
        }

        return [ Mcq::with('options')->find($mcq->id) ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @param  \App\Mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, Mcq $mcq)
    {
        //
    }
}
