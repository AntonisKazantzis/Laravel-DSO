<?php

namespace Database\Seeders;

use App\Models\Rune;
use App\Enums\RuneRarityEnum;
use Illuminate\Database\Seeder;

class RuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $runes = [
            'rune_of_recharging' => 'Regenerates 6.50% Resource Points per second',
            'rune_of_regeneration' => 'Regenerates 6.50% of your Health Points per second',
            'rune_of_efficacy' => '+ 6.50% Resource Points',
            'rune_of_vitality' => '+ 6.50% Health Points',
            'rune_of_persistence' => '+ 6.50% block value',
            'rune_of_acceleration' => '+ 6.50% movement speed',
            'rune_of_celerity' => '+ 6.50% attack speed',
            'rune_of_devastation' => '+ 6.50% critical value',
            'rune_of_the_andermant_fever' => 'Increases the Andermant Fever talent by 5',
            'rune_of_the_gold_fever' => 'Increases the Gold Fever talent by 5',
            'rune_of_the_realm_charger' => 'Increases the Realm Charger talent by 5',
            'rune_of_the_anxiety_keeper' => 'Increases the Anxiety Keeper talent by 5',
            'rune_of_the_scholar' => 'Increases the Scholar talent by 5',
            'rune_of_experience_hunter' => 'Increases the Experience Hunter talent by 5',
            'rune_of_wisdom_seeker' => '+ 30% to Ancient Wisdom drop stack size',
            'rune_of_materi_blessing' => '+ 30% to Materi Fragments drop stack size',
            'rune_of_fortitude' => '+ 6.50% Armor value',
            'rune_of_resilience' => '+ 6.50% all resistance values',
            'rune_of_andermagic_resilience' => '+ 6.50% Andermagic resistance',
            'rune_of_lightning_resilience' => '+ 6.50% Lightning resistance',
            'rune_of_fire_resilience' => '+ 6.50% Fire resistance',
            'rune_of_poison_resilience' => '+ 6.50% Poison resistance',
            'rune_of_ice_resilience' => '+ 6.50% Ice resistance',
            'rune_of_vigor' => '+ 6.50% damage',
            'rune_of_rising_vigor' => "+ 10.00% movement speed + 6.00% attack speed Each successful critical hit has a chance of 8% to trigger the Ghost Smoke Effect, making you immune to enemies' skills and invisible to monsters for 3 seconds. Cooldown: 15 seconds",
            'rune_of_rising_power' => '+ 15.00% Armor value + 5.00% Fire resistance + 5.00% Poison resistance + 5.00% Ice resistance + 5.00% Lightning resistance Each successful critical hit has a chance of 5% to petrify the enemy for 2 seconds',
            'concentrated_solstice_rune' => '+ 6.50% Ice resistance + 6.50% Health Points + 6.50% critical value',
            'concentrated_spring_rune' => '+ 6.50% Health Points + 6.50% critical value + 6.50% attack speed',
        ];

        foreach ($runes as $rune => $effect) {
            $rarity = $rune === 'rune_of_rising_power' || $rune === 'rune_of_rising_vigor' ? RuneRarityEnum::UNIQUE : RuneRarityEnum::LEGENDARY;

            $runeName = ucwords(str_replace('_', ' ', $rune));

            Rune::factory()->create([
                'image_path' => "images/runes/$rune.png",
                'name' => $runeName,
                'rarity' => $rarity,
                'effect' => $effect,
            ]);
        }
    }
}
