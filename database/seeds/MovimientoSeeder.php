<?php

use Illuminate\Database\Seeder;
use App\Movimiento;
class MovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mov = new Movimiento();
        $mov->id = 1;
        $mov->nombre = "ENVIADO";
        $mov->save();

        $mov = new Movimiento();
        $mov->id = 2;
        $mov->nombre = "ACEPTADO";
        $mov->save();

        $mov = new Movimiento();
        $mov->id = 3;
        $mov->nombre = "RECHAZADO";
        $mov->save();

        $mov = new Movimiento();
        $mov->id = 4;
        $mov->nombre = "DERIVADO";
        $mov->save();

        $mov = new Movimiento();
        $mov->id = 5;
        $mov->nombre = "FINALIZADO";
        $mov->save();
    }
}
