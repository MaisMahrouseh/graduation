<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Ranim
class UserSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            ['firstname' =>'ahmad',
             'lastname' =>'admin',
             'email' => 'm@m.com',
             'password'=>Hash::make('admin'),
             'phone' =>'+963-987654321',
             'is_admin' =>1,

            ],
        ]);
    }
}
