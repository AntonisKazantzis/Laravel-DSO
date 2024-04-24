<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventCalendar>
 */
class EventCalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'start_time' => $this->faker->time,
            'end_time' => $this->faker->time,
            'is_active' => $this->faker->boolean,
        ];
    }
}
