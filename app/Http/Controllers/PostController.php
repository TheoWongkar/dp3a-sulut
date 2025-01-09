<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $title = "Berita";

        $posts = Post::with('employee.user')->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $popularPosts = Post::with('employee.user')->where('status', true)
            ->orderBy('views', 'DESC')
            ->take(9)
            ->get();

        return view('posts', compact('title', 'posts', 'popularPosts'));
    }

    public function show(string $slug)
    {
        $title = "Berita";

        $post = Post::with('employee.user')->where('status', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            $post->increment('views');
            session()->put($sessionKey, true);
        }

        return view('post', compact('title', 'post'));
    }
}
