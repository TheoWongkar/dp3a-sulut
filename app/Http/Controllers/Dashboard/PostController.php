<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
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
            'status' => 'nullable|string|in:Arsip,Terbit,all',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:50',
        ]);

        // Ambil Nilai
        $status = $validated['status'] ?? 'all';
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Berita
        $posts = Post::with('author')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhereHas('author.employee', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Judul Halaman
        $title = "Berita";

        return view('dashboard.post.index', compact('title', 'posts', 'status', 'start_date', 'end_date', 'search'));
    }

    public function create()
    {
        // Judul Halaman
        $title = "Tambah Berita";

        return view('dashboard.post.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'image' => 'required|image|max:3072|mimes:jpg,jpeg,png',
            'content' => 'required|string|max:10000',
            'status' => 'required|string|in:Arsip,Terbit',
        ]);

        // Simpan Gambar
        $validated['author_id'] = Auth::id();
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $filePath;
        }

        // Simpan Berita
        Post::create($validated);

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(string $slug)
    {
        // Ambil Data Berdasarkan Slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Judul Halaman
        $title = "Berita: " . $post->title;

        return view('dashboard.post.show', compact('title', 'post'));
    }

    public function edit(string $slug)
    {
        // Ambil Data Berdasarkan Slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Judul Halaman
        $title = "Berita: " . $post->title;

        return view('dashboard.post.edit', compact('title', 'post'));
    }

    public function update(Request $request, string $slug)
    {
        // Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'image' => 'nullable|image|max:3072|mimes:jpg,jpeg,png',
            'content' => 'required|string|max:10000',
            'status' => 'required|string|in:Arsip,Terbit',
        ]);

        // Ambil Data Berdasarkan Slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Simpan Gambar
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $filePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $filePath;
        }

        // Simpan Berita
        $post->update($validated);

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(string $slug)
    {
        // Ambil Data Berdasarkan Slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Hapus Gambar
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        //Hapus Berita
        $post->delete();

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
