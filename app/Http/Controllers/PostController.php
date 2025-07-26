<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'search'   => 'nullable|string|min:1',
            'category' => 'nullable|string|exists:post_categories,slug',
        ]);

        // Ambil Nilai
        $search = $validated['search'] ?? null;
        $category = $validated['category'] ?? null;

        // Post terbaru (status 'Terbit')
        $posts = Post::with('author', 'category')
            ->where('status', 'Terbit')
            ->when(
                $search,
                fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
            )
            ->when(
                $category,
                fn($query) =>
                $query->whereHas(
                    'category',
                    fn($q) =>
                    $q->where('slug', $category)
                )
            )
            ->latest()
            ->paginate(5);

        // Kategori Postingan
        $categories = PostCategory::all();

        // Post terbaru (status 'Terbit'), diurutkan berdasarkan created_at terbaru
        $latestPosts = Post::with('author', 'category')
            ->where('status', 'Terbit')
            ->latest()
            ->take(10)
            ->get();

        // Post terbaru (status 'Terbit'), diurutkan berdasarkan views tertinggi
        $popularPosts = Post::with('author', 'category')
            ->where('status', 'Terbit')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        return view('posts.index', compact(
            'categories',
            'posts',
            'latestPosts',
            'popularPosts',
        ));
    }

    public function show(string $slug)
    {
        // Post yang dipilih
        $post = Post::with('author', 'category')
            ->where('slug', $slug)
            ->firstOrFail();

        // Buat key unik untuk cookie
        $cookieKey = 'viewed_post_' . $post->id;

        // Cek apakah user sudah pernah lihat post ini dalam 1 hari
        if (!Cookie::has($cookieKey)) {
            // Tambahkan jumlah view
            $post->increment('views');

            // Set cookie untuk 1 hari (1440 menit)
            Cookie::queue($cookieKey, true, 1440);
        }

        // Kategori Postingan
        $categories = PostCategory::all();

        // Post terbaru (status 'Terbit'), diurutkan berdasarkan created_at terbaru
        $latestPosts = Post::with('author', 'category')
            ->where('status', 'Terbit')
            ->latest()
            ->take(10)
            ->get();

        // Post terbaru (status 'Terbit'), diurutkan berdasarkan views tertinggi
        $popularPosts = Post::with('author', 'category')
            ->where('status', 'Terbit')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        return view('posts.show', compact('post', 'categories', 'latestPosts', 'popularPosts'));
    }
}
