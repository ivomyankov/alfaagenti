<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'          => 'Ивайло Мянков',
            'user'          => 'ivomyankov',
            'email'         => 'ivomyankov@gmail.com',
            'password'      => Hash::make('adminpass'),
            'role'          => 'admin',
            'office'        => Str::random(10),
            'phone'         => '0877310177',

        ]);
    }
}
