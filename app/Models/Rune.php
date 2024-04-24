<?php

namespace App\Models;

use App\Enums\RuneRarityEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rune extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'rarity' => RuneRarityEnum::class,
        'dust' => 'integer',
        'draken' => 'integer',
        'andermant' => 'integer',
        'materi_fragment' => 'integer',
        'gilded_clover' => 'integer',
        'selling_cost' => 'array',
        'upgrading_cost' => 'array',
        'melting_cost' => 'array',
    ];

    public function scopeByRuneRarity(Builder $query, ?string $runeRarity): Builder
    {
        $runeRarityMapping = [
            'common' => RuneRarityEnum::COMMON,
            'improved' => RuneRarityEnum::IMPROVED,
            'magic' => RuneRarityEnum::MAGIC,
            'extraordinary' => RuneRarityEnum::EXTRAORDINARY,
            'legendary' => RuneRarityEnum::LEGENDARY,
            'unique' => RuneRarityEnum::UNIQUE,
        ];

        return $query->when(isset($runeRarityMapping[$runeRarity]), function (Builder $query) use ($runeRarityMapping, $runeRarity) {
            return $query->where('rarity', $runeRarityMapping[$runeRarity]);
        });
    }
}
