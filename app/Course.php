<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function toArray()
    {
        $data = parent::toArray();

        $data['slug'] = $this->slug;

        return $data;
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
