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
            'name' => fake()->name(),
            'age' => fake()->numberBetween(15, 60),
            'relationship_between' => fake()->randomElement(['Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']),
            'description' => fake()->sentence(10),
        ];
    }
}
