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
}
