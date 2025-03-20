<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Report;
use App\Models\Victim;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Berita
        $postsStats = $this->getPostsStatistics();

        // Statistik Karyawan
        $employeesStats = $this->getEmployeesStatistics();

        // Statistik Laporan
        $reportsStats = $this->getReportsStatistics();

        // Judul Halaman
        $title = "Dashboard";

        return view('dashboard.index', array_merge(
            ['title' => $title],
            $postsStats,
            $employeesStats,
            $reportsStats
        ));
    }

    private function getPostsStatistics()
    {
        return [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'Terbit')->count(),
            'archivedPosts' => Post::where('status', 'Arsip')->count(),
            'popularPosts' => Post::orderBy('views', 'desc')->take(3)->get(),
        ];
    }

    private function getEmployeesStatistics()
    {
        return [
            'totalEmployees' => Employee::count(),
            'activeEmployees' => Employee::where('status', 'Aktif')->count(),
            'inactiveEmployees' => Employee::where('status', 'Nonaktif')->count(),
            'topPosters' => Employee::with(['user' => function ($query) {
                $query->withCount('posts')->orderByDesc('posts_count');
            }])
                ->whereHas('user.posts')
                ->limit(2)
                ->get(),
            'topReporters' => Employee::with(['user' => function ($query) {
                $query->withCount('reports')->orderByDesc('reports_count');
            }])
                ->whereHas('user.reports')
                ->limit(2)
                ->get(),
        ];
    }

    private function getReportsStatistics()
    {
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

        // Membuat array untuk jumlah laporan tiap bulan
        $monthlyReports = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyReports[] = $totalReportsPerMonth[$i] ?? 0;
        }

        $currentYear = Carbon::now()->year;

        return [
            'totalReports' => Report::whereYear('created_at', $currentYear)->count(),
            'receivedReports' => Report::whereYear('created_at', $currentYear)
                ->whereHas('LatestStatus', fn($query) => $query->where('status', 'Diterima'))
                ->count(),
            'processedReports' => Report::whereYear('created_at', $currentYear)
                ->whereHas('LatestStatus', fn($query) => $query->where('status', 'Diproses'))
                ->count(),
            'completedReports' => Report::whereYear('created_at', $currentYear)
                ->whereHas('LatestStatus', fn($query) => $query->where('status', 'Selesai'))
                ->count(),
            'canceledReports' => Report::whereYear('created_at', $currentYear)
                ->whereHas('LatestStatus', fn($query) => $query->where('status', 'Dibatalkan'))
                ->count(),

            'totalReportsPerMonth' => $monthlyReports,
            'totalMaleVictims' => Victim::where('gender', 'Pria')
                ->whereHas('report', function ($query) {
                    $query->whereYear('created_at', date('Y'));
                })
                ->count(),

            'totalFemaleVictims' => Victim::where('gender', 'Wanita')
                ->whereHas('report', function ($query) {
                    $query->whereYear('created_at', date('Y'));
                })
                ->count(),

            'reportsByRegency' => Report::select('regency', DB::raw('COUNT(id) as total'))
                ->groupBy('regency')
                ->orderByDesc('total')
                ->limit(3)
                ->get(),

            'reportsByDistrict' =>  Report::select('district', DB::raw('COUNT(id) as total'))
                ->groupBy('district')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
        ];
    }
}
