<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Question;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Question::class, static function (Faker $faker) {
    return [
        'question_text' => Str::random('10'),
        'quiz_id'       => 1
    ];
});
