<?php

namespace Database\Factories;

use App\Enums\CharacterClassEnum;
use App\Enums\ItemRarityEnum;
use App\Enums\ItemTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_path' => $this->faker->url,
            'name' => $this->faker->word,
            'level' => $this->faker->numberBetween(1, 145),
            'rarity' => $this->faker->randomElement(ItemRarityEnum::cases()),
            'class' => $this->faker->randomElement(CharacterClassEnum::cases()),
            'type' => $this->faker->randomElement(ItemTypeEnum::cases()),
            'description' => $this->faker->sentence,
            'base_values' => ([
                'first' => $this->faker->randomFloat(0, 3, 100000),
                'second' => $this->faker->randomFloat(0, 3, 100000),
                'third' => $this->faker->randomFloat(0, 3, 100000),
            ]),
            'selling_cost' => ([
                'gold' => $this->faker->numberBetween(0, 20000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
            ]),
            'upgrading_cost' => ([
                'gold' => $this->faker->numberBetween(0, 100000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 5000),
            ]),
            'melting_cost' => ([
                'gold' => $this->faker->numberBetween(0, 100000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 2000),
            ]),
        ];
    }
}
