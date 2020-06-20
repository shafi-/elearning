<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'body',
        'is_answer'
    ];

    protected $hidden = [ 'is_answer' ];

    public function mcq()
    {
        return $this->belongsTo(Mcq::class);
    }
}
