<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1 Berita Aktif Terbaru
        $post = Post::with('author')->where('status', 'Terbit')
            ->latest()
            ->first();

        // 5 Berita Aktif Terbaru
        $newPosts = Post::with('author')->where('status', 'Terbit')
            ->latest()
            ->take(5)
            ->get();

        // Mendapatkan laporan berdasarkan bulan di tahun ini
        $totalReportsPerMonth = Report::whereYear('created_at', date('Y'))
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', '!=', 'Dibatalkan');
            })
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Membuat array untuk jumlah laporan tiap bulan, jika ada bulan yang kosong, diisi 0
        $monthlyReports = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyReports[] = $totalReportsPerMonth[$i] ?? 0;
        }

        $totalReportsPerMonth = $monthlyReports;

        // Judul Halaman
        $title = "Beranda";

        return view('index', compact('title', 'post', 'newPosts', 'totalReportsPerMonth'));
    }
}
