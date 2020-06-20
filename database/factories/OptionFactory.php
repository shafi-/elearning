<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Option;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(random_int(1,6)),
        'is_answer' => false
    ];
});
