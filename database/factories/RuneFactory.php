<?php

namespace Database\Factories;

use App\Enums\RuneRarityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rune>
 */
class RuneFactory extends Factory
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
            'rarity' => $this->faker->randomElement(RuneRarityEnum::cases()),
            'effect' => $this->faker->sentence,
            'dust' => $this->faker->randomElement([3126, 8596, 17188, 28908]),
            'andermant' => $this->faker->randomElement([13000, 19000, 38000]),
            'draken' => $this->faker->randomElement([1500, 2300, 4500]),
            'materi_fragment' => $this->faker->randomElement([120000, 180000, 360000]),
            'gilded_clover' => $this->faker->randomElement([72, 110, 220]),
            'selling_cost' => ([
                'gold' => $this->faker->numberBetween(0, 500),
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
                'gold' => $this->faker->numberBetween(0, 3000),
                'silver' => $this->faker->numberBetween(0, 99),
                'copper' => $this->faker->numberBetween(0, 99),
                'andermant' => $this->faker->numberBetween(4, 300),
            ]),
        ];
    }
}
