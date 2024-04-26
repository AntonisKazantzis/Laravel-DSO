<?php

namespace App\Enums;

enum ItemRarityEnum: string
{
    case COMMON = 'common';
    case IMPROVED = 'improved';
    case MAGIC = 'magic';
    case EXTRAORDINARY = 'extraordinary';
    case LEGENDARY = 'legendary';
    case UNIQUE = 'unique';
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
            return ucwords(str_replace('_', ' ', $rarity));
        }, $arr1);

        $result = array_combine($arr1, $arr2);

        return $result;
    }
}
