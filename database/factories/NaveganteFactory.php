<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Navegante;
use Faker\Generator as Faker;

$factory->define(Navegante::class, function (Faker $faker) {
    return [
        'id' => $faker->ean8,
        'nombres' => $faker->name,
        'telefono' => $faker->ean8,
        'email' => $faker->email,

       
    ];
});
