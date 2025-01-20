<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perpetrator>
 */
class PerpetratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_id' => Report::inRandomOrder()->first()->id,
            'name' => fake()->optional()->name(),
            'age' => fake()->optional()->numberBetween(15, 60),
            'gender' => fake()->randomElement(['Pria', 'Wanita']),
            'description' => fake()->optional()->sentence(8),
        ];
    }
}
