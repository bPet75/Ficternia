<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class characterPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('character_properties')->insert([
            'name' => 'species',
            'description' => 'Human',
            'character_id' => 1
        ]);
        DB::table('character_properties')->insert([
            'name' => 'class',
            'description' => 'Sorcerer',
            'character_id' => 1
        ]);
        DB::table('character_properties')->insert([
            'name' => 'age',
            'description' => '97',
            'character_id' => 1
        ]);
        DB::table('character_properties')->insert([
            'name' => 'characteristics',
            'description' => 'Alaric is a tall, striking figure with long white hair and piercing blue eyes. He wears a long, flowing robe adorned with symbols of magic and carries a staff adorned with a large crystal.',
            'character_id' => 1
        ]);
        DB::table('character_properties')->insert([
            'name' => 'past',
            'description' => 'Alaric was born into a family of powerful sorcerers and was trained in the art of magic from a young age. He quickly surpassed his teachers and became a master of ancient magic. He was appointed as the court sorcerer of the kingdom and has since dedicated his life to protecting the kingdom and its people.',
            'character_id' => 1
        ]);
        DB::table('character_properties')->insert([
            'name' => 'ideology',
            'description' => "Alaric is a wise and powerful sorcerer, but also a humble and compassionate person. He is deeply committed to using his power for the greater good and will not hesitate to put himself in harm's way to protect others. He is also a strong leader, respected by those who serve under him.",
            'character_id' => 1
        ]);
        DB::table('character_properties')->insert([
            'name' => 'description',
            'description' => 
            "Special Abilities:

            Control over the elements (fire, water, air, earth)
            Ability to cast powerful spells and incantations
            Mastery of ancient magic and knowledge of forbidden spells
            Exceptional ability to read and interpret magical texts
            Strong resistance to mind control and manipulation
            Possession of a magical staff that amplifies his power and allows him to focus his magic.

            Weaknesses:
            
            Physical vulnerability, as he relies heavily on his magic to protect himself
            Constant need to study and maintain his magical abilities
            Limited use of magic due to the energy it consumes
            Vulnerable to some ancient magic and cursed objects
            Possibility of succumbing to the temptation of using forbidden spells.
            
            Alignment: Lawful Good
            Goals: To protect the kingdom and its people, to seek out and defeat any who threaten the kingdom, to uncover forbidden knowledge and use it for the greater good.
            
            Companions: None

            Enemies: Anyone who threatens the kingdom and its people, powerful wizards who seeks forbidden knowledge and use it for their own gain.",
            'character_id' => 1
        ]);

        DB::table('character_properties')->insert([
            'name' => 'species',
            'description' => 'Human',
            'character_id' => 2
        ]);
        DB::table('character_properties')->insert([
            'name' => 'characteristics',
            'description' => 'Aric is a tall and imposing figure, with long dark hair and piercing blue eyes. He wears a black hooded cloak and carries a staff adorned with intricate runes.',
            'character_id' => 2
        ]);
        DB::table('character_properties')->insert([
            'name' => 'ideology',
            'description' => 'Aric is a powerful and confident sorcerer, but also carries a great sense of responsibility for his abilities. He is a wise and strategic thinker, but can also be stubborn and unwilling to back down from a challenge.',
            'character_id' => 2
        ]);
        DB::table('character_properties')->insert([
            'name' => 'past',
            'description' => 'Aric is a powerful sorcerer who has dedicated his life to protecting his kingdom from the forces of darkness. He has studied ancient magic for many years and possesses knowledge of powerful spells and incantations. He has faced many dangers in his quest to protect his people and has become a respected and feared figure among his peers.',
            'character_id' => 2
        ]);
        DB::table('character_properties')->insert([
            'name' => 'description',
            'description' => 
            "Aric is a powerful sorcerer with the ability to control the elements. He can summon bolts of lightning, summon powerful winds, and control the earth to create earthquakes. He also has the ability to levitate and fly, as well as the ability to teleport short distances.

            Weaknesses: Aric's power comes at a cost, as he is constantly at risk of being consumed by his own magic. He also has a weakness for ancient artifacts and may become reckless in his pursuit of them.
            
            Equipment: Aric carries a staff adorned with intricate runes, which he uses to channel his magic. He also carries a small pouch of spell components and a small spellbook.
            
            Goals: Aric's ultimate goal is to protect his kingdom from the forces of darkness and to keep his people safe. He is also constantly seeking to improve his knowledge and power as a sorcerer.",
            'character_id' => 2
        ]);

        DB::table('character_properties')->insert([
            'name' => 'species',
            'description' => 'Elf',
            'character_id' => 3
        ]);
        DB::table('character_properties')->insert([
            'name' => 'class',
            'description' => 'Sorcerer',
            'character_id' => 3
        ]);
        DB::table('character_properties')->insert([
            'name' => 'characteristics',
            'description' => 
            "Standing at 5'8, Sorin has a lean build with pointed ears and long silver hair that falls past his shoulders. He has piercing green eyes and a sharp jawline. He wears a black hooded cloak and carries a staff adorned with runes.",
            'character_id' => 3
        ]);
        DB::table('character_properties')->insert([
            'name' => 'past',
            'description' => 'Sorin was born into a long line of powerful sorcerers and was trained in the ways of magic from a young age. He spent many years studying ancient texts and perfecting his craft. He is a member of a secret order of sorcerers who work to protect the kingdom from dark forces.',
            'character_id' => 3
        ]);
        DB::table('character_properties')->insert([
            'name' => 'ideology',
            'description' => 'Sorin is a stoic and serious individual, but also deeply compassionate and driven by a strong sense of justice. He can be stubborn at times and is fiercely independent. He is fiercely loyal to his friends and will go to great lengths to protect them.',
            'character_id' => 3
        ]);
        DB::table('character_properties')->insert([
            'name' => 'description',
            'description' => 
            "Skills:

            Mastery of elemental magic
            Skilled in divination and illusion magic
            Proficient in swordplay and hand-to-hand combat
            Knowledge of ancient languages and texts
            Weaknesses:
            
            Can be reckless when protecting his loved ones
            Struggles with self-doubt and guilt over past mistakes
            His power can be taxing on his body and mind
            Equipment:
            
            Staff of elemental magic
            A set of enchanted bracers
            A ring of teleportation
            A potion of healing
            A spellbook containing ancient spells.
            Goal: To protect the kingdom and defeat a powerful sorcerer who threatens the land with an ancient dark magic.",
            'character_id' => 3
        ]);

        DB::table('character_properties')->insert([
            'name' => 'species',
            'description' => 'Elf',
            'character_id' => 4
        ]);
        DB::table('character_properties')->insert([
            'name' => 'class',
            'description' => 'Sorceress',
            'character_id' => 4
        ]);
        DB::table('character_properties')->insert([
            'name' => 'characteristics',
            'description' => 'Elara is a tall and slender elf with long silver hair and piercing blue eyes. She is often seen wearing flowing robes adorned with mystical symbols and carries a staff made of ancient wood.',
            'character_id' => 4
        ]);
        DB::table('character_properties')->insert([
            'name' => 'past',
            'description' => 'Elara was born into a long line of powerful sorcerers and was trained in the ways of magic from a young age. She quickly surpassed her teachers and became one of the most powerful sorceresses in the land. She is fiercely independent and often chooses to work alone, but will join forces with others if it means protecting her kingdom from harm.',
            'character_id' => 4
        ]);
        DB::table('character_properties')->insert([
            'name' => 'description',
            'description' => 'Special Abilities:

            Mastery of elemental magic
            Ability to cast powerful spells and curses
            Skilled in divination and prophecy
            Immune to most forms of magic
            Weaknesses:
            
            Vulnerable to attacks from holy magic and enchanted weapons
            Can become overly confident in her abilities
            Struggles with the weight of her responsibilities and the consequences of her actions.
            Motivations:
            
            Protecting her kingdom and its people
            Seeking out powerful magical artifacts
            Proving herself as the most powerful sorcerer in the land
            Personality Traits:
            
            Proud
            Independent
            Strong-willed
            Confident
            Companions:
            
            A young apprentice, whom she is training in the ways of magic
            A talking raven familiar that helps her with divination and prophecy
            A group of like-minded sorcerers who share her goal of protecting their kingdom.
            Goal: To become the most powerful sorcerer in the land and to protect her kingdom from all threats.',
            'character_id' => 4
        ]);

        DB::table('character_properties')->insert([
            'name' => 'species',
            'description' => 'Elf',
            'character_id' => 5
        ]);
        DB::table('character_properties')->insert([
            'name' => 'class',
            'description' => 'Paladin',
            'character_id' => 5
        ]);
        DB::table('character_properties')->insert([
            'name' => 'characteristics',
            'description' => "Isabella stands at 5'6 with long, curly golden hair and piercing green eyes
            She wears a suit of silver plate armor adorned with intricate designs and holy symbols
            A longsword and shield, both bearing the symbol of her deity, are always by her side",
            'character_id' => 5
        ]);
        DB::table('character_properties')->insert([
            'name' => 'ideology',
            'description' => 'Isabella is a strong and determined individual, driven by her devotion to her deity and her duty to protect the innocent
            She is fiercely loyal to her allies and will go to great lengths to defend them
            She has a strong sense of justice and will not hesitate to punish those who break the law or harm the innocent
            Despite her fearsome reputation, she has a kind heart and often goes out of her way to help those in need',
            'character_id' => 5
        ]);
        DB::table('character_properties')->insert([
            'name' => 'past',
            'description' => 'Isabella grew up in a small village that was frequently raided by bandits. This led her to train as a paladin to protect her village and others from harm.
            She is a member of the Order of the Silver Hand, a holy order dedicated to her deity.
            She has participated in many successful battles and campaigns, earning her the respect and admiration of her comrades.',
            'character_id' => 5
        ]);
        DB::table('character_properties')->insert([
            'name' => 'description',
            'description' => 'Abilities:

            Proficient in swordplay and skilled in the use of her shield
            Can channel divine magic to heal herself and her allies
            Has the ability to detect evil and can turn undead
            Has resistance to necrotic damage
            Can cast protective spells such as sanctuary and shield of faith.

            Equipment:
            
            Silver Plate armor
            Longsword and shield
            Holy Symbol of her deity
            A potion of healing and scroll of remove curse.

            Goal:
            
            Protect her kingdom and people from any threats, internal or external.
            Bring justice to those who have committed crimes.
            Seek redemption for any past misdeeds.
            Prove herself as a worthy member of the Order of the Silver Hand.',
            'character_id' => 5
        ]);

        DB::table('character_properties')->insert([
            'name' => 'species',
            'description' => 'Elf',
            'character_id' => 6
        ]);
        DB::table('character_properties')->insert([
            'name' => 'class',
            'description' => 'Ranger',
            'character_id' => 6
        ]);
        DB::table('character_properties')->insert([
            'name' => 'characteristics',
            'description' => 'Kethril is tall and lean with pointed ears and long, silver hair. He has sharp features and piercing green eyes. He wears a suit of leather armor, adorned with intricate designs and adorned with various pouches and quivers filled with arrows. He carries a longbow and a pair of short swords at his hips.',
            'character_id' => 6
        ]);
        DB::table('character_properties')->insert([
            'name' => 'past',
            'description' => 'Kethril was raised in the deep forests of the realm and was trained by his father, a skilled ranger, from a young age. He learned to track and hunt game, as well as how to defend himself against wild beasts and bandits. He has always had a deep connection to nature and can communicate with animals. He left his home to explore the world and hone his skills, and became a respected member of the rangers guild.',
            'character_id' => 6
        ]);
        DB::table('character_properties')->insert([
            'name' => 'ideology',
            'description' => 'Kethril is a solitary person who prefers the company of nature to that of people. He is stoic, and speaks little, but is fiercely loyal to his friends and will go to great lengths to protect them. He is fiercely independent, and follows his own code of honor and duty. He is also a skilled strategist, and will often use his knowledge of the terrain and his tracking abilities to outsmart his enemies.',
            'character_id' => 6
        ]);
        DB::table('character_properties')->insert([
            'name' => 'description',
            'description' => 'Special Abilities:

            Expertise in archery and swordsmanship
            Skilled tracker and survivalist
            Can communicate with animals
            Can move stealthily and remain unseen in natural environments
            Has a deep understanding of nature magic
            Weaknesses:
            
            Has a hard time trusting others
            Can become reckless when protecting those he cares about
            Can become too focused on a goal, ignoring potential dangers
            Susceptible to charm and illusion magic.',
            'character_id' => 6
        ]);
    }
}
