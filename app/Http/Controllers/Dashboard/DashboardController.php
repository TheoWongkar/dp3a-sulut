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
    /**
     * Display a listing of the resource.
     */
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
            'publishedPosts' => Post::where('status', true)->count(),
            'archivedPosts' => Post::where('status', false)->count(),
            'popularPosts' => Post::orderBy('views', 'desc')->take(3)->get(),
        ];
    }

    private function getEmployeesStatistics()
    {
        return [
            'totalEmployees' => Employee::count(),
            'activeEmployees' => Employee::where('status', true)->count(),
            'inactiveEmployees' => Employee::where('status', false)->count(),
            'topPosters' => Employee::withCount('posts')->orderBy('posts_count', 'desc')->take(2)->get(),
            'topReporters' => Employee::withCount('reports')->orderBy('reports_count', 'desc')->take(2)->get(),
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

        // Membuat array untuk jumlah laporan tiap bulan, jika ada bulan yang kosong, diisi 0
        $monthlyReports = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyReports[] = $totalReportsPerMonth[$i] ?? 0;
        }

        return [
            'totalReports' => Report::count(),
            'receivedReports' => Report::whereHas('LatestStatus', fn($query) => $query->where('status', 'Diterima'))->count(),
            'processedReports' => Report::whereHas('LatestStatus', fn($query) => $query->where('status', 'Diproses'))->count(),
            'completedReports' => Report::whereHas('LatestStatus', fn($query) => $query->where('status', 'Selesai'))->count(),
            'canceledReports' => Report::whereHas('LatestStatus', fn($query) => $query->where('status', 'Dibatalkan'))->count(),

            'totalReportsPerMonth' => $monthlyReports,
            'totalMaleVictims' => Victim::where('gender', 'Pria')->whereYear('created_at', date('Y'))->count(),
            'totalFemaleVictims' => Victim::where('gender', 'Wanita')->whereYear('created_at', date('Y'))->count(),
        ];
    }
}
