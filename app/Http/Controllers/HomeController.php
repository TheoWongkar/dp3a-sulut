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

        // 1 Berita Aktif Terbaru
        $post = Post::with('employee.user')->where('status', true)
            ->latest()
            ->first();

        // Berita Aktif Terbaru
        $newPosts = Post::with('employee.user')->where('status', true)
            ->latest()
            ->take(5)
            ->get();

        return view('index', compact('title', 'post', 'newPosts'));
    }
}
