<?php

use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = App\Course::all();

        $courses->map(function ($course) {
            $course->lessons()->saveMany(factory(App\Lesson::class, random_int(5, 10))->make());
        });
    }
}
