<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //factory(App\Navegante::class, 2)->create();
        $this->call(UsersSeeder::class);
        // $this->call(NaveganteSeeder::class);activar
        //$this->call(TupaSeeder::class);activar
        // $this->call(PagoTupaSeeder::class);
        // factory(App\Pago::class, 10)->create();activar
        // $this->call(TipoDocumentoSeeder::class);
        // $this->call(ExpedienteSeeder::class);
        // $this->call(AreaSeeder::class);
        // $this->call(MovimientoSeeder::class);
        // $this->call(SeguimientoSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
