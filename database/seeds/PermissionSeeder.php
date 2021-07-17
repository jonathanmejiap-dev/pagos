<?php

use Illuminate\Database\Seeder;
use App\Permission\Models\Role;
use App\Permission\Models\Permission;
use App\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_all = []; 

        //
        $permission = new Permission();
        $permission->name = 'List role';
        $permission->slug = 'role.index';
        $permission->description = 'Un usuario puede listar roles';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Show role';
        $permission->slug = 'role.show';
        $permission->description = 'Un usuario puede mostrar roles';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Create role';
        $permission->slug = 'role.create';
        $permission->description = 'Un usuario puede crear roles';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Edit role';
        $permission->slug = 'role.edit';
        $permission->description = 'Un usuario puede editar roles';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Delete role';
        $permission->slug = 'role.delete';
        $permission->description = 'Un usuario puede eliminar roles';
        $permission->save();

        $permission_all[] = $permission->id;

        //secretaria
        $permission = new Permission();
        $permission->name = 'secretaria';
        $permission->slug = 'secretaria.academica';
        $permission->description = 'Acciones de secretaria academica';
        $permission->save();

        $permission_all[] = $permission->id;

        //jefe unidad
        $permission = new Permission();
        $permission->name = 'jefeunidad';
        $permission->slug = 'jefe.unidad';
        $permission->description = 'Acciones del jefe de unidad';
        $permission->save();

        $permission_all[] = $permission->id;

        $roleAdmin = Role::find(1);

        //$roleAdmin->permissions()->sync($permission_all);

        //*********************** */
      

        //
        $permission = new Permission();
        $permission->name = 'List user';
        $permission->slug = 'user.index';
        $permission->description = 'Un usuario puede listar usuarios';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Show user';
        $permission->slug = 'user.show';
        $permission->description = 'Un usuario puede mostrar usuarios';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Edit user';
        $permission->slug = 'user.edit';
        $permission->description = 'Un usuario puede editar usuarios';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Delete user';
        $permission->slug = 'user.delete';
        $permission->description = 'Un usuario puede eliminar usuarios';
        $permission->save();

        $permission_all[] = $permission->id;

        /**
         * Añadido
        */
        $permission = new Permission();
        $permission->name = 'Show own user';
        $permission->slug = 'userown.show';
        $permission->description = 'Un usuario puede mostrar propio usuario';
        $permission->save();

        $permission_all[] = $permission->id;

        $permission = new Permission();
        $permission->name = 'Edit own user';
        $permission->slug = 'userown.edit';
        $permission->description = 'Un usuario puede editar propio usuario';
        $permission->save();
        

        $permission_all[] = $permission->id;

        $roleAdmin = Role::find(1);

       // $roleAdmin->permissions()->sync($permission_all);
    }
}
