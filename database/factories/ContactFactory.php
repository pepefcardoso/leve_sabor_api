<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'website' => $this->faker->url,
            'facebook' => $this->faker->url,
            'instagram' => $this->faker->url,
            'ifood' => $this->faker->url,
            'business_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
