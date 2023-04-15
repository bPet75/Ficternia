<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class genreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            'name' => 'zsaner1',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner2',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner3',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner4',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner5',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner6',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner7',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner8',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner9',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner10',
        ]);
        DB::table('genres')->insert([
            'name' => 'zsaner11',
        ]);
    }
}
