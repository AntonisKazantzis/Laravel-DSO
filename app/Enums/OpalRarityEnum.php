<?php

namespace App\Enums;

enum OpalRarityEnum: string
{
    case ROYAL = 'royal';
    case TRAPEZOID = 'trapezoid';
    case REFINED_TRAPEZOID = 'refined_trapezoid';
    case BRILLIANT_TRAPEZOID = 'brilliant_trapezoid';
    case EXQUISITE_TRAPEZOID = 'exquisite_trapezoid';
    case IMPERIAL = 'imperial';
    case REFINED_IMPERIAL = 'refined_imperial';
    case BRILLIANT_IMPERIAL = 'brilliant_imperial';
    case EXQUISITE_IMPERIAL = 'exquisite_imperial';

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

    public static function getDust(): array
    {
        return [
            'royal' => 4500,
            'trapezoid' => 7875,
            'refined_trapezoid' => 12375,
            'brilliant_trapezoid' => 18000,
            'exquisite_trapezoid' => 24750,
            'imperial' => 32625,
            'refined_imperial' => 41625,
            'brilliant_imperial' => 51750,
            'exquisite_imperial' => 63000,
        ];
    }
}
