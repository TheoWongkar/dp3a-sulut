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
            'report_id' => Report::inRandomOrder()->first()?->id,
            'nik' => fake()->numerify('################'),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'age' => fake()->numberBetween(20, 60),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'relationship_between' => fake()->randomElement(['Diri Sendiri', 'Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']),
        ];
    }
}
