<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Quiz;

$factory->define(Quiz::class, static function (Faker $faker) {
    return [
        'title' => $faker->name,
    ];
});
