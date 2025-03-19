<?php

namespace App\View\Components;

use Closure;
use App\Models\Post;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class NewPosts extends Component
{
    /**
     * Create a new component instance.
     */

    public $newPosts;

    public function __construct()
    {
        // Berita Aktif Terbaru
        $this->newPosts = Post::with('author')->where('status', 'Terbit')
            ->latest()
            ->take(6)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.new-posts');
    }
}
