<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bookListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_lists')->insert([
            'user_id' => 1,
            'title' => 'lista1',
            'description' => 'valami',
            'visibility' => 'public',
        ]);
        DB::table('book_lists')->insert([
            'user_id' => 1,
            'title' => 'lista2',
            'description' => 'valami',
            'visibility' => 'private',
        ]);
        DB::table('book_lists')->insert([
            'user_id' => 2,
            'title' => 'lista3',
            'description' => 'valami',
            'visibility' => 'public',
        ]);
        DB::table('book_lists')->insert([
            'user_id' => 1,
            'title' => 'lista4',
            'description' => 'valami',
            'visibility' => 'private',
        ]);
    }
}
