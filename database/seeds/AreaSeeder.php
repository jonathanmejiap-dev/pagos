<?php

use Illuminate\Database\Seeder;
use App\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area = new Area();
        $area->id = 1;
        $area->nombre= "MESA DE PARTES"; 
        $area->save();

        $area = new Area();
        $area->id = 2;
        $area->nombre= "SECRETARIA ACADEMICA"; 
        $area->save();

        $area = new Area();
        $area->id = 3;
        $area->nombre= "UNIDAD ACADÉMICA"; 
        $area->save();

        $area = new Area();
        $area->id = 4;
        $area->nombre= "DIRECCIÓN GENERAL"; 
        $area->save();

    }
}
