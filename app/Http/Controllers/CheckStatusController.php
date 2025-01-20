<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class CheckStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Status Laporan
        $search = $validated['search'] ?? null;

        // Status Laporan
        $report = Report::with('statuses')->where('ticket_number', 'LIKE', "$search")->first();

        // Judul Halaman
        $title = "Cek Status";

        return view('check-statuses', compact('title', 'report', 'search'));
    }
}
