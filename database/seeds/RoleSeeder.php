<?php

use Illuminate\Database\Seeder;

use App\Permission\Models\Role;
use App\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement("SET foreign_key_checks=0");
        //     DB::table('role_user')->truncate();
        //     DB::table('permission_role')->truncate();
        //     Permission:truncate();
        // DB::statement("SET foreign_key_checks=1");
        
        //
        $rol = new Role();
        $rol->name = 'Admin';
        $rol->slug = 'admin';
        $rol->description = 'Administrador';
        $rol->full_access = 'yes';
        $rol->save();

        $rol = new Role();
        $rol->name = 'Usuario registrado';
        $rol->slug = 'usuarioregistrado';
        $rol->description = 'Usuario registrado';
        $rol->full_access = 'no';
        $rol->save();

        // $rol = new Role();
        // $rol->name = 'Guest';
        // $rol->slug = 'guest';
        // $rol->description = 'guest';
        // $rol->full_access = 'no';
        // $rol->save();

        // $rol = new Role();
        // $rol->name = 'Test';
        // $rol->slug = 'test';
        // $rol->description = 'test';
        // $rol->full_access = 'no';
        // $rol->save();

        //poblando la tabla roles
        $user = User::find(1);

        //$user->roles()->attach([1,3]);
        //$user->roles()->detach([3]);
        // $user->roles()->sync([1,3]);
        $user->roles()->sync([1]);

        // $user = User::find(2);
        // $user->roles()->sync([2,3]);

        // $user = User::find(3);
        // $user->roles()->sync([3]);


        
    }
}
