<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class PostCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'category' => 'nullable|string|exists:post_categories,slug',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $category = $validated['category'] ?? null;
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Berita Dengan Data berita terkait
        $postCategories = PostCategory::with('posts')
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })
            ->when($category, function ($query) use ($category) {
                return $query->where('slug', $category);
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

        return view('dashboard.post-categories.index', compact('postCategories', 'categories'));
    }

    public function store(Request $request)
    {
        // Cek Izin Akses
        Gate::authorize('create', PostCategory::class);

        // Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Simpan posts category
        $postCategory = PostCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Kategori berita berhasil ditambahkan.');
    }

    public function update(Request $request, string $slug)
    {
        // Ambil data post category berdasarkan slug
        $postCategory = PostCategory::where('slug', $slug)->firstOrFail();

        // Cek Izin Akses
        Gate::authorize('update', $postCategory);

        // Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Update post category
        $postCategory->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Kategori berita berhasil diperbarui.');
    }


    public function destroy(string $slug)
    {
        // Ambil berita berdasarkan slug
        $postCategory = PostCategory::where('slug', $slug)->firstOrFail();

        // Cek Izin Akses
        Gate::authorize('delete', $postCategory);

        // Hapus data berita
        $postCategory->delete();

        return redirect()->back()->with('success', 'Kategori berita berhasil dihapus.');
    }
}
