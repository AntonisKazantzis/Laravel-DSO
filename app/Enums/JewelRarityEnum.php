<?php

namespace App\Enums;

enum JewelRarityEnum: string
{
    case COMMON = 'common';
    case IMPROVED = 'improved';
    case MAGIC = 'magic';
    case EXTRAORDINARY = 'extraordinary';
    case LEGENDARY = 'legendary';
    case MYTHIC = 'mythic';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toArrayUcwords(): array
    {
        $cases = self::cases();
        $arr1 = array_column($cases, 'value');

        $arr2 = array_map(function ($rarity) {
            return ucwords($rarity);
        }, $arr1);

        $result = array_combine($arr1, $arr2);

        array_pop($arr2);

        return $arr2;
    }

    public static function toArrayFormatted(): array
    {
        $cases = self::cases();
        $arr1 = array_column($cases, 'value');

        $arr2 = array_map(function ($rarity) {
            return ucwords(str_replace('_', ' ', $rarity));
        }, $arr1);

        $result = array_combine($arr1, $arr2);

        array_pop($result);

        return $result;
    }

    public static function getDust($value): array
    {
        return match ($value) {
            'jewel_of_glacial_fang' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_ander_power' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_ignition' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_scorching_ray' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_strenuousness' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_eternal_wrath' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_easter_fever' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_swiftness' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_the_vanquisher' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_poisonous_thorns' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_ghost_power' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_amplified_healing' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_frozen_heart' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_revival_boon' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_prolongation' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_pent_up_power' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_converse' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_dextrous_vigor' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_ambidextrous_vigor' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_contribution' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_encouragement' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_vigor' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_vitality' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_gem_fortune' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_fortitude' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_lasting_health' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_rage' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_ingredient_hunter' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_focus' => [3000, 8250, 16500, 27750, 0],
            'jewel_of_relentlessness' => [3000, 8250, 16500, 27750, 0],
            'thundering_flower_jewel' => [3000, 8250, 16500, 27750, 0],
            'fiery_flower_jewel' => [3000, 8250, 16500, 27750, 0],
        };
    }

    public static function getJewels(): array
    {
        return [
            'jewel_of_glacial_fang' => 'Jewel of Glacial Fang',
            'jewel_of_ander_power' => 'Jewel of Ander Power',
            'jewel_of_ignition' => 'Jewel of Ignition',
            'jewel_of_scorching_ray' => 'Jewel of Scorching Ray',
            'jewel_of_strenuousness' => 'Jewel of Strenuousness',
            'jewel_of_eternal_wrath' => 'Jewel of Eternal Wrath',
            'jewel_of_easter_fever' => 'Jewel of Easter Fever',
            'jewel_of_swiftness' => 'Jewel of Swiftness',
            'jewel_of_the_vanquisher' => 'Jewel of the Vanquisher',
            'jewel_of_poisonous_thorns' => 'Jewel of Poisonous Thorns',
            'jewel_of_ghost_power' => 'Jewel of Ghost Power',
            'jewel_of_amplified_healing' => 'Jewel of Amplified Healing',
            'jewel_of_frozen_heart' => 'Jewel of Frozen Heart',
            'jewel_of_revival_boon' => 'Jewel of Revival Boon',
            'jewel_of_prolongation' => 'Jewel of Prolongation',
            'jewel_of_pent_up_power' => 'Jewel of Pent up Power',
            'jewel_of_converse' => 'Jewel of Converse',
            'jewel_of_dextrous_vigor' => 'Jewel of Dextrous Vigor',
            'jewel_of_ambidextrous_vigor' => 'Jewel of Ambidextrous Vigor',
            'jewel_of_contribution' => 'Jewel of Contribution',
            'jewel_of_encouragement' => 'Jewel of Encouragement',
            'jewel_of_vigor' => 'Jewel of Vigor',
            'jewel_of_vitality' => 'Jewel of Vitality',
            'jewel_of_gem_fortune' => 'Jewel of Gem Fortune',
            'jewel_of_fortitude' => 'Jewel of Fortitude',
            'jewel_of_lasting_health' => 'Jewel of Lasting Health',
            'jewel_of_rage' => 'Jewel of Rage',
            'jewel_of_ingredient_hunter' => 'Jewel of Ingredient Hunter',
            'jewel_of_focus' => 'Jewel of Focus',
            'jewel_of_relentlessness' => 'Jewel of Relentlessness',
            'thundering_flower_jewel' => 'Thundering Flower Jewel',
            'fiery_flower_jewel' => 'Fiery Flower Jewel',
        ];
    }
}
