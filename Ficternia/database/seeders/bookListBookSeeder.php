<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bookListBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booklist_books')->insert([
            'booklist_id' => 1,
            'book_id' => 1,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 1,
            'book_id' => 2,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 1,
            'book_id' => 4,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 1,
            'book_id' => 6,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 1,
            'book_id' => 7,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 2,
            'book_id' => 1,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 2,
            'book_id' => 3,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 3,
            'book_id' => 4,
        ]);
        DB::table('booklist_books')->insert([
            'booklist_id' => 3,
            'book_id' => 5,
        ]);
    }
}
