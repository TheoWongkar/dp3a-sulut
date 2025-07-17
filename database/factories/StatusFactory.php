<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
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
            'changed_by' => User::inRandomOrder()->first()?->id,
            'status' => fake()->randomElement(['Diterima', 'Menunggu Verifikasi', 'Diproses', 'Selesai', 'Dibatalkan']),
            'description' => fake()->sentence(),
        ];
    }
}
