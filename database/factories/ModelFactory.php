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
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
    ];
});

$factory->define(\App\Manuskripte\Manuskript::class, function (Faker\Generator $faker) {
    return [
        'Kodextitel' => $faker->words(3, true)
    ];
});

// Variant Reading image annotation
$factory->define(\App\ImageDetail::class, function (Faker\Generator $faker) {
    // relation_id, image_id must be added by eloquent relation
    return [
        "title" => $faker->words(3, true),
        "description" => $faker->paragraph(3, true),
        "x" => $faker->numberBetween(10, 70),
        "y" => $faker->numberBetween(10, 70),
        "width" => $faker->numberBetween(1, 20),
        "height" =>$faker->numberBetween(1, 20)
    ];
});
