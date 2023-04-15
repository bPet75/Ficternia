<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(roleSeeder::class);
        $this->call(genreSeeder::class);
        $this->call(audiencesSeeder::class);
        $this->call(stateSeeder::class);
        $this->call(userSeeder::class);
        $this->call(projectSeeder::class);
        $this->call(contentSeeder::class);
        $this->call(religionSeeder::class);
        $this->call(storySeeder::class);
        $this->call(characterSeeder::class);
        $this->call(characterPropertySeeder::class);
        $this->call(locationSeeder::class);
        $this->call(questionSeeder::class);   
        $this->call(eventSeeder::class);   
        $this->call(noteSeeder::class);   
        $this->call(draftSeeder::class);   
        $this->call(chapterSeeder::class);   
        $this->call(commentSeeder::class);   
        $this->call(collectionSeeder::class);   
        $this->call(SubscribsionSeeder::class);   
        $this->call(contentToContentSeeder::class);   
        $this->call(bookListSeeder::class);   
        $this->call(bookListBookSeeder::class);   
    }
}
