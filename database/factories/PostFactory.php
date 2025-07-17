<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PostCategory;
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
        $title = fake()->sentence(4);
        return [
            'author_id' => User::inRandomOrder()->first()?->id,
            'category_id' => PostCategory::inRandomOrder()->first()?->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'status' => fake()->randomElement(['Draf', 'Terbit', 'Arsip']),
            'views' => fake()->numberBetween(0, 1000),
        ];
    }
}
