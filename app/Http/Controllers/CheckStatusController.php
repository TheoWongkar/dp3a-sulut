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
        $search = $request->input('search');

        $report = Report::with('employee.user', 'statuses')->where('ticket_number', 'LIKE', "$search")->first();

        return view('check-status', compact('report', 'search'));
    }
}
