<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'status' => 'nullable|string|in:Draf,Terbit,Arsip',
            'category' => 'nullable|string|exists:post_categories,slug',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $status = $validated['status'] ?? null;
        $category = $validated['category'] ?? null;
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Berita Dengan Data Author dan Category
        $posts = Post::with(['author.employee', 'category'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhereHas('author.employee', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        // Kategori Berita
        $categories = PostCategory::all();

        return view('dashboard.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        // Kategori Berita
        $categories = PostCategory::all();

        return view('dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:post_categories,id',
            'status'   => 'required|string|in:Draf,Terbit,Arsip',
            'content'  => 'required|string|min:10',
            'image'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Simpan posts
        $post = Post::create([
            'author_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'status' => $validated['status'],
            'content' => $validated['content'],
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(string $slug)
    {
        // Kategori Berita
        $categories = PostCategory::all();

        // Ambil berita berdasarkan slug
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $slug)
    {
        // Ambil berita berdasarkan slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Validasi Input
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|integer|exists:post_categories,id',
            'status'      => 'required|string|in:Draf,Terbit,Arsip',
            'content'     => 'required|string|min:10',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        } else {
            $imagePath = $post->image;
        }

        // Update post
        $post->update([
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'status'      => $validated['status'],
            'content'     => $validated['content'],
            'image'       => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(string $slug)
    {
        // Ambil berita berdasarkan slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Hapus gambar jika ada
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Hapus data berita
        $post->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus.');
    }
}
