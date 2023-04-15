<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class draftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drafts')->insert([
            'title' => 'cím1',
            'synopsis' => 'szinopszis1',
            'serial' => 1,
            'body' => 'szöveg1',
            'content_id' => 22,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('drafts')->insert([
            'title' => 'cím2',
            'synopsis' => 'szinopszis2',
            'serial' => 2,
            'body' => 'szöveg2',
            'content_id' => 23,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('drafts')->insert([
            'title' => 'cím3',
            'synopsis' => 'szinopszis3',
            'serial' => 3,
            'body' => 'szöveg3',
            'content_id' => 24,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('drafts')->insert([
            'title' => 'cím4',
            'synopsis' => 'szinopszis4',
            'serial' => 4,
            'body' => 'szöveg4',
            'content_id' => 41,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
