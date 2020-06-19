<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
