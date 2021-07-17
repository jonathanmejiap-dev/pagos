<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->id =  1;
        $user->name = "Ing. César Vásquez";
        $user->email = "cesar@gmail.com";
        $user->password = Hash::make("cesar2020");
        $user->save();

        $user = new User();
        $user->id =  2;
        $user->name = "Ing. Emerson Chávez";
        $user->email = "emerson@gmail.com";
        $user->password = Hash::make("emerson2020");
        $user->save();

        $user = new User();
        $user->id =  3;
        $user->name = "Lic. Kuteis Catacora";
        $user->email = "kuteis@gmail.com";
        $user->password = Hash::make("kuteis2020");
        $user->save();
    }
}
