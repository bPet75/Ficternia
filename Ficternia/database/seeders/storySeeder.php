<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class storySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stories')->insert([
            'title' => 'The Last Heir of Aeloria',
            'description' => 
            "The Last Heir of Aeloria is a high fantasy novel that follows the journey of a young orphan named Elara. Elara is just an ordinary girl living in a small village, until the day she discovers that she is the last heir of the Aelorian royal family, a powerful dynasty that ruled over the kingdom for centuries.Elara is thrust into a dangerous world of politics and power struggles as she tries to reclaim her rightful place as the queen of Aeloria. She is accompanied on her journey by a band of unlikely allies, including a rogue prince, a skilled assassin, and a powerful sorcerer. Together, they must navigate through treacherous enemies, ancient prophecies, and powerful magic as they attempt to overthrow the corrupt ruling council and restore peace to the kingdom.As Elara learns to embrace her destiny, she also discovers hidden truths about her family's past and a dark secret that threatens to destroy everything she holds dear. She must make difficult choices and sacrifices as she fights to take back her kingdom and save her people.",
            'genre_id' => 1,
            'audience_id' => 1,
            'state_id' => 1,
            'img_path' => "story01.png",
            'content_id' => 1,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('stories')->insert([
            'title' => 'The Children of the Night',
            'description' => 
            "The Children of the Night is a dark fantasy novel that takes place in a world where darkness reigns and ancient powers threaten to destroy humanity. The story follows the journey of a young orphan named Raven, who is taken in by a mysterious group known as the Children of the Night. The Children are a secret society of outcasts and misfits, who possess the power to control the darkness and use it to fight against the ancient evil that threatens to engulf the world.As Raven learns to harness her own powers and becomes a skilled warrior, she discovers that the Children of the Night are not the only ones with the power to control the darkness. There is a powerful enemy lurking in the shadows, an ancient being known as the Night King, who seeks to enslave humanity and plunge the world into eternal darkness.Raven and the Children of the Night must race against time to stop the Night King and his army of darkness before it's too late. Along the way, they face terrifying creatures, treacherous allies, and difficult moral dilemmas as they struggle to uncover the truth about the Night King and his origins.",
            'genre_id' => 2,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "story02.png",
            'content_id' => 2,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori3',
            'description' => 
            "leírás",
            'genre_id' => 3,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 28,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori4',
            'description' => 
            "leírás",
            'genre_id' => 3,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 29,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori5',
            'description' => 
            "leírás",
            'genre_id' => 3,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 30,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori6',
            'description' => 
            "leírás",
            'genre_id' => 10,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 31,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori7',
            'description' => 
            "leírás",
            'genre_id' => 4,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 32,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori8',
            'description' => 
            "leírás",
            'genre_id' => 5,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 33,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori9',
            'description' => 
            "leírás",
            'genre_id' => 2,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 34,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori10',
            'description' => 
            "leírás",
            'genre_id' => 1,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 35,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori11',
            'description' => 
            "leírás",
            'genre_id' => 6,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 36,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori12',
            'description' => 
            "leírás",
            'genre_id' => 7,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 37,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori13',
            'description' => 
            "leírás",
            'genre_id' => 7,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 38,
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori14',
            'description' => 
            "leírás",
            'genre_id' => 7,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 39,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('stories')->insert([
            'title' => 'sztori15',
            'description' => 
            "leírás",
            'genre_id' => 8,
            'audience_id' => 2,
            'state_id' => 2,
            'img_path' => "",
            'content_id' => 40,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
