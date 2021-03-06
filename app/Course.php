<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property title string
 * @property description string
 */
class Course extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
