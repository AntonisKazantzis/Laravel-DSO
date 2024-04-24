<?php

namespace App\Models;

use App\Enums\JewelRarityEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jewel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'rarity' => JewelRarityEnum::class,
        'dust' => 'integer',
        'selling_cost' => 'array',
        'upgrading_cost' => 'array',
        'melting_cost' => 'array',
    ];

    public function scopeByJewelRarity(Builder $query, ?string $jewelRarity): Builder
    {
        $jewelRarityMapping = [
            'common' => JewelRarityEnum::COMMON,
            'improved' => JewelRarityEnum::IMPROVED,
            'magic' => JewelRarityEnum::MAGIC,
            'extraordinary' => JewelRarityEnum::EXTRAORDINARY,
            'legendary' => JewelRarityEnum::LEGENDARY,
            'mythic' => JewelRarityEnum::MYTHIC,
        ];

        return $query->when(isset($jewelRarityMapping[$jewelRarity]), function (Builder $query) use ($jewelRarityMapping, $jewelRarity) {
            return $query->where('rarity', $jewelRarityMapping[$jewelRarity]);
        });
    }
}
