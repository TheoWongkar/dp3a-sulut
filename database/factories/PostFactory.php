<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);

        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->text(100),
            'body' => fake()->paragraphs(2, true),
            'image' => fake()->imageUrl(640, 480, 'posts', true, 'Post Image'),
            'status' => fake()->boolean(90),
            'views' => rand(1, 3),
        ];
    }
}
