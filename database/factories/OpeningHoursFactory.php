<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpeningHours>
 */
class OpeningHoursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'specific_date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'week_day' => $this->faker->numberBetween(1, 7),
            'open_time_1' => $this->faker->time(),
            'close_time_1' => $this->faker->time(),
            'open_time_2' => $this->faker->time(),
            'close_time_2' => $this->faker->time(),
        ];
    }
}
