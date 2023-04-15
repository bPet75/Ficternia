<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class chapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chapters')->insert([
            'title' => 'első',
            'serial' => 1,
            'body' => 'első tartalom',
            'draft_id' => 1,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('chapters')->insert([
            'title' => 'második',
            'serial' => 2,
            'body' => 'második tartalom',
            'draft_id' => 2,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('chapters')->insert([
            'title' => 'harmadik',
            'serial' => 3,
            'body' => 'harmadik tartalom',
            'draft_id' => 3,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('chapters')->insert([
            'title' => 'negyedik',
            'serial' => 4,
            'body' => 'negyedik tartalom',
            'draft_id' => 4,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
