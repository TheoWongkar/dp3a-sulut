<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        return view('dashboard.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'image' => 'required|image|max:3072|mimes:jpg,jpeg,png',
            'body' => 'required|string|max:10000',
            'status' => 'required|boolean',
        ]);

        $validated['employee_id'] = Auth::id();
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $filePath;
        }
        $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 100);

        Post::create($validated);

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('dashboard.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('dashboard.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'image' => 'nullable|image|max:3072|mimes:jpg,jpeg,png',
            'body' => 'required|string|max:10000',
            'status' => 'required|boolean',
        ]);

        $post = Post::where('slug', $slug)->firstOrFail();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $filePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $filePath;
        }
        $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 100);

        $post->update($validated);

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Berita berhasil diubah.');
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
