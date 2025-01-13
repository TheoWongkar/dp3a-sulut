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
        $title = "Berita";

        // Semua Berita Aktif
        $posts = Post::with('employee.user')->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Berita Aktif Populer
        $popularPosts = Post::with('employee.user')->where('status', true)
            ->orderBy('views', 'DESC')
            ->take(9)
            ->get();

        return view('posts', compact('title', 'posts', 'popularPosts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $title = "Berita " . $slug;

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

        return view('post', compact('title', 'post'));
    }
}
