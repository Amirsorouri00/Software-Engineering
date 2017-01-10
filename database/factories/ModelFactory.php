<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Basket::class, function (Faker\Generator $faker) {
    return [
        'basketID' => str_random(7),
        'questionerID' =>str_random(7),
        'responderedID' =>str_random(7),
        'flag' => '1'
    ];
});

$factory->define(App\Exam::class, function (Faker\Generator $faker) {
    return [
        'examID' => str_random(7),
        'lessonGroup' => $faker->jobTitle,
        'average' => $faker->randomFloat(null,0,20)
    ];
});

$factory->define(App\Classexam::class, function (Faker\Generator $faker) {
    return [
        'classID' => str_random(7),
        'instructorID' => App\Classindividual::where('accessibility',1)->firstOrFail()->instructorID,
        'department' => $faker->jobTitle,
        'location' => 'Isfahan',
    ];
});

$factory->define(App\Classindividual::class, function (Faker\Generator $faker) {
    return [
        'personalID' => str_random(7),
        'classID' => App\Classexam::all()->random()->classID,
        'accessibility' => 0,
        'isPresent' => 1,
        'isActive' => 1,
    ];
});

$factory->define(App\Studentinfo::class, function (Faker\Generator $faker) {
    return [
        'participantID' => App\Classindividual::all()->random()->personalID,
        'examID' => str_random(7),
        'roundNumber' => $faker->randomDigit,
        'individualStatus' => $faker->randomElement([1,0]),
        'finalScore' => $faker->randomFloat(null,0,20),
    ];
});

