<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class audiencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('audiences')->insert([
            'name' => 'kozonseg1',
        ]);
        DB::table('audiences')->insert([
            'name' => 'kozonseg2',
        ]);
    }
}
