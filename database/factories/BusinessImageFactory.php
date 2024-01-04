<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessImage>
 */
class BusinessImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'path' => $this->faker->imageUrl(640, 480, 'business', true),
            'type' => $this->faker->randomElement(['LOGO', 'COVER']),
            'business_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
