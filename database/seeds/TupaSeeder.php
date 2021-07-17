<?php

use App\Tupa;
use Illuminate\Database\Seeder;

class TupaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $seg = new Tupa();
        $seg->id = 1;
        $seg->nombre = "Carnet / fotocheck";
        $seg->monto = 10.00;
        $seg->estado = "1";
        $seg->save();

        $seg = new Tupa();
        $seg->id = 2;
        $seg->nombre = "Titulación derechos del titulado";
        $seg->monto = 600.00;
        $seg->estado = "1";
        $seg->save();

        $seg = new Tupa();
        $seg->id = 3;
        $seg->nombre = "constancia de estudios";
        $seg->monto = 15.00;
        $seg->estado = "1";
        $seg->save();

        $seg = new Tupa();
        $seg->id = 4;
        $seg->nombre = "Constancia de vacante";
        $seg->monto = 10.00;
        $seg->estado = "1";
        $seg->save();


    }
}
