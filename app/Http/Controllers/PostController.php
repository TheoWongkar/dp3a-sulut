<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Semua Berita Aktif
        $posts = Post::with('employee.user')->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Berita Aktif Populer
        $popularPosts = Post::with('employee.user')->where('status', true)
            ->orderBy('views', 'DESC')
            ->take(9)
            ->get();

        // Judul Halaman
        $title = "Berita";

        return view('posts', compact('title', 'posts', 'popularPosts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        // Lihat Berita Aktif
        $post = Post::with('employee.user')->where('status', true)
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
