<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pago;
use Faker\Generator as Faker;

$factory->define(Pago::class, function (Faker $faker) {
    return [
        // 'id' => $faker->numberBetween($min = 1, $max = 1000),
        'tupa_id' => 1,
        'navegante_id' => '70515941',
        'num_op' =>$faker->ean8,
        'monto' => $faker->numberBetween($min = 1, $max = 1000),
        'estado' => "0",
        'archivo' => $faker->url,
        'mensaje' => 'Enviado para revisión',
        
    ];
});
