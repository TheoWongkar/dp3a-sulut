<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $title = "Beranda";

        $post = Post::with('employee.user')->where('status', true)
            ->latest()
            ->first();
        $posts = Post::with('employee.user')->where('status', true)
            ->latest()
            ->take(10)
            ->get();

        return view('index', compact('title', 'posts', 'post'));
    }
}
