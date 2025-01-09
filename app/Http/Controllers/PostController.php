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

        $newPosts = Post::with('employee.user')->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        $popularPosts = Post::with('employee.user')->where('status', true)
            ->orderBy('views', 'DESC')
            ->take(9)
            ->get();

        return view('posts', compact('title', 'posts', 'newPosts', 'popularPosts'));
    }

    public function show(string $slug)
    {
        $post = Post::with('employee.user')->where('slug', $slug)
            ->firstOrFail();

        $newPosts = Post::with('employee.user')->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        return view('post', compact('post', 'newPosts'));
    }
}
