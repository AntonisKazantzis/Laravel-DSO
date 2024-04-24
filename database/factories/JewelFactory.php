<?php

namespace Database\Factories;

use App\Enums\JewelRarityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jewel>
 */
class JewelFactory extends Factory
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
            'rarity' => $this->faker->randomElement(JewelRarityEnum::cases()),
            'effect' => $this->faker->sentence,
            'dust' => $this->faker->randomElement([3000, 8250, 16500, 27750]),
            'selling_cost' => ([
                'gold' => $this->faker->numberBetween(0, 20000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
            ]),
            'upgrading_cost' => ([
                'gold' => $this->faker->numberBetween(0, 100000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 10000),
            ]),
            'melting_cost' => ([
                'gold' => $this->faker->numberBetween(0, 100000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 3000),
            ]),
        ];
    }
}
