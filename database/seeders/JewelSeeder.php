<?php

namespace Database\Seeders;

use App\Enums\JewelRarityEnum;
use App\Models\Jewel;
use Illuminate\Database\Seeder;

class JewelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jewels = [
            'jewel_of_glacial_fang' => 'Each critical hit has a 5% chance of summoning a Fenris Wolf to fight alongside you for 10 seconds, but your resistances will be reduced by 7%.',
            'jewel_of_ander_power' => '+ 8% increased andermant drop stack size.',
            'jewel_of_ignition' => 'When your health drops below 30%, there is a 5% chance that your skills will deal additional fire damage to all enemies for 10 seconds.',
            'jewel_of_scorching_ray' => "When you block an enemy's skill, you have a 10% chance to be healed for 40% of your maximum health",
            'jewel_of_strenuousness' => '+ 3 increased keys of prowess drop stack size.',
            'jewel_of_eternal_scorn' => '+ 15.00% critical value. Each successful hit with Smash/Ice missile skill/Scatter shot/Flamethrower has a chance of 5% to spawn an Ice Meteor on your location, dealing 150% of your damage as Ice damage for 5 seconds to enemies in 5 meter radius.',
            'jewel_of_eternal_wrath' => '+ 200% higher drop stack size of Fragments of Infernal Passage.',
            'jewel_of_easter_fever' => '+ 5 drop stack size of Gilded Clovers.',
            'jewel_of_swiftness' => 'Jump/Dash skills will cost 60% less Resource Points if your Health drop below 33%.',
            'jewel_of_the_vanquisher' => 'Enhances the Frenzy of the Vanquisher effect: + 0.05% additional critical value per stack.',
            'jewel_of_poisonous_thorns' => 'Every 3 seconds. You fire poisonous spikes at all surrounding enemies within a 5m radius, dealing 50% of base poison damage . Poison Spikes also deal 35% poison damage to you every time they hit an enemy.',
            'jewel_of_ghost_power' => "Increases the damage bonus of Ghost Power buff, granted by Gwenfara's main hand and off hand item, by 5%",
            'jewel_of_amplified_healing' => 'Picking up a healing sphere increases your damage by 150% and your movement speed by 25% for 5 seconds.',
            'jewel_of_frozen_heart' => 'When you are hit while being frozen, you will be healed by 50% of your maximum Health Points.',
            'jewel_of_revival_boon' => 'When you revive yourself at the place where you died your armor and damage will be increased by 40% for 10 seconds.',
            'jewel_of_prolongation' => 'The duration of the stun immunity effect is increased by 6 seconds.',
            'jewel_of_pent_up_power' => 'Blocking generates Pent-up Power that lasts for 10 seconds. If you stack up 100x Pent-up Power you will release an explosion that deals 3000% of your base damage as physical damage to all enemies around you.',
            'jewel_of_converse' => 'Whenever you get immobilized, your armor will be increased by 60% for 5 seconds.',
            'jewel_of_dextrous_vigor' => '+ 4.00% increased damage on one-handed weapons.',
            'jewel_of_ambidextrous_vigor' => '+ 10.00% increased damage on two-handed weapons.',
            'jewel_of_contribution' => 'When dealing damage to an enemy, there is a 20% chance to trigger the Valuable Contribution buff for 10 seconds. The buff increases your Health Points by 15% and regenerates 5% Resource Points per second of all group members (except you). The buff does not stack.',
            'jewel_of_encouragement' => 'When dealing damage to an enemy, there is a 20% chance to trigger the Increasing Encouragement buff for 10 seconds. The buff increases your Resource Points by 15% and regenerates 5% Health Points per second of all group members (except you). The buff does not stack.',
            'jewel_of_vigor' => '+ 10.00% damage.',
            'jewel_of_vitality' => '+ 10.00% Health Points.',
            'jewel_of_gem_fortune' => 'Bosses drop 5 additional gems.',
            'jewel_of_fortitude' => '+ 10.00% Armor value.',
            'jewel_of_lasting_health' => 'Defeating an enemy increases your health regeneration by 10% for 5 seconds.',
            'jewel_of_rage' => 'When dealing critical damage to an enemy, there is a 40% chance that your critical value increases by 30% and your attacks per second increase by 25% for 10 seconds.',
            'jewel_of_ingredient_hunter' => '+ 5 drop stack size of all basic, boss and boss event ingredients.',
            'jewel_of_focus' => 'Reduces cooldowns of all player skills by 7.50%.',
            'jewel_of_relentlessness' => 'Resource Points costs reduced to 5%.',
            'thundering_flower_jewel' => 'Each successful hit with Smash/True shot has a 10%/15% chance to cause 100%/25% of your base damage as lightningdamage to all enemies in a range of 5 meters around the hit enemy.',
            'fiery_flower_jewel' => 'Each successful hit with Fireball/Heavy Shot has a 15%/20% chance to cause 150%/30% of your base damage as firedamage to all enemies in a range of 5 meters around the hit enemy.',
        ];

        foreach ($jewels as $jewel => $effect) {
            $rarity = $jewel === 'jewel_of_eternal_scorn' ? JewelRarityEnum::MYTHIC : JewelRarityEnum::LEGENDARY;

            $jewelName = ucwords(str_replace('_', ' ', $jewel));

            Jewel::factory()->create([
                'image_path' => "images/jewels/$jewel.webp",
                'name' => $jewelName,
                'rarity' => $rarity,
                'effect' => $effect,
            ]);
        }
    }
}
