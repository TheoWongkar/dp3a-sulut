<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reporter>
 */
class ReporterFactory extends Factory
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
            'phone' => fake()->optional()->numerify('08##########'),
            'address' => fake()->optional()->address(),
            'relationship_between' => fake()->randomElement(['Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']),
        ];
    }
}
