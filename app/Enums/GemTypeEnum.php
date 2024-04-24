<?php

namespace App\Enums;

enum GemTypeEnum: string
{
    case RUBY = 'ruby';
    case ONYX = 'onyx';
    case ZIRCON = 'zircon';
    case RHODOLITE = 'rhodolite';
    case DIAMOND = 'diamond';
    case DIAMOND_FIRE = 'diamond_fire';
    case DIAMOND_ICE = 'diamond_ice';
    case DIAMOND_ANDERMAGIC = 'diamond_andermagic';
    case DIAMOND_LIGHTNING = 'diamond_lightning';
    case DIAMOND_POISON = 'diamond_poison';
    case AMETHYST = 'amethyst';
    case CYANITE = 'cyanite';
    case EMERALD = 'emerald';

    public function description(): string
    {
        return self::getDescription($this);
    }

    public static function getDescription(self $value): string
    {
        return match ($value) {
            self::RUBY => 'damage',
            self::ONYX => 'critical value',
            self::ZIRCON => 'attacks per second',
            self::RHODOLITE => 'movement speed',
            self::DIAMOND => 'all resistance values',
            self::DIAMOND_FIRE => 'fire resistance',
            self::DIAMOND_ICE => 'ice resistance',
            self::DIAMOND_ANDERMAGIC => 'andermagic resistance',
            self::DIAMOND_LIGHTNING => 'lightning resistance',
            self::DIAMOND_POISON => 'poison resistance',
            self::AMETHYST => 'health points',
            self::CYANITE => 'armor value',
            self::EMERALD => 'block value',
        };
    }

    public function effect(): array
    {
        return self::getEffect($this);
    }

    public static function getEffect(self $value): array
    {
        return match ($value) {
            self::RUBY => [2, 3, 6, 10, 15, 24, 36, 54, 80, 113, 145, 200, 300, 400, 500, 600, 700],
            self::ONYX => [15, 30, 60, 100, 150, 225, 345, 480, 600, 750, 900, 1170, 1440, 1710, 1980, 2250, 2520],
            self::ZIRCON => [0.001, 0.002, 0.003, 0.004, 0.005, 0.006, 0.007, 0.008, 0.009, 0.010, 0.011, 0.012, 0.013, 0.014, 0.015, 0.016, 0.017],
            self::RHODOLITE => [0.01, 0.02, 0.03, 0.04, 0.05, 0.06, 0.07, 0.08, 0.09, 0.10, 0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17],
            self::DIAMOND => [6, 12, 24, 40, 60, 90, 135, 200, 250, 330, 390, 510, 630, 750, 870, 990, 1110],
            self::DIAMOND_FIRE => [24, 48, 96, 160, 240, 360, 540, 800, 1000, 1320, 1560, 2040, 2520, 3000, 3480, 3960, 4440],
            self::DIAMOND_ICE => [24, 48, 96, 160, 240, 360, 540, 800, 1000, 1320, 1560, 2040, 2520, 3000, 3480, 3960, 4440],
            self::DIAMOND_ANDERMAGIC => [24, 48, 96, 160, 240, 360, 540, 800, 1000, 1320, 1560, 2040, 2520, 3000, 3480, 3960, 4440],
            self::DIAMOND_LIGHTNING => [24, 48, 96, 160, 240, 360, 540, 800, 1000, 1320, 1560, 2040, 2520, 3000, 3480, 3960, 4440],
            self::DIAMOND_POISON => [24, 48, 96, 160, 240, 360, 540, 800, 1000, 1320, 1560, 2040, 2520, 3000, 3480, 3960, 4440],
            self::AMETHYST => [10, 20, 45, 105, 170, 305, 480, 700, 1000, 1280, 1900, 2500, 3100, 3700, 4300, 4900, 5500],
            self::CYANITE => [6, 12, 24, 40, 60, 90, 135, 200, 250, 330, 390, 510, 630, 750, 870, 990, 1110],
            self::EMERALD => [15, 30, 60, 100, 150, 225, 345, 480, 600, 750, 900, 1170, 1440, 1710, 1980, 2250, 2520],
        };
    }
}
