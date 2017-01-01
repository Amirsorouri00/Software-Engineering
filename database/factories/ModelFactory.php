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


$factory->define(App\Studentinfo::class, function (Faker\Generator $faker) {
    return [
        'participantID' => str_random(7),
        'examID' => str_random(7),
        'roundNumber' => $faker->randomDigit,
        'individualStatus' => $faker->randomElement([1,0]),
        'finalScore' => $faker->randomFloat(null,0,20),

    ];
});

