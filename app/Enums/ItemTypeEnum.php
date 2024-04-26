<?php

namespace App\Enums;

enum ItemTypeEnum: string
{
    case AMULET = 'amulet';
    case CAPE = 'cape';
    case BELT = 'belt';
    case RING = 'ring';
    case ADORNMENT = 'adornment';
    case MAIN_HAND = 'main_hand';
    case OFF_HAND = 'off_hand';
    case DOUBLE_HANDED = 'double_handed';
    case HELMET = 'helmet';
    case SHOULDERS = 'shoulders';
    case TORSO = 'torso';
    case GLOVES = 'gloves';
    case BOOTS = 'boots';

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
