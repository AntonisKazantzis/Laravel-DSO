<?php

namespace App\Models;

use App\Enums\GemRarityEnum;
use App\Enums\GemTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => GemTypeEnum::class,
        'rarity' => GemRarityEnum::class,
        'value' => 'float',
        'dust' => 'integer',
        'andermant' => 'integer',
        'selling_cost' => 'array',
        'upgrading_cost' => 'array',
        'melting_cost' => 'array',
    ];

    public function scopeByGemType(Builder $query, ?string $gemType): Builder
    {
        $gemTypeMapping = [
            'ruby' => GemTypeEnum::RUBY,
            'onyx' => GemTypeEnum::ONYX,
            'zircon' => GemTypeEnum::ZIRCON,
            'rhodolite' => GemTypeEnum::RHODOLITE,
            'diamond' => GemTypeEnum::DIAMOND,
            'diamond_fire' => GemTypeEnum::DIAMOND_FIRE,
            'diamond_ice' => GemTypeEnum::DIAMOND_ICE,
            'diamond_andermagic' => GemTypeEnum::DIAMOND_ANDERMAGIC,
            'diamond_lightning' => GemTypeEnum::DIAMOND_LIGHTNING,
            'diamond_poison' => GemTypeEnum::DIAMOND_POISON,
            'amethyst' => GemTypeEnum::AMETHYST,
            'cyanite' => GemTypeEnum::CYANITE,
            'emerald' => GemTypeEnum::EMERALD,
        ];

        return $query->when(isset($gemTypeMapping[$gemType]), function (Builder $query) use ($gemTypeMapping, $gemType) {
            return $query->where('type', $gemTypeMapping[$gemType]);
        });
    }

    public function scopeByGemRarity(Builder $query, ?string $gemRarity): Builder
    {
        $gemRarityMapping = [
            'flawed' => GemRarityEnum::FLAWED,
            'splintered' => GemRarityEnum::SPLINTERED,
            'simple' => GemRarityEnum::SIMPLE,
            'gem' => GemRarityEnum::GEM,
            'polished' => GemRarityEnum::POLISHED,
            'radiant' => GemRarityEnum::RADIANT,
            'flawless' => GemRarityEnum::FLAWLESS,
            'sacred' => GemRarityEnum::SACRED,
            'royal' => GemRarityEnum::ROYAL,
            'trapezoid' => GemRarityEnum::TRAPEZOID,
            'refined_trapezoid' => GemRarityEnum::REFINED_TRAPEZOID,
            'brilliant_trapezoid' => GemRarityEnum::BRILLIANT_TRAPEZOID,
            'exquisite_trapezoid' => GemRarityEnum::EXQUISITE_TRAPEZOID,
            'imperial' => GemRarityEnum::IMPERIAL,
            'refined_imperial' => GemRarityEnum::REFINED_IMPERIAL,
            'brilliant_imperial' => GemRarityEnum::BRILLIANT_IMPERIAL,
            'exquisite_imperial' => GemRarityEnum::EXQUISITE_IMPERIAL,
        ];

        return $query->when(isset($gemRarityMapping[$gemRarity]), function (Builder $query) use ($gemRarityMapping, $gemRarity) {
            return $query->where('rarity', $gemRarityMapping[$gemRarity]);
        });
    }
}
