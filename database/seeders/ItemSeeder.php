<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setItems = [
            'mighty_helmet_of_the_wrathful_seeker',
            'mighty_shoulders_of_the_wrathful_seeker',
            'mighty_torso_of_the_wrathful_seeker',
            'mighty_gloves_of_the_wrathful_seeker',
            'mighty_boots_of_the_wrathful_seeker',
            'mighty_cape_of_the_wrathful_seeker',
            'flame_conqueror_armor',
            'flame_conqueror_gloves',
            'flame_conqueror_boots',
            'flame_conqueror_shoulders',
            'flame_conqueror_helmet',
            'shadow_reign_armor',
            'helmet_of_darkness',
            'pauldrons_of_darkness',
            'heart_of_darkness',
            'grip_of_darkness',
            'trace_of_darkness',
            'glowing_sapphire_pauldrons',
            'glowing_sapphire_chestplate',
            'spring_bells',
            'mechanical_enhancement',
            'mechanical_shield',
            'mechanical_sword',
            'mechanical_mace',
            'mechanical_axe',
            'mechanical_ring',
            'mechanical_belt',
            'mechanical_seal',
            'bearachs_torturer',
            'large_machine_axe',
            'large_machine_hammer',
            'large_machine_blade',
            'poison_buster_long_axe',
            'bearer_of_corruption',
            'dark_exile_greatsword',
        ];

        $uniqueItems = [
            'ring_of_icy_barries',
            'ring_of_crimson_dread',
            'ring_of_cerulean_hope',
            'presence_of_dominance',
            'presence_of_iron_will',
            'presence_of_desperation',
            'presence_of_brutality',
        ];

        $mythicItems = [
            'ring_of_old_glory',
            'old_glory',
            'ring_of_life',
            'ring_of_death',
            'cape_of_the_black_knight',
            'helmet_of_the_black_knight',
            'shoulders_of_the_black_knight',
            'frightful_glimpse',
            'cryptic_berserker',
        ];
    }
}
