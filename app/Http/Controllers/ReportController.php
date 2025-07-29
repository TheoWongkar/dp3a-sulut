<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function checkStatus(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'ticket_number' => 'nullable|string|max:16',
        ]);

        // Inisialisasi
        $ticketNumber = $validated['ticket_number'] ?? null;

        // Data Laporan
        $report = Report::with('handler', 'victim', 'suspect', 'reporter', 'statuses', 'latestStatus')->where('ticket_number', 'LIKE', "$ticketNumber")->first();

        return view('reports.check-status', compact('report', 'ticketNumber'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Reporter
            'reporter_name' => 'required|string|max:255',
            'reporter_phone' => 'required|string|max:20',
            'reporter_address' => 'required|string',
            'reporter_age' => 'required|integer',
            'reporter_gender' => 'required|in:Laki-laki,Perempuan',
            'reporter_relationship_between' => 'required|in:Diri Sendiri,Orang Tua,Saudara,Guru,Teman,Lainnya',

            // Step 2: Victim
            'victim_name' => 'required|string|max:255',
            'victim_phone' => 'required|string|max:20',
            'victim_address' => 'required|string',
            'victim_age' => 'required|integer',
            'victim_gender' => 'required|in:Laki-laki,Perempuan',
            'victim_description' => 'nullable|string',

            // Step 3: Suspect
            'suspect_name' => 'nullable|string|max:255',
            'suspect_phone' => 'nullable|string|max:20',
            'suspect_address' => 'nullable|string',
            'suspect_age' => 'nullable|integer',
            'suspect_gender' => 'nullable|in:Laki-laki,Perempuan',
            'suspect_description' => 'nullable|string',

            // Step 4: Report
            'incident_date' => 'required|date',
            'violence_category' => 'required|in:Fisik,Psikis,Seksual,Penelantaran,Eksploitasi,Lainnya',
            'regency' => 'required|string',
            'district' => 'required|string',
            'scene' => 'required|string',
            'evidence' => 'nullable|mimes:pdf,jpg,jpeg,png,mp4,webm|max:10240',
            'chronology' => 'required|string',

            // Agreement
            'agree' => 'accepted',
        ]);

        // Simpan Laporan
        $ticketNumber = Report::generateTicketNumber();
        $report = Report::create([
            'ticket_number' => $ticketNumber,
            'violence_category' => $validated['violence_category'],
            'incident_date' => $validated['incident_date'],
            'regency' => $validated['regency'],
            'district' => $validated['district'],
            'scene' => $validated['scene'],
            'chronology' => $validated['chronology'] ?? null,
        ]);

        // Simpan file evidence jika ada
        if ($request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('evidences', 'public');
            $report->update(['evidence' => $path]);
        }

        // Simpan Reporter
        $report->reporter()->create([
            'name' => $validated['reporter_name'],
            'phone' => $validated['reporter_phone'],
            'gender' => $validated['reporter_gender'],
            'relationship_between' => $validated['reporter_relationship_between'],
            'address' => $validated['reporter_address'] ?? null,
            'age' => $validated['reporter_age'] ?? null,
        ]);

        // Simpan Korban
        $report->victim()->create([
            'name' => $validated['victim_name'],
            'gender' => $validated['victim_gender'],
            'age' => $validated['victim_age'] ?? null,
            'phone' => $validated['victim_phone'] ?? null,
            'address' => $validated['victim_address'] ?? null,
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Simpan Terduga
        $report->suspect()->create([
            'name' => $validated['suspect_name'],
            'gender' => $validated['suspect_gender'],
            'age' => $validated['suspect_age'] ?? null,
            'phone' => $validated['suspect_phone'] ?? null,
            'address' => $validated['suspect_address'] ?? null,
            'description' => $validated['suspect_description'] ?? null,
        ]);

        // Simpan Status
        $report->statuses()->create([
            'status' => 'Diterima',
            'description' => 'Laporan telah diterima. Petugas kami akan segera menghubungi Anda.',
        ]);

        return redirect()->route('report.create')->with([
            'success' => 'Laporan berhasil dikirim!',
            'ticket_number' => $ticketNumber,
        ]);
    }
}
