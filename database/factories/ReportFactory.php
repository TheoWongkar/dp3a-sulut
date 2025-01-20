<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Support\Str;
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
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'ticket_number' => 'TKT-' . Str::random(4) . now()->format('dmY'),
            'violence_category' => fake()->randomElement(['Kekerasan Fisik', 'Kekerasan Psikis', 'Kekerasan Seksual', 'Penelantaran Anak', 'Eksploitasi Anak']),
            'chronology' => fake()->paragraph(1, true),
            'date' => fake()->date(),
            'scene' => fake()->address(),
            'evidence' => null,
        ];
    }
}
