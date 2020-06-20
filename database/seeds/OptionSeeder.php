<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mcqs = App\Mcq::all();

        $mcqs->map(function($mcq) {
            $options = factory(App\Option::class, 4)->make();

            $options[random_int(0,3)]->is_answer = true;
            $mcq->options()->saveMany($options);
        });
    }
}
