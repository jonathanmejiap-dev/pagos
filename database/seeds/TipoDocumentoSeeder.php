<?php

use Illuminate\Database\Seeder;
use App\Tipo_documento;


class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tipodoc = new Tipo_documento();
        $tipodoc->id = 1;
        $tipodoc->nombre = "Carta";
        $tipodoc->save();

        $tipodoc = new Tipo_documento();
        $tipodoc->id = 2;
        $tipodoc->nombre = "Oficio";
        $tipodoc->save();

        $tipodoc = new Tipo_documento();
        $tipodoc->id = 3;
        $tipodoc->nombre = "Solicitud";
        $tipodoc->save();

        $tipodoc = new Tipo_documento();
        $tipodoc->id = 4;
        $tipodoc->nombre = "Resolucion";
        $tipodoc->save();

        $tipodoc = new Tipo_documento();
        $tipodoc->id = 5;
        $tipodoc->nombre = "Notificación";
        $tipodoc->save();
    }
}
