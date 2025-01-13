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
        $title = "Cek Status";

        $search = $request->input('search');

        // Status Laporan
        $report = Report::with(['employee.user', 'statuses'])->where('ticket_number', 'LIKE', "$search")->first();

        return view('check-statuses', compact('title', 'report', 'search'));
    }
}
