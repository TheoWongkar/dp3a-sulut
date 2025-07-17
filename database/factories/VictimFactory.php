<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Victim>
 */
class VictimFactory extends Factory
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
            'age' => fake()->numberBetween(5, 90),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'description' => fake()->paragraph(),
        ];
    }
}
