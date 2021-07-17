<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expediente;
use Faker\Generator as Faker;

$factory->define(Expediente::class, function (Faker $faker) {
    return [
        'id' => $faker->ean8,
        'num_folios' =>$faker->randomDigit,
        'asunto' =>$faker->sentence($nbWords = 6, $variableNbWords = true),
        'archivo' => "documento20.pdf",
        'url' =>$faker->url,
        'tipo_documento_id' =>1,
        'navegante_id' => "70515941",
        'estado' => "1",
    ];
});
