<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Mcq;
use Faker\Generator as Faker;

$factory->define(Mcq::class, function (Faker $faker) {
    return [
        'question' => $faker->text(120)
    ];
});
