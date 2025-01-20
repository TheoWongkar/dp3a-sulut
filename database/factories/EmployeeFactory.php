<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('##################'),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['Pria', 'Wanita']),
            'position' => fake()->jobTitle(),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
            'phone' => fake()->optional()->numerify('08###########'),
            'picture' => null,
            'status' => fake()->boolean(90),
        ];
    }
}
