<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Suspect;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Inisasi filter tahun
        $year = $request->input('year', now()->year);
        $years = range(now()->year, now()->year - 2);

        // Ambil data dari private function
        $reportsData = $this->getReportsData($year);
        $employeesData = $this->getEmployeesData($year);
        $postsData = $this->getPostsData($year);

        return view('dashboard.index', array_merge($reportsData, $employeesData, $postsData, [
            'year' => $year,
            'years' => $years,
        ]));
    }

    private function getReportsData($year)
    {
        // Load semua status
        $statuses = [
            'received' => 'Diterima',
            'unverified' => 'Menunggu Verifikasi',
            'processed' => 'Diproses',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan'
        ];

        // Total & status
        $data = [
            'totalReports' => Report::whereYear('created_at', $year)->count(),
        ];

        foreach ($statuses as $key => $status) {
            $data[Str::camel($key) . 'Reports'] = Report::whereYear('created_at', $year)
                ->whereHas('latestStatus', fn($q) => $q->where('status', $status))
                ->count();
        }

        // Per bulan per status
        $data['monthlyReportCounts'] = collect(range(1, 12))->mapWithKeys(function ($month) use ($year, $statuses) {
            $statusCounts = collect($statuses)->mapWithKeys(function ($status) use ($year, $month) {
                $count = Report::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereHas('latestStatus', fn($q) => $q->where('status', $status))
                    ->count();
                return [$status => $count];
            });

            return [
                $month => $statusCounts->put('Total', $statusCounts->sum())
            ];
        });

        // Gender (victims)
        $data['victimGenders'] = Victim::whereHas('report', fn($q) => $q->whereYear('created_at', $year))
            ->selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender');

        // Gender (suspects)
        $data['suspectGenders'] = Suspect::whereHas('report', fn($q) => $q->whereYear('created_at', $year))
            ->whereNotNull('gender')
            ->selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender');

        // Regency terbanyak
        $data['regencies'] = Report::whereYear('created_at', $year)
            ->selectRaw('regency, COUNT(*) as count')
            ->groupBy('regency')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'regency');

        // District terbanyak
        $data['districts'] = Report::whereYear('created_at', $year)
            ->selectRaw('district, COUNT(*) as count')
            ->groupBy('district')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'district');

        $data['statusLabels'] = $statuses;

        return $data;
    }

    private function getEmployeesData($year)
    {
        // Load semua status
        $statuses = [
            'active' => 'Aktif',
            'retired' => 'Pensiun',
            'deceased' => 'Meninggal Dunia',
            'dismissed' => 'Diberhentikan'
        ];

        // Total semua employees tahun tertentu
        $data = [
            'totalEmployees' => Employee::whereYear('created_at', $year)->count(),
        ];

        // Jumlah per status
        foreach ($statuses as $key => $status) {
            $data[$key . 'Employees'] = Employee::whereYear('created_at', $year)
                ->where('status', $status)
                ->count();
        }

        // Jumlah per bulan per status
        $data['monthlyEmployeeCounts'] = collect(range(1, 12))->mapWithKeys(function ($month) use ($year, $statuses) {
            $statusCounts = collect($statuses)->mapWithKeys(function ($status) use ($year, $month) {
                $count = Employee::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('status', $status)
                    ->count();
                return [$status => $count];
            });

            return [
                $month => $statusCounts->put('Total', $statusCounts->sum())
            ];
        });

        // Top 5 authors dalam setahun
        $topAuthors = Post::whereYear('created_at', $year)
            ->whereHas('author')
            ->select('author_id', DB::raw('COUNT(*) as count'))
            ->groupBy('author_id')
            ->orderByDesc('count')
            ->with('author.employee')
            ->limit(5)
            ->get();


        $data['topAuthorsNames'] = $topAuthors->pluck('author.name')->toArray();

        // Hitung post per bulan untuk masing-masing top 5 author
        $monthlyAuthorCounts = [];

        foreach ($topAuthors as $author) {
            $name = optional($author->author->employee)->name
                ?? optional($author->author)->name
                ?? 'User Dihapus';

            $monthlyAuthorCounts[$name] = collect(range(1, 12))->map(function ($month) use ($author, $year) {
                return Post::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('author_id', $author->author_id)
                    ->count();
            })->toArray();
        }

        $data['monthlyAuthorCounts'] = $monthlyAuthorCounts;

        // Top 5 user yang paling sering menangani laporan dalam setahun
        $topHandlers = Status::whereYear('created_at', $year)
            ->whereNotNull('changed_by')
            ->whereHas('changedBy')
            ->select('changed_by', DB::raw('COUNT(*) as count'))
            ->groupBy('changed_by')
            ->orderByDesc('count')
            ->with('changedBy.employee')
            ->limit(5)
            ->get();

        $data['topHandlerNames'] = $topHandlers->pluck('changedBy.name')->toArray();

        // Hitung jumlah status per bulan untuk tiap handler
        $monthlyHandlerCounts = [];

        foreach ($topHandlers as $handler) {
            $name = optional($handler->changedBy->employee)->name
                ?? optional($handler->changedBy)->name
                ?? 'Tidak Diketahui';

            $monthlyHandlerCounts[$name] = collect(range(1, 12))->map(function ($month) use ($handler, $year) {
                return Status::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('changed_by', $handler->changed_by)
                    ->count();
            })->toArray();
        }

        $data['monthlyHandlerCounts'] = $monthlyHandlerCounts;

        return $data;
    }

    private function getPostsData($year)
    {
        // Load semua status
        $statuses = [
            'draft' => 'Draf',
            'published' => 'Terbit',
            'archived' => 'Arsip'
        ];

        // Total semua post tahun tertentu
        $data = [
            'totalPosts' => Post::whereYear('created_at', $year)->count(),
        ];

        // Jumlah per status
        foreach ($statuses as $key => $status) {
            $data[$key . 'Posts'] = Post::whereYear('created_at', $year)
                ->where('status', $status)
                ->count();
        }

        // Jumlah per bulan per status
        $data['monthlyPostCounts'] = collect(range(1, 12))->mapWithKeys(function ($month) use ($year, $statuses) {
            $statusCounts = collect($statuses)->mapWithKeys(function ($status) use ($year, $month) {
                $count = Post::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('status', $status)
                    ->count();
                return [$status => $count];
            });

            return [
                $month => $statusCounts->put('Total', $statusCounts->sum())
            ];
        });

        // Status labels
        $data['statusLabels'] = $statuses;

        return $data;
    }
}
