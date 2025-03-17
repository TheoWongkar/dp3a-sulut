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
            'nik' => fake()->numerify('################'),
            'name' => fake()->name(),
            'phone' => fake()->optional()->numerify('08###########'),
            'address' => fake()->address(),
            'age' => fake()->numberBetween(5, 80),
            'gender' => fake()->randomElement(['Pria', 'Wanita']),
            'description' => fake()->optional()->sentence(),
            'relationship_between' => fake()->randomElement(['Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']),
        ];
    }
}
