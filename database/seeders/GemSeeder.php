<?php

namespace Database\Seeders;

use App\Enums\GemRarityEnum;
use App\Enums\GemTypeEnum;
use App\Models\Gem;
use Illuminate\Database\Seeder;

class GemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $gemTypeEnum = GemTypeEnum::cases();
        $gemRarityEnum = GemRarityEnum::cases();

        $types = array_column($gemTypeEnum, 'value');
        $rarities = array_column($gemRarityEnum, 'value');

        $descriptions = array_map(function ($gem) {
            return $gem->description();
        }, $gemTypeEnum);

        $gemDescriptions = array_combine($types, $descriptions);
        $offensiveGemDescriptions = array_slice($gemDescriptions, 0, 4);
        $defensiveGemDescriptions = array_slice($gemDescriptions, 4, 9);

        $effects = array_map(function ($gem) {
            return $gem->effect();
        }, $gemTypeEnum);

        $gemEffects = array_combine($types, $effects);
        $offensiveGemEffects = array_slice($gemEffects, 0, 4);
        $defensiveGemEffects = array_slice($gemEffects, 4, 9);

        $offensives = array_map(function ($gem) {
            return $gem->offensive();
        }, $gemRarityEnum);

        $offensiveGemRarities = array_combine($rarities, $offensives);

        $defensives = array_map(function ($gem) {
            return $gem->defensive();
        }, $gemRarityEnum);

        $defensiveGemRarities = array_combine($rarities, $defensives);

        $i = 0;
        foreach ($offensiveGemRarities as $rarity => $dust) {
            foreach ($offensiveGemDescriptions as $type => $effect) {
                if ($rarity === 'gem') {
                    $name = $type;
                    $image = $type;
                } else {
                    $name = $rarity.'_'.$type;
                    $image = $rarity;
                }

                $value = $offensiveGemEffects[$type][$i];

                $gemName = ucwords(str_replace('_', ' ', $name));

                Gem::factory()->create([
                    'image_path' => "images/gems/$type/$image.webp",
                    'name' => $gemName,
                    'type' => $type,
                    'rarity' => $rarity,
                    'effect' => "+ $value $effect",
                    'value' => $value,
                    'dust' => $dust,
                ]);
            }

            $i++;
        }

        $j = 0;
        foreach ($defensiveGemRarities as $rarity => $dust) {
            foreach ($defensiveGemDescriptions as $type => $effect) {
                if ($rarity === 'gem') {
                    $name = $type;
                    $image = $type;
                } else {
                    $name = $rarity.'_'.$type;
                    $image = $rarity;
                }

                $value = $defensiveGemEffects[$type][$j];

                $gemName = ucwords(str_replace('_', ' ', $name));

                Gem::factory()->create([
                    'image_path' => "images/gems/$type/$image.webp",
                    'name' => $gemName,
                    'type' => $type,
                    'rarity' => $rarity,
                    'effect' => "+ $value $effect",
                    'value' => $value,
                    'dust' => $dust,
                ]);
            }

            $j++;
        }
    }
}
