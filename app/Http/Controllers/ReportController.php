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
    public function create()
    {
        // Judul Halaman
        $title = "Laporkan";

        return view('reports', compact('title'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'violence_category' => 'required|string|max:255',
            'date' => 'required|date',
            'scene' => 'required|string|min:3|max:255',
            'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

            'victim_name' => 'required|string|min:3|max:255',
            'victim_phone' => 'required|numeric|digits_between:10,13',
            'victim_gender' => 'required|string|in:Pria,Wanita',
            'victim_description' => 'nullable|string|max:255',

            'perpetrator_name' => 'nullable|string|min:3|max:255',
            'perpetrator_gender' => 'required|string|in:Pria,Wanita',
            'perpetrator_description' => 'nullable|string|max:255',

            'reporter_name' => 'required|string|min:3|max:255',
            'reporter_phone' => 'required|numeric|digits_between:10,13',
            'reporter_gender' => 'required|string|in:Pria,Wanita',
            'reporter_relationship_between' => 'required|string|in:Orang Tua,Saudara,Guru,Teman,Lainnya',
        ]);

        // Cek Laporan Serupa
        $existingReport = Report::where('violence_category', $validated['violence_category'])
            ->where('date', $validated['date'])
            ->where('scene', $validated['scene'])
            ->whereHas('victim', function ($query) use ($validated) {
                $query->where('name', $validated['victim_name']);
            })
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan serupa sudah ada.',
            ], 409);
        }

        // Simpan Data Evidence
        if ($request->hasFile('evidence')) {
            $filePath = $request->file('evidence')->store('evidences', 'public');
            $validated['evidence'] = $filePath;
        } else {
            $validated['evidence'] = null;
        }

        // Simpan Data Laporan
        $ticket_number = Report::generateTicketNumber();
        $report = Report::create([
            'ticket_number' => $ticket_number,
            'violence_category' => $validated['violence_category'],
            'date' => $validated['date'],
            'scene' => $validated['scene'],
            'evidence' => $validated['evidence'],
        ]);

        // Simpan Data Korban
        Victim::create([
            'report_id' => $report->id,
            'name' => $validated['victim_name'],
            'phone' => $validated['victim_phone'],
            'gender' => $validated['victim_gender'],
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Simpan Data Pelaku
        Perpetrator::create([
            'report_id' => $report->id,
            'name' => $validated['perpetrator_name'] ?? null,
            'gender' => $validated['perpetrator_gender'],
            'description' => $validated['perpetrator_description'] ?? null,
        ]);

        // Simpan Data Pelapor
        Reporter::create([
            'report_id' => $report->id,
            'name' => $validated['reporter_name'],
            'phone' => $validated['reporter_phone'],
            'gender' => $validated['reporter_gender'],
            'relationship_between' => $validated['reporter_relationship_between'],
        ]);

        // Simpan Data Status
        Status::create([
            'report_id' => $report->id,
        ]);

        return redirect()->route('reports.create')->with('success', $ticket_number);
    }
}
