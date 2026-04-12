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

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'provider_id' => function () {
            return factory('App\Provider')->create()->id;
        },
        'location' => $faker->word,
        'code' => $faker->ean13,
        'name' => $faker->sentence,
        'quantity' => $faker->randomDigit,
        'subquantity' => $faker->randomDigit,
        'price' => $faker->randomFloat,
        'priceWithTaxes' => $faker->randomFloat,
        'taxesAmount' => $faker->randomFloat,
        'purchase_price' => $faker->randomFloat,
        'measure' => 'Unid',
        'max' => $faker->randomDigit,
        'min' => $faker->randomDigit,
    ];
});
