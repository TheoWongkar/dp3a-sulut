<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class CheckStatusController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'search' => 'nullable|string|max:14',
        ]);

        // Status Laporan
        $search = $validated['search'] ?? null;

        // Data Laporan
        $report = Report::with('statuses')->where('ticket_number', 'LIKE', "$search")->first();

        // Judul Halaman
        $title = "Cek Status";

        return view('check-status', compact('title', 'report', 'search'));
    }
}
