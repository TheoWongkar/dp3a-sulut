<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'handled_id' => User::inRandomOrder()->first()->id,
            'ticket_number' => 'TKT-' . rand(1000, 9999) . now()->format('dmy'),
            'violence_category' => fake()->word(),
            'chronology' => fake()->optional()->paragraph(),
            'regency' => fake()->randomElement(['Kota Manado', 'Kab. Minahasa', 'Kab. Minahasa Utara']),
            'district' => fake()->randomElement(['Sario', 'Malalayang', 'Pineleng', 'Tondano', 'Airmadidi', 'Dimembe']),
            'date' => fake()->date(),
            'scene' => fake()->address(),
            'evidence' => null,
        ];
    }
}
