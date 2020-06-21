<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'exam_id', 'mcq_id', 'option_id', 'verdict'
    ];
}
