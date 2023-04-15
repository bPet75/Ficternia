<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class commentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'body' => 'nagyon jó!',
            'user_id' => 2,
            'rating' => 4,
            'chapter_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('comments')->insert([
            'body' => 'szar!!!4!',
            'user_id' => 2,
            'chapter_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('comments')->insert([
            'body' => 'nem is!',
            'user_id' => 1,
            'chapter_id' => 1,
            'parent_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('comments')->insert([
            'body' => 'de!',
            'user_id' => 2,
            'chapter_id' => 1,
            'parent_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('comments')->insert([
            'body' => 'nem!',
            'user_id' => 1,
            'chapter_id' => 1,
            'parent_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('comments')->insert([
            'body' => 'nagyon jó!!',
            'user_id' => 2,
            'chapter_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('comments')->insert([
            'body' => 'köszi!',
            'user_id' => 1,
            'chapter_id' => 1,
            'parent_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
