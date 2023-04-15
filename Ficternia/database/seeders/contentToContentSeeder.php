<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class contentToContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Story - Character
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 7
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 8
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 9
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 10
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 11
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 12
        ]);

        //Story - Event
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 3
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 4
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 5
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 6
        ]);

        //Story - Location
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 13
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 14
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 15
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 16
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 17
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 2,
            'second_id' => 18
        ]);

        //Story - Religion
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 19
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 20
        ]);

        //Character - Religion
        DB::table('content_to_contents')->insert([
            'first_id' => 7,
            'second_id' => 19
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 8,
            'second_id' => 19
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 9,
            'second_id' => 19
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 10,
            'second_id' => 20
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 11,
            'second_id' => 20
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 12,
            'second_id' => 20
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 21
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 22
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 23
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 24
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 25
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 25,
            'second_id' => 22
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 25,
            'second_id' => 23
        ]);

        DB::table('content_to_contents')->insert([
            'first_id' => 22,
            'second_id' => 7
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 26
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 27
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 22,
            'second_id' => 26
        ]);
        DB::table('content_to_contents')->insert([
            'first_id' => 1,
            'second_id' => 41
        ]);
    }
}
