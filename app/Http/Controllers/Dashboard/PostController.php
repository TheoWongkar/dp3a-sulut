<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Berita";

        $validated = $request->validate([
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        $posts = Post::with('employee.user')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhereHas('employee.user', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "{$search}%");
                    });
            })
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('dashboard.post.index', compact('title', 'posts', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if (!$post) {
            return redirect()->route('dashboard.posts.index')
                ->with('error', 'Berita tidak ditemukan.');
        }

        $post->delete();

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
