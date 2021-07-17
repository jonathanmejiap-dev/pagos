<?php

use Illuminate\Database\Seeder;
use App\Navegante;

class NaveganteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $nav = new Navegante();
        $nav->id = "70515941";
        $nav->nombres = "Fernando Palacios";
        $nav->telefono = "923809515";
        $nav->email = "hofman@gmail.com";
        $nav->save();

        factory(App\Navegante::class, 10)->create();
    }
}
