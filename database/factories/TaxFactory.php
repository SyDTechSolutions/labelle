<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Tax::class, function (Faker $faker) {
    return [
        'code' => '01',
        'name' => $faker->name,
        'tarifa' => $faker->randomNumber(2), // secret
       
    ];
});
