<?php

use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::where('user_type', 'client')->inRandomOrder()->take(10)->get();

        $lessons = \App\Lesson::whereHas('mcqs')->inRandomOrder()->with('mcqs.options')->take(10)->get();

        foreach ($users as $index => $user) {
            $lesson = $lessons[$index];

            $exam = \App\Exam::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id
            ]);

            $answer = [];
            foreach ($lesson->mcqs as $mcq) {
                $selected = $mcq->options[random_int(0, $mcq->options->count() -1 )];
                $answer[] = new \App\Answer([
                    'mcq_id' => $mcq->id,
                    'option_id' => $selected->id,
                    'verdict' => $selected->is_answer
                ]);
            }

            $exam->answers()->saveMany($answer);
        }
    }
}
