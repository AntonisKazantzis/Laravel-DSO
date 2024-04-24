<?php

namespace App\Models;

use App\Enums\CharacterClassEnum;
use App\Enums\ItemRarityEnum;
use App\Enums\ItemTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'rarity' => ItemRarityEnum::class,
        'class' => CharacterClassEnum::class,
        'type' => ItemTypeEnum::class,
        'level' => 'integer',
        'base_values' => 'array',
        'selling_cost' => 'array',
        'upgrading_cost' => 'array',
        'melting_cost' => 'array',
    ];

    public function scopeByCharacterClass(Builder $query, ?string $characterClass): Builder
    {
        $characterClassMapping = [
            'dragonknight' => CharacterClassEnum::DRAGONKNIGHT,
            'ranger' => CharacterClassEnum::RANGER,
            'spellweaver' => CharacterClassEnum::SPELLWEAVER,
            'steam_mechanicus' => CharacterClassEnum::STEAM_MECHANICUS,
        ];

        return $query->when(isset($characterClassMapping[$characterClass]), function (Builder $query) use ($characterClassMapping, $characterClass) {
            return $query->where('rarity', $characterClassMapping[$characterClass]->value);
        });
    }

    public function scopeByItemType(Builder $query, ?string $itemType): Builder
    {
        $itemTypeMapping = [
            'amulet' => ItemTypeEnum::AMULET,
            'cape' => ItemTypeEnum::CAPE,
            'belt' => ItemTypeEnum::BELT,
            'ring' => ItemTypeEnum::RING,
            'adornment' => ItemTypeEnum::ADORNMENT,
            'main_hand' => ItemTypeEnum::MAIN_HAND,
            'off_hand' => ItemTypeEnum::OFF_HAND,
            'double_handed' => ItemTypeEnum::DOUBLE_HANDED,
            'helmet' => ItemTypeEnum::HELMET,
            'shoulders' => ItemTypeEnum::SHOULDERS,
            'torso' => ItemTypeEnum::TORSO,
            'gloves' => ItemTypeEnum::GLOVES,
            'boots' => ItemTypeEnum::BOOTS,
        ];

        return $query->when(isset($itemTypeMapping[$itemType]), function (Builder $query) use ($itemTypeMapping, $itemType) {
            return $query->where('rarity', $itemTypeMapping[$itemType]);
        });
    }

    public function scopeByItemRarity(Builder $query, ?string $itemRarity): Builder
    {
        $itemRarityMapping = [
            'common' => ItemRarityEnum::COMMON,
            'improved' => ItemRarityEnum::IMPROVED,
            'magic' => ItemRarityEnum::MAGIC,
            'extraordinary' => ItemRarityEnum::EXTRAORDINARY,
            'legendary' => ItemRarityEnum::LEGENDARY,
            'unique' => ItemRarityEnum::UNIQUE,
            'mythic' => ItemRarityEnum::MYTHIC,
        ];

        return $query->when(isset($itemRarityMapping[$itemRarity]), function (Builder $query) use ($itemRarityMapping, $itemRarity) {
            return $query->where('rarity', $itemRarityMapping[$itemRarity]);
        });
    }
}
