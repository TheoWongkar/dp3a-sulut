<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Crypt;
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
            'user_id' => User::inRandomOrder()->first()->id,
            'nip' => fake()->unique()->numerify('##################'),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['Pria', 'Wanita']),
            'position' => fake()->jobTitle(),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
            'phone' => fake()->optional()->numerify('08###########'),
            'avatar' => null,
            'status' => fake()->randomElement(['Aktif', 'Nonaktif']),
        ];
    }
}
