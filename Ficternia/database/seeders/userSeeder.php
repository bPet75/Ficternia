<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'felhasznalo',
            'first_name' => 'kiss',
            'last_name' => 'janos',
            'date_of_birth' => '2000-09-15',
            'img_path' => 'usr1.png',
            'password' => '$2y$10$qI7lE9f3pz.lyDXyxF.BB.3ciQpg6a1qakIBbDjBIWJ04DhlXqY0G',
            'email' => 't@t',
            'role_id' => 2,
            'description' => 'valami1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'username' => 'felhasznalo2',
            'first_name' => 'kiss',
            'last_name' => 'janos',
            'date_of_birth' => '2000-09-15',
            'img_path' => 'usr2.png',
            'password' => '$2y$10$qI7lE9f3pz.lyDXyxF.BB.3ciQpg6a1qakIBbDjBIWJ04DhlXqY0G',
            'email' => 'f@f',
            'role_id' => 2,
            'description' => 'valami2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'username' => 'felhasznalo3',
            'first_name' => 'kiss',
            'last_name' => 'janos',
            'date_of_birth' => '2000-09-15',
            'img_path' => 'usr3.png',
            'password' => '$2y$10$qI7lE9f3pz.lyDXyxF.BB.3ciQpg6a1qakIBbDjBIWJ04DhlXqY0G',
            'email' => 'k@k',
            'role_id' => 2,
            'description' => 'valami3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
