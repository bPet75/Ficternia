<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class characterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('characters')->insert([
            'name' => 'Alaric the Wise',
            'img_path' => "char01.png",
            'content_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('characters')->insert([
            'name' => 'Aric the sorcerer',
            'img_path' => "char02.png",
            'content_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('characters')->insert([
            'name' => 'Sorin Shadowstrike',
            'img_path' => "char03.png",
            'content_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('characters')->insert([
            'name' => 'Elara',
            'img_path' => "char04.png",
            'content_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('characters')->insert([
            'name' => 'Isabella',
            'img_path' => "char05.png",
            'content_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('characters')->insert([
            'name' => 'Kethril Shadowstrike',
            'img_path' => "char06.png",
            'content_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
