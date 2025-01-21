<?php

namespace App\View\Components;

use Closure;
use App\Models\Post;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class NewsWidget extends Component
{
    /**
     * Create a new component instance.
     */

    public $newPosts;

    public function __construct()
    {
        // Berita Terbaru Aktif
        $this->newPosts = Post::with('employee.user')->where('status', true)
            ->latest()
            ->take(6)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.news-widget');
    }
}
