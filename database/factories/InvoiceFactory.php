<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Invoice;
use App\User;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        "customer_id" => factory(Customer::class),
        "consecutivo" => $faker->randomDigit,
        "tipo_identificacion_cliente" => '01',
        "identificacion_cliente" => '503600224',
        "cliente" => $faker->name,
        "email" => $faker->email,
        "TipoDocumento" => $faker->randomElement(['01','04']),
        "MedioPago" => $faker->randomElement(['01','02']),
        "CondicionVenta" => $faker->randomElement(['01','02']),
        "CodigoMoneda" => 'CRC',
        "TotalComprobante" => $total = $faker->randomFloat,
        "TotalWithNota" => $total,
        "created_by" => factory(User::class),


    ];
});
