<?php

namespace Database\Factories;

use App\Enums\GemRarityEnum;
use App\Enums\GemTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gem>
 */
class GemFactory extends Factory
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
            'type' => $this->faker->randomElement(GemTypeEnum::cases()),
            'rarity' => $this->faker->randomElement(GemRarityEnum::cases()),
            'effect' => $this->faker->sentence,
            'value' => $this->faker->randomFloat(0, 1, 300000),
            'dust' => $this->faker->numberBetween(1, 24000),
            'andermant' => $this->faker->numberBetween(25, 25000),
            'selling_cost' => ([
                'gold' => $this->faker->numberBetween(0, 1000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
            ]),
            'upgrading_cost' => ([
                'gold' => $this->faker->numberBetween(0, 50000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 5000),
            ]),
            'melting_cost' => ([
                'gold' => $this->faker->numberBetween(0, 10000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 2000),
            ]),
        ];
    }
}
