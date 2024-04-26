<?php

namespace App\Enums;

enum RuneRarityEnum: string
{
    case COMMON = 'common';
    case IMPROVED = 'improved';
    case MAGIC = 'magic';
    case EXTRAORDINARY = 'extraordinary';
    case LEGENDARY = 'legendary';
    case UNIQUE = 'unique';

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
            'rune_of_recharging' => [3126, 8596, 17188, 28908, 0],
            'rune_of_regeneration' => [3126, 8596, 17188, 28908, 0],
            'rune_of_efficacy' => [3126, 8596, 17188, 28908, 0],
            'rune_of_vitality' => [3126, 8596, 17188, 28908, 0],
            'rune_of_persistence' => [3126, 8596, 17188, 28908, 0],
            'rune_of_acceleration' => [3126, 8596, 17188, 28908, 0],
            'rune_of_celerity' => [3126, 8596, 17188, 28908, 0],
            'rune_of_devastation' => [3126, 8596, 17188, 28908, 0],
            'rune_of_the_andermant_fever' => [3126, 8596, 17188, 28908, 0],
            'rune_of_the_gold_fever' => [3126, 8596, 17188, 28908, 0],
            'rune_of_the_realm_charger' => [3126, 8596, 17188, 28908, 0],
            'rune_of_the_anxiety_keeper' => [3126, 8596, 17188, 28908, 0],
            'rune_of_the_scholar' => [3126, 8596, 17188, 28908, 0],
            'rune_of_experience_hunter' => [3126, 8596, 17188, 28908, 0],
            'rune_of_wisdom_seeker' => [3126, 8596, 17188, 28908, 0],
            'rune_of_materi_blessing' => [3126, 8596, 17188, 28908, 0],
            'rune_of_fortitude' => [3126, 8596, 17188, 28908, 0],
            'rune_of_resilience' => [3126, 8596, 17188, 28908, 0],
            'rune_of_andermagic_resilience' => [3126, 8596, 17188, 28908, 0],
            'rune_of_lightning_resilience' => [3126, 8596, 17188, 28908, 0],
            'rune_of_fire_resilience' => [3126, 8596, 17188, 28908, 0],
            'rune_of_poison_resilience' => [3126, 8596, 17188, 28908, 0],
            'rune_of_ice_resilience' => [3126, 8596, 17188, 28908, 0],
            'rune_of_vigor' => [3126, 8596, 17188, 28908, 0],
            'concentrated_solstice_rune' => [3126, 8596, 17188, 28908, 0],
            'concentrated_spring_rune' => [3126, 8596, 17188, 28908, 0],
        };
    }

    public static function getRunes(): array
    {
        return [
            'rune_of_recharging' => 'Rune of Recharging',
            'rune_of_regeneration' => 'Rune of Regeneration',
            'rune_of_efficacy' => 'Rune of Efficacy',
            'rune_of_vitality' => 'Rune of Vitality',
            'rune_of_persistence' => 'Rune of Persistence',
            'rune_of_acceleration' => 'Rune of Acceleration',
            'rune_of_celerity' => 'Rune of Celerity',
            'rune_of_devastation' => 'Rune of Devastation',
            'rune_of_the_andermant_fever' => 'Rune of the Andermant Fever',
            'rune_of_the_gold_fever' => 'Rune of the Gold Fever',
            'rune_of_the_realm_charger' => 'Rune of the Realm Charger',
            'rune_of_the_anxiety_keeper' => 'Rune of the Anxiety Keeper',
            'rune_of_the_scholar' => 'Rune of the Scholar',
            'rune_of_experience_hunter' => 'Rune of Experience Hunter',
            'rune_of_wisdom_seeker' => 'Rune of Wisdom Seeker',
            'rune_of_materi_blessing' => 'Rune of Materi Blessing',
            'rune_of_fortitude' => 'Rune of Fortitude',
            'rune_of_resilience' => 'Rune of Resilience',
            'rune_of_andermagic_resilience' => 'Rune of Andermagic Resilience',
            'rune_of_lightning_resilience' => 'Rune of Lightning Resilience',
            'rune_of_fire_resilience' => 'Rune of Fire Resilience',
            'rune_of_poison_resilience' => 'Rune of Poison Resilience',
            'rune_of_ice_resilience' => 'Rune of Ice Resilience',
            'rune_of_vigor' => 'Rune of Vigor',
            'concentrated_solstice_rune' => 'Concentrated Solstice Rune',
            'concentrated_spring_rune' => 'Concentrated Spring Rune',
        ];
    }
}
