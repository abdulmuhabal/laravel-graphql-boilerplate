<?php

use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->role = 'ADMIN';
        $user->email = 'admin@graphl.com';
        $user->phone = 1234567891;
        $user->password = bcrypt('adminadmin');
        $user->save();

        // $user = new User();
        // $user->role = 'Client';
        // $user->name = 'Client Client';
        // $user->email = 'user@graphl.com';
        // $user->phone = 1234567894;
        // $user->password = bcrypt('adminadmin');
        // $user->save();
        
    }
}
