<?php

use Illuminate\Database\Seeder;
use App\Seguimiento;

class SeguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seg = new Seguimiento();
        $seg->id = 1;
        $seg->fecha = now();
        $seg->ver = "Ver archivo";
        $seg->acciones = "Documento en trámite";
        $seg->expediente_id = "2000070";
        $seg->area_id = 1;
        $seg->movimiento_id = 2;
        $seg->user_id = 1;
        $seg->save();
    }
}
