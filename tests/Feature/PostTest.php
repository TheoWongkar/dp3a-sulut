<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_only_published_posts_are_displayed()
    {
        $user = User::factory()->create();

        // Buat 2 post "Terbit" dan 1 post "Arsip"
        $publishedPosts = Post::factory()->count(2)->create([
            'status' => 'Terbit',
            'author_id' => $user->id,
        ]);

        $archivedPost = Post::factory()->create([
            'status' => 'Arsip',
            'author_id' => $user->id,
        ]);

        $response = $this->get(route('posts.index'));

        // Pastikan hanya post "Terbit" yang muncul
        $response->assertSee($publishedPosts[0]->title);
        $response->assertSee($publishedPosts[1]->title);
        $response->assertDontSee($archivedPost->title);
    }

    public function test_popular_posts_are_sorted_by_views()
    {
        $user = User::factory()->create();

        // Buat beberapa post dengan jumlah views berbeda
        $post1 = Post::factory()->create(['status' => 'Terbit', 'views' => 10, 'author_id' => $user->id]);
        $post2 = Post::factory()->create(['status' => 'Terbit', 'views' => 50, 'author_id' => $user->id]);
        $post3 = Post::factory()->create(['status' => 'Terbit', 'views' => 30, 'author_id' => $user->id]);

        $response = $this->get(route('posts.index'));

        // Pastikan post dengan views terbanyak ada di urutan pertama
        $response->assertViewHas('popularPosts', function ($popularPosts) use ($post2) {
            return $popularPosts->first()->id === $post2->id;
        });
    }
}
