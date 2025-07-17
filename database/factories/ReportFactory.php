<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Report;
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
            'handled_id' => User::inRandomOrder()->first()?->id,
            'ticket_number' => Report::generateTicketNumber(),
            'violence_category' => fake()->randomElement(['Fisik', 'Psikis', 'Seksual', 'Penelantaran', 'Eksploitasi', 'Lainnya']),
            'chronology' => fake()->paragraph(),
            'incident_date' => fake()->date(),
            'regency' => fake()->city(),
            'district' => fake()->citySuffix(),
            'scene' => fake()->streetAddress(),
            'evidence' => null,
            'completed_at' => fake()->optional()->dateTime(),
        ];
    }
}
