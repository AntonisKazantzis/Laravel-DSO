<?php

namespace App\Enums;

enum CharacterClassEnum: string
{
    case DRAGONKNIGHT = 'dragonknight';
    case RANGER = 'ranger';
    case SPELLWEAVER = 'spellweaver';
    case STEAM_MECHANICUS = 'steam_mechanicus';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toArrayUcwords(): array
    {
        $cases = self::cases();
        $arr1 = array_column($cases, 'value');

        $arr2 = array_map(function ($rarity) {
            return ucwords(str_replace('_', ' ', $rarity));
        }, $arr1);

        $result = array_combine($arr1, $arr2);

        return $result;
    }
}
