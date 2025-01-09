<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Reporter;
use App\Models\Perpetrator;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $title = "Laporkan";

        return view('reports', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'violence_category' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'scene' => 'required|string',
            'evidence' => 'required|image|mimes:jpg,png,jpeg|max:1024',

            'victim_name' => 'required|string|max:255',
            'victim_age' => 'required|integer|min:0',
            'victim_gender' => 'required|string|in:Pria,Wanita',
            'victim_description' => 'nullable|string',

            'perpetrator_name' => 'nullable|string|max:255',
            'perpetrator_age' => 'nullable|integer|min:0',
            'relationship_between' => 'nullable|string|max:255',
            'perpetrator_description' => 'nullable|string',

            'reporter_whatsapp' => 'nullable|string|max:15',
            'reporter_telegram' => 'nullable|string|max:15',
            'reporter_instagram' => 'nullable|string|max:50',
            'reporter_email' => 'nullable|email|max:255',
        ]);

        // Simpan data laporan
        $ticketNumber = Report::generateTicketNumber();
        $report = Report::create([
            'ticket_number' => $ticketNumber,
            'violence_category' => $validated['violence_category'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'scene' => $validated['scene'],
            'evidence' => $validated['evidence'],
        ]);

        if ($request->hasFile('evidence')) {
            $filePath = $request->file('evidence')->store('evidences', 'public');
            $validated['evidence'] = $filePath;
        }

        // Simpan data korban
        $victim = Victim::create([
            'report_id' => $report->id,
            'name' => $request->victim['name'],
            'age' => $request->victim['age'],
            'gender' => $request->victim['gender'],
            'description' => $request->victim['description'] ?? null,
        ]);

        // Simpan data pelaku (jika ada)
        if ($request->has('perpetrator')) {
            Perpetrator::create([
                'report_id' => $report->id,
                'name' => $request->perpetrator['name'] ?? null,
                'age' => $request->perpetrator['age'] ?? null,
                'relationship_between' => $request->perpetrator['relationship_between'] ?? null,
                'description' => $request->perpetrator['description'] ?? null,
            ]);
        }

        // Simpan data pelapor (jika ada)
        if ($request->has('reporter')) {
            Reporter::create([
                'report_id' => $report->id,
                'whatsapp' => $request->reporter['whatsapp'] ?? null,
                'telegram' => $request->reporter['telegram'] ?? null,
                'instagram' => $request->reporter['instagram'] ?? null,
                'email' => $request->reporter['email'] ?? null,
            ]);
        }

        Status::create([
            'report_id' => $report->id,
        ]);

        return redirect()->route('status.index')->with('success', $ticketNumber);
    }
}
