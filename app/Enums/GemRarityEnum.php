<?php

namespace App\Enums;

enum GemRarityEnum: string {
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

    public function offensive(): int
    {
        return self::getOffensive($this);
    }

    public static function getOffensive(self $value): int
    {
        return match ($value) {
            self::FLAWED => 2,
            self::SPLINTERED => 6,
            self::SIMPLE => 10,
            self::GEM => 20,
            self::POLISHED => 50,
            self::RADIANT => 150,
            self::FLAWLESS => 450,
            self::SACRED => 1000,
            self::ROYAL => 2000,
            self::TRAPEZOID => 3500,
            self::REFINED_TRAPEZOID => 5500,
            self::BRILLIANT_TRAPEZOID => 8000,
            self::EXQUISITE_TRAPEZOID => 11000,
            self::IMPERIAL => 14500,
            self::REFINED_IMPERIAL => 18500,
            self::BRILLIANT_IMPERIAL => 23000,
            self::EXQUISITE_IMPERIAL => 28000,
        };
    }

    public function defensive(): int
    {
        return self::getDefensive($this);
    }

    public static function getDefensive(self $value): int
    {
        return match ($value) {
            self::FLAWED => 2,
            self::SPLINTERED => 4,
            self::SIMPLE => 8,
            self::GEM => 16,
            self::POLISHED => 40,
            self::RADIANT => 120,
            self::FLAWLESS => 360,
            self::SACRED => 800,
            self::ROYAL => 1600,
            self::TRAPEZOID => 2800,
            self::REFINED_TRAPEZOID => 4400,
            self::BRILLIANT_TRAPEZOID => 6400,
            self::EXQUISITE_TRAPEZOID => 8800,
            self::IMPERIAL => 11600,
            self::REFINED_IMPERIAL => 14800,
            self::BRILLIANT_IMPERIAL => 18400,
            self::EXQUISITE_IMPERIAL => 22400,
        };
    }
}
