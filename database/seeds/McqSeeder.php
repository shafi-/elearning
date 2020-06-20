<?php

use Illuminate\Database\Seeder;

class McqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = App\Lesson::inRandomOrder()->take(30)->get();

        $lessons->map(function($lesson) {
            $lesson->mcqs()->saveMany(factory(App\Mcq::class, 10)->make());
        });
    }
}
