<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Semua Berita Aktif
        $posts = Post::with('author')->where('status', "Terbit")
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Berita Aktif Populer
        $popularPosts = Post::with('author')->where('status', "Terbit")
            ->orderBy('views', 'DESC')
            ->take(9)
            ->get();

        // Judul Halaman
        $title = "Berita";

        return view('posts', compact('title', 'posts', 'popularPosts'));
    }

    public function show(string $slug)
    {
        // Lihat Berita Aktif
        $post = Post::with('author')->where('status', 'Terbit')
            ->where('slug', $slug)
            ->firstOrFail();

        // Fitur Menambah Jumlah Views
        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            $post->increment('views');
            session()->put($sessionKey, true);
        }

        // Judul Halaman
        $title = "Berita: " . $post->title;

        return view('post', compact('title', 'post'));
    }
}
