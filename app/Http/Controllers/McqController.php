<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Mcq;
use Illuminate\Http\Request;

class McqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Lesson $lesson)
    {
        $mcqs = $lesson->mcqs()->with('options')->get();

        // we will send the is_answer attribute of Option only when an admin requests
        $user = \Auth::user();
        if ($user && $user->is_admin()) {
            $mcqs->map(function ($mcq) {
                $mcq->options->map(function($opt){
                    $opt->makeVisible('is_answer');
                });
            });
        }

        return view('mcq.list')->with([ 'lesson' => $lesson, 'mcqs' => $mcqs ]);
        // return [ 'lesson' => $lesson, 'mcqs' => $mcqs ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Lesson $lesson)
    {
        return view('mcq.add', $lesson)->with([ 'lesson' => $lesson ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lesson $lesson)
    {
        // return $request->all();

        $request->validate([
            'question' => 'required',
            'options.*.body' => 'required',
            'options.*.is_answer' => 'required'
        ]);

        $mcq = $this->saveMcq($request->all(), $lesson->id);

        return [ 'mcq' => Mcq::with('options')->find($mcq->id) ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function edit(Mcq $mcq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mcq $mcq)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function destroy($lesson_id, $mcq_id)
    {
        $mcq = Mcq::where('lesson_id', $lesson_id)->find($mcq_id);

        if ($mcq) $mcq->delete();

        return redirect()->back();
    }

    private function saveMcq($data, $lessonId)
    {
        $mcq = new Mcq([
            'question' => $data['question'],
            'lesson_id' => $lessonId
        ]);

        $options = [];
        foreach ($data['options'] as $option) {
            $options[] = (new \App\Option([
                'body' => $option['body'],
                'is_answer' => $option['is_answer']
            ]))->makeVisible('is_answer');
        }
        $mcq->save();
        $mcq->options()->saveMany($options);
        // $mcq->options = $options;
 
        return $mcq;
    }
}
