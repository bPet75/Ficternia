<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class locationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'name' => 'The Crystal Caves',
            'state' => '',
            'ruler' => '',
            'founder_name' => '',
            'date_of_founding' => '1000-01-14',
            'history' => '',
            'img_path' => "loc01.png",
            'content_id' => 13,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "The Crystal Caves are a network of underground caverns located deep within the heart of the mountain range. The caves are known for their striking crystal formations that glitter and shine in the light, casting a rainbow of colors across the walls. The caves are treacherous, with narrow passageways and steep drops, but they are also home to a variety of rare gems and minerals. The caves are also home to dangerous creatures, including giant spiders and rock elementals, who guard the valuable treasures within. Adventurers and miners come from far and wide to explore the Crystal Caves, but few return with their lives and treasures, making it a challenging and dangerous but rewarding location."
        ]);
        DB::table('locations')->insert([
            'name' => 'Eldrida',
            'state' => '',
            'ruler' => '',
            'founder_name' => '',
            'date_of_founding' => '503-11-04',
            'history' => '',
            'img_path' => "loc02.png",
            'content_id' => 14,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => "The land of Eldrida is a lush, enchanted forest. It is known for its towering trees, ancient ruins, and vibrant wildlife. The forest is home to many magical creatures such as unicorns, centaurs, and talking animals. It is also home to a powerful coven of witches, who use their knowledge of magic to protect and preserve the forest. Many travelers seek to enter Eldrida, but only a select few are granted permission by the coven. Those who are allowed to enter the forest are often on a quest or have a specific purpose, as the forest is sacred and should not be disturbed without a good cause. The forest is also said to have healing properties, and many seek to find the legendary healing spring deep within the forest. Eldrida is shrouded in mystery and magic, making it a place of wonder and awe."
        ]);
        DB::table('locations')->insert([
            'name' => 'Kingdom of Arden',
            'state' => '',
            'ruler' => 'Queen Isadora',
            'founder_name' => 'King Alderic the Great',
            'date_of_founding' => '1250-05-23',
            'history' => 
            "Throughout its history, the Kingdom of Arden has been ruled by a succession of powerful monarchs, who have maintained its stability and prosperity. It has faced many challenges, including invasions, civil wars, and economic downturns, but has always emerged stronger. The kingdom is known for its skilled artisans, who produce beautiful works of art and craftsmanship, including weapons, armor, and jewelry. The kingdom is surrounded by a powerful magical barrier, which protects it from invaders and monsters. Trade and diplomacy are important to Arden and it maintains good relations with its neighboring countries.",
            'img_path' => "loc03.png",
            'content_id' => 15,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => "The Kingdom of Arden was founded by King Alderic the Great, a powerful warrior and leader, in the year 1250. King Alderic united the various small kingdoms and fiefdoms that existed in the region, through a combination of military conquest and diplomatic means. He established a strong central government and a well-trained standing army. He also commissioned the construction of grand castles and cities, which served to strengthen the kingdom's infrastructure and boost its economy. King Alderic's rule was characterized by a strong sense of justice and fair governance, which helped to win the loyalty and support of the people. He is remembered as one of the greatest kings in the history of Arden, and his legacy continues to shape the kingdom to this day.Currently, the kingdom is ruled by Queen Isadora, who inherited the throne from her father, King Eadric, after his passing. She is a young and dynamic leader, who is determined to continue the legacy of her ancestors and to lead the kingdom to a new era of prosperity. Queen Isadora is an accomplished warrior and diplomat, who has already achieved several diplomatic victories and has been able to keep the kingdom's enemies at bay. She is also known for her interest in the arts, and has been supporting the development of the kingdom's culture and arts. The people of Arden are fiercely loyal to their queen and they see her as a symbol of hope and a bright future for the kingdom."
        ]);
        DB::table('locations')->insert([
            'name' => 'Empire of Zoltar',
            'state' => '',
            'ruler' => 'Emperor Vayne',
            'founder_name' => 'Emperor Zoltar the Conqueror',
            'date_of_founding' => '800-07-20',
            'history' => 
            "Throughout its history, the Empire of Zoltar has been marked by a series of internal conflicts, power struggles and invasions, but it always managed to survive and maintain its dominance in the region. The empire is known for its advanced technology and its powerful magical practices, which allowed it to develop powerful war machines and keep the neighboring countries in check. The empire is also known for its cultural richness and its architectural marvels, such as the grand palace of the emperor, the Zoltarian Temple, and the Golden Tower.",
            'img_path' => "loc04.png",
            'content_id' => 16,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => "The Empire of Zoltar was founded by Emperor Zoltar the Conqueror in the year 800. Emperor Zoltar was a powerful warlord who united the various tribes and city-states that existed in the region under his rule. He built a strong centralized government and established a powerful army, which he used to expand his territory through military conquest. He also implemented a system of taxation and trade which greatly increased the empire's wealth and power. Emperor Zoltar was known for his ambition and his willingness to use any means necessary to achieve his goals, earning him a reputation as a ruthless leader.Currently, the Empire of Zoltar is ruled by Emperor Vayne, the descendant of Emperor Zoltar the Conqueror. Emperor Vayne inherited the throne from his father, Emperor Gaius, after his passing. He is a cunning and ambitious leader who seeks to further expand the empire's territory and increase its power. He is known for his strategic mind and his ability to rally his troops to victory. He also has a keen interest in the arcane arts and has been investing in the development of new and powerful magical artifacts. The people of Zoltar respect and fear their emperor, and they see him as a symbol of the empire's strength and invincibility."
        ]);
    }
}
