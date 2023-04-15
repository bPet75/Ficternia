<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class religionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->insert([
            'name' => 'The Sun-worshippers',
            'description' => "The religion of the Sun-worshippers is a prominent faith in the fantasy world. Its followers believe in the power of the sun, which they see as a powerful deity that brings light, warmth, and life to the world. They believe that by worshiping the sun and following its teachings, they can bring about prosperity, good health, and happiness.The Sun-worshippers have a complex system of beliefs, rituals, and practices that are centered around the worship of the sun. They believe that the sun is a powerful source of energy and that it can be harnessed for healing and protection. They also believe that the sun is a symbol of truth, justice and wisdom and that it can guide them on the right path.The Sun-worshippers have a strong tradition of temple-building, and they have built many grand temples, shrines, and monuments dedicated to the sun across the land. These temples are often located on high places, such as mountaintops or hilltops, where they can receive the sun's rays directly. They also have a tradition of pilgrimage, where they visit these temples to offer prayers and to receive blessings from the priests.The Sun-worshippers have a strong sense of community, and they often come together for festivals and celebrations to honor the sun and to give thanks for its blessings. They also have a strong tradition of charity, and they often provide aid to those in need, believing that it's a way to honor the sun and to bring about good in the world.The religion of the Sun-worshippers is widely practiced in the fantasy world and it's considered one of the most prominent and respected religion. It's followers believe that by following the teachings of the sun, they can bring about peace and prosperity, and they seek to spread its teachings to all the people of the world.",
            'content_id' => 19,
        ]);
        DB::table('religions')->insert([
            'name' => 'The Blood Cult',
            'description' => "The religion of the Blood Cult is a sinister and mysterious faith in the dark fantasy world. Its followers believe in the power of blood and sacrifice, which they see as a means to gain power and favor from the dark deities they worship. They believe that by offering blood sacrifices, they can appease the deities, who will in turn grant them strength, protection, and even immortality.The Blood Cult has a complex system of beliefs, rituals, and practices that are centered around the sacrifice of blood. They believe that the blood of living creatures, especially humans, is the most powerful offering and that it can be used to summon powerful dark entities, to make powerful magic and to grant blessings. They often perform these sacrifices in secret, hidden shrines and sacred places, and they are fiercely protective of their rituals.The Blood Cult is a secretive and dangerous religion, and its followers are often seen as outcasts and heretics by the rest of society. They are known for their willingness to do whatever it takes to achieve their goals, and they have been known to carry out acts of terror, murder and human sacrifices. They are feared by many, but also respected by some, who believe that they possess powerful magic and knowledge.",
            'content_id' => 20,
        ]);
    }
}
