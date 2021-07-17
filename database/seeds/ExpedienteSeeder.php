<?php

use Illuminate\Database\Seeder;
use App\Expediente;
class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exp = new Expediente();
        $exp->id = "2000070";
        $exp->num_folios = 5;
        $exp->asunto = "Solicitud de prácticas pre-profesionales";
        $exp->archivo = "solicitud.pdf";
        $exp->url = "https://getbootstrap.com/docs/4.6/utilities/shadows/e";
        $exp->tipo_documento_id = 3;
        $exp->navegante_id = "70515941";
        $exp->estado = 1;
        $exp->save();
        
        factory(App\Expediente::class, 5)->create();
    }
}
