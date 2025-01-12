<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Laporan";

        $validated = $request->validate([
            'receivedSearch' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $receivedSearch = $validated['receivedSearch'] ?? null;
        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        $receivedReports = Report::with('employee.user', 'latestStatus')
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

        $reports = Report::with('employee.user', 'latestStatus')
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $ticket_number)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ticket_number)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ticket_number)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ticket_number)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticket_number)
    {
        $report = Report::where('ticket_number', $ticket_number)->firstOrFail();

        if (!$report) {
            return redirect()->route('dashboard.reports.index')
                ->with('error', 'Laporan tidak ditemukan.');
        }

        $report->delete();

        return redirect()->route('dashboard.reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
