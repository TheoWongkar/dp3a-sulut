<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Report;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Dashboard";

        // Statistik Berita
        $postsStats = $this->getPostsStatistics();

        // Statistik Karyawan
        $employeesStats = $this->getEmployeesStatistics();

        // Statistik Laporan
        $reportsStats = $this->getReportsStatistics();

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
            'postsCount' => Post::count(),
            'statusTerbit' => Post::where('status', true)->count(),
            'statusDiarsipkan' => Post::where('status', false)->count(),
            'topPosts' => Post::orderBy('views', 'desc')->take(3)->get(),
        ];
    }

    private function getEmployeesStatistics()
    {
        return [
            'employeesCount' => Employee::count(),
            'activeEmployees' => Employee::where('status', true)->count(),
            'inactiveEmployees' => Employee::where('status', false)->count(),
            'topPosters' => Employee::withCount('posts')->orderBy('posts_count', 'desc')->take(3)->get(),
            'topReporters' => Employee::withCount('reports')->orderBy('reports_count', 'desc')->take(3)->get(),
        ];
    }

    private function getReportsStatistics()
    {
        return [
            'reportsCount' => Report::count(),
            'reportsDiterima' => Report::whereHas('statuses', fn($query) => $query->where('status', 'Diterima'))->count(),
            'reportsDiproses' => Report::whereHas('statuses', fn($query) => $query->where('status', 'Diproses'))->count(),
            'reportsSelesai' => Report::whereHas('statuses', fn($query) => $query->where('status', 'Selesai'))->count(),
            'reportsDibatalkan' => Report::whereHas('statuses', fn($query) => $query->where('status', 'Dibatalkan'))->count(),
        ];
    }
}
