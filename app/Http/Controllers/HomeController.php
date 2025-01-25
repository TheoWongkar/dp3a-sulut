<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // 1 Berita Aktif Terbaru
        $post = Post::with('employee.user')->where('status', true)
            ->latest()
            ->first();

        // Berita Aktif Terbaru
        $newPosts = Post::with('employee.user')->where('status', true)
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
