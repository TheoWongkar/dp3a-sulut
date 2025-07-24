<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil tahun sekarang
        $year = now()->year;

        // Ambil laporan per bulan kecuali yang status terakhirnya 'Dibatalkan'
        $reportsPerMonth = Report::whereYear('created_at', $year)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', '!=', 'Dibatalkan');
            })
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Pastikan semua bulan terisi (0 jika tidak ada)
        $monthlyReports = collect(range(1, 12))->mapWithKeys(function ($month) use ($reportsPerMonth) {
            return [$month => $reportsPerMonth->get($month, 0)];
        });

        // Post terbaru (status 'Terbit'), diurutkan berdasarkan created_at terbaru
        $latestPosts = Post::with('author', 'category')
            ->where('status', 'Terbit')
            ->latest()
            ->take(4)
            ->get();

        // Post terbaru (status 'Terbit'), diurutkan berdasarkan categori kekerasan
        $carouselPosts = Post::with('author', 'category')
            ->whereHas('category', function ($query) {
                $query->where('name', 'Kekerasan');
            })
            ->where('status', 'Terbit')
            ->latest()
            ->take(15)
            ->get();

        return view('index', compact('monthlyReports', 'latestPosts', 'carouselPosts'));
    }
}
