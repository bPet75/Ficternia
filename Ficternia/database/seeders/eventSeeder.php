<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class eventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'name' => 'The War of the Dragon Lord',
            'parent_id' => null,
            'starting_time' => '1250-01-15',
            'ending_time' => '1275-06-27',
            'content_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "The War of the Dragon Lord was a devastating conflict that lasted from the year 1250 to 1275 in the fantasy world. The war was sparked by the rise of a powerful dragon, known as the Dragon Lord, who sought to conquer and rule the land. The dragon's immense power and army of dragon riders proved to be a formidable force, and many kingdoms and city-states fell under its control. The dragon's reign of terror lasted for 25 years, with countless lives lost and cities destroyed.

            The war was fought on many fronts, as different factions rose to challenge the dragon's rule. The most notable of these was the Alliance of the Free Peoples, which was formed by a group of brave warriors, powerful sorcerers, and wise leaders. They managed to gather an army of soldiers and volunteers from different nations and cultures, and led a series of daring raids and battles against the dragon's forces. Their efforts paid off, and they were able to weaken the dragon's power and put an end to its reign.
            
            The final battle of the war was fought at the Dragon Lord's stronghold, a massive fortress built on top of a volcano. The Alliance of the Free Peoples, led by the legendary hero Aric the Brave, managed to infiltrate the fortress and engage the dragon in a fierce and epic battle. After a long and grueling fight, Aric was able to strike the killing blow on the dragon, ending the war and restoring peace to the land.
            
            The War of the Dragon Lord was a defining moment in the history of the fantasy world, as it marked the end of an era of terror and oppression, and the beginning of a new era of hope and rebuilding. The Alliance of the Free Peoples became a symbol of unity and resistance, and their victory is still celebrated to this day."
        ]);
        DB::table('events')->insert([
            'name' => 'The Siege of Fort Ravenswatch',
            'parent_id' => 1,
            'starting_time' => '1450-03-20',
            'ending_time' => '1452-11-15',
            'content_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "The Siege of Fort Ravenswatch was a historical event that took place between the years 1450 and 1452. This was a low fantasy story, meaning that the events were based in a world similar to our own and magic was not widely present or powerful.

            Fort Ravenswatch was a strategic fortress located on the border of two rival kingdoms, the Kingdom of Arathia and the Kingdom of Eldrida. The fort was built to defend against invasions and to control the trade routes. The Kingdom of Arathia, under the command of King Reginald II, laid siege to the fort, seeking to gain control of the trade routes and gain an advantage over its rival.
            
            The Siege of Fort Ravenswatch was a brutal and bloody affair, with both sides suffering heavy casualties. The fort's defenders, led by the experienced and skilled Captain Marcus, put up a brave resistance, but they were ultimately outnumbered and outmatched by the Arathian army. The siege lasted for two years, during which time both sides engaged in intense battles, raids, and sorties.
            
            In the end, the Kingdom of Arathia emerged victorious, and the fort fell to its forces. King Reginald II ordered the fort to be rebuilt and reinforced, and it became a powerful stronghold for Arathia, giving them control over the trade routes and access to valuable resources. The Siege of Fort Ravenswatch is remembered as one of the most significant events in the history of both Arathia and Eldrida, and it had a lasting impact on the political and economic landscape of the region."
        ]);
        DB::table('events')->insert([
            'name' => 'The Black Plague',
            'parent_id' => 2,
            'starting_time' => '1451-9-14',
            'ending_time' => '1650-9-14',
            'content_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "The Black Plague of 14th century was a devastating historical event that took place in a low fantasy world. The event began in 1451 and lasted for several years, spreading rapidly across the continent, killing millions of people. The plague was caused by a highly contagious and deadly disease, which was spread by fleas that infested rats.

            The Black Plague had a profound impact on the people of the world, causing widespread death and suffering. Many towns and villages were left deserted as people fled in search of safety, and the economy was severely affected as trade came to a standstill. The ruling classes, as well as the poor, were affected by the disease and it didn't discriminate.
            
            The Church and the Medical community were unable to provide an effective cure, and many people turned to superstition and folk remedies in a desperate bid to survive. The plague also had a profound effect on the social and cultural fabric of the world, as people grappled with the scale of death and the fragility of life.
            
            The Black Plague had significant long-term effects, it reshaped the population, economy, and social structure of the continent, and it also led to major changes in the religious and intellectual landscape. It's considered one of the most devastating pandemics in human history, and it took centuries for the population to recover. The memory of the Black Plague remained deeply ingrained in the collective memory of the people and it continued to shape their beliefs and practices for generations to come."
        ]);
        DB::table('events')->insert([
            'name' => 'The Battle of the Crimson Fields',
            'parent_id' => 3,
            'starting_time' => '1261-01-16',
            'ending_time' => '1261-01-16',
            'content_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "The Battle of the Crimson Fields was a historical event that took place in a fantasy world. The battle was fought between two powerful armies, the Kingdom of Eldrida and the Dark Horde of the Necromancer. The battle was fought in the year 1261, on a vast plain known as the Crimson Fields, which was stained red with the blood of the fallen.

            The Dark Horde was led by the Necromancer, a powerful sorcerer who sought to conquer the kingdoms of the land and enslave their people. The Necromancer commanded an army of undead soldiers, who were raised from the corpses of the fallen, and who were under his control. The Kingdom of Eldrida, under the command of King Galadriel, was one of the few kingdoms who dared to stand against the Necromancer and his horde.
            
            The Battle of the Crimson Fields was a fierce and brutal affair, with both sides suffering heavy casualties. The Necromancer's undead army was almost unstoppable, and it seemed as if the kingdom would be overrun. However, King Galadriel and his army fought with valor and courage, and they were able to push back the horde.
            
            The turning point of the battle came when the King Galadriel and a group of powerful wizards were able to break the Necromancer's control over the undead and turn them against their master. The Necromancer was defeated, and his army was destroyed. The battle was won, but at great cost, the Kingdom of Eldrida had suffered heavy losses, and it would take many years for it to recover.
            
            The Battle of the Crimson Fields is remembered as one of the most significant events in the history of the fantasy world, and it had a lasting impact on the political and magical landscape of the region. The defeat of the Necromancer marked the end of his reign of terror, and it gave hope to the people that they could stand against the darkness and win."
        ]);
        DB::table('events')->insert([
            'name' => 'uj1',
            'parent_id' => null,
            'type' => 'chapter',
            'starting_time' => '1261-01-16',
            'ending_time' => '1261-01-16',
            'content_id' => 26,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "valami1"
        ]);
        DB::table('events')->insert([
            'name' => 'uj2',
            'parent_id' => 5,
            'starting_time' => '1061-01-16',
            'ending_time' => '1261-01-16',
            'content_id' => 27,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => 
            "valami2"
        ]);
    }
}
