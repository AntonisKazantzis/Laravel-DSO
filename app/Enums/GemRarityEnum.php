<?php

namespace App\Enums;

enum GemRarityEnum: string
{
    case FLAWED = 'flawed';
    case SPLINTERED = 'splintered';
    case SIMPLE = 'simple';
    case GEM = 'gem';
    case POLISHED = 'polished';
    case RADIANT = 'radiant';
    case FLAWLESS = 'flawless';
    case SACRED = 'sacred';
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

    // public static function toArrayUcwords(): array
    // {
    //     $cases = self::cases();
    //     $arr1 = array_column($cases, 'value');

    //     $arr2 = array_map(function ($rarity) {
    //         return ucwords(str_replace('_', ' ', $rarity));
    //     }, $arr1);

    //     $result = array_combine($arr1, $arr2);

    //     return $arr2;
    // }

    public static function toArrayUcwords($value): array
    {
        $cases = self::cases();
        $arr1 = array_column($cases, 'value');

        $gemIndex = array_search('gem', $arr1);
        if ($gemIndex !== false) {
            $arr1[$gemIndex] = $value;
        }

        $arr2 = array_map(function ($rarity) {
            return ucwords(str_replace('_', ' ', $rarity));
        }, $arr1);

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

        return $result;
    }

    public function dust(): int
    {
        return self::getDust($this);
    }

    public static function getDust(self $value): array
    {
        return match ($value) {
            self::FLAWED => [2, 2],
            self::SPLINTERED => [4, 6],
            self::SIMPLE => [8, 10],
            self::GEM => [16, 20],
            self::POLISHED => [40, 50],
            self::RADIANT => [120, 150],
            self::FLAWLESS => [360, 450],
            self::SACRED => [800, 1000],
            self::ROYAL => [1600, 2000],
            self::TRAPEZOID => [2800, 3500],
            self::REFINED_TRAPEZOID => [4400, 5500],
            self::BRILLIANT_TRAPEZOID => [6400, 8000],
            self::EXQUISITE_TRAPEZOID => [8800, 11000],
            self::IMPERIAL => [11600, 14500],
            self::REFINED_IMPERIAL => [14800, 18500],
            self::BRILLIANT_IMPERIAL => [18400, 23000],
            self::EXQUISITE_IMPERIAL => [22400, 28000],
        };
    }
}
