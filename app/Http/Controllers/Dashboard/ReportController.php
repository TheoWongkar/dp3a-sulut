<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Laporan";

        // Validasi Search Form
        $validated = $request->validate([
            'receivedSearch' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $receivedSearch = $validated['receivedSearch'] ?? null;
        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        // Semua Laporan Diterima
        $receivedReports = Report::with(['employee.user', 'latestStatus'])
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diterima');
            })
            ->when($receivedSearch, function ($query, $receivedSearch) {
                return $query->where(function ($query) use ($receivedSearch) {
                    $query->where('ticket_number', 'LIKE', "%{$receivedSearch}%")
                        ->orWhere('violence_category', 'LIKE', "%{$receivedSearch}%")
                        ->orWhereHas('employee.user', function ($query) use ($receivedSearch) {
                            $query->where('name', 'LIKE', "%{$receivedSearch}%");
                        });
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        // Semua Laporan
        $reports = Report::with(['employee.user', 'latestStatus'])
            ->when($status, function ($query) use ($status) {
                return $query->whereHas('latestStatus', function ($query) use ($status) {
                    $query->where('status', $status);
                });
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('ticket_number', 'LIKE', "%{$search}%")
                        ->orWhere('violence_category', 'LIKE', "%{$search}%")
                        ->orWhereHas('employee.user', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('dashboard.report.index', compact('title', 'receivedReports', 'reports', 'receivedSearch', 'search', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $ticket_number)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Ambil Data Berdasarkan Nomor Tiket
        $report = Report::with(['statuses', 'victim', 'perpetrator', 'reporter'])->where('ticket_number', $ticket_number)->firstOrFail();

        // Isi Data Ditangani Oleh
        if (!$report->employee_id) {
            $user = Auth::user();

            if ($user && $user->employee_id) {
                $report->employee_id = $user->employee_id;
                $report->save();
            }
        }

        // Isi Data Status
        $report->statuses()->create([
            'report_id' => $report->id,
            'status' => $validatedData['status'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->route('dashboard.reports.show', $report->ticket_number)
            ->with('success', 'Status berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ticket_number)
    {
        $title = "Laporan " . $ticket_number;

        // Ambil Data Berdasarkan Nomor Tiket Serta Statusnya
        $report = Report::with(['statuses', 'victim', 'perpetrator', 'reporter'])->where('ticket_number', $ticket_number)->firstOrFail();
        $statuses = $report->statuses;

        return view('dashboard.report.show', compact('title', 'report', 'statuses'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticket_number)
    {
        // Ambil Data Berdasarkan Nomor Tiket
        $report = Report::where('ticket_number', $ticket_number)->firstOrFail();

        // Laporan Tidak Ditemukan
        if (!$report) {
            return redirect()->route('dashboard.reports.index')
                ->with('error', 'Laporan tidak ditemukan.');
        }

        // Hapus Data Laporan
        $report->delete();

        return redirect()->route('dashboard.reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
