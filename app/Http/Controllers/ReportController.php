<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Suspect;
use App\Models\Reporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            'regency' => 'required|integer',
            'district' => 'required|integer',
            'scene' => 'required|string|min:3|max:255',
            'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

            'victim_name' => 'required|string|min:3|max:255',
            'victim_phone' => 'required|numeric|digits_between:10,13',
            'victim_gender' => 'required|string|in:Pria,Wanita',
            'victim_description' => 'nullable|string|max:255',

            'suspect_name' => 'nullable|string|min:3|max:255',
            'suspect_gender' => 'required|string|in:Pria,Wanita',
            'suspect_description' => 'nullable|string|max:255',

            'reporter_name' => 'required|string|min:3|max:255',
            'reporter_phone' => 'required|numeric|digits_between:10,13',
            'reporter_gender' => 'required|string|in:Pria,Wanita',
            'reporter_relationship_between' => 'required|string|in:Orang Tua,Saudara,Guru,Teman,Lainnya',
        ]);

        // Ambil Nama Kabupaten/Kota
        $regencyId = $validated['regency'];
        $districtId = $validated['district'];

        $regencyData = Http::get("https://ibnux.github.io/data-indonesia/kabupaten/71.json")->json();
        $districtData = Http::get("https://ibnux.github.io/data-indonesia/kecamatan/$regencyId.json")->json();

        // Cari nama berdasarkan ID
        $regencyName = collect($regencyData)->firstWhere('id', $regencyId)['nama'] ?? null;
        $districtName = collect($districtData)->firstWhere('id', $districtId)['nama'] ?? null;

        if (!$regencyName || !$districtName) {
            return back()->withErrors(['error' => 'Data wilayah tidak ditemukan']);
        }

        // Format Capital Each Word sebelum menyimpan
        $regencyName = ucwords(strtolower($regencyName));
        $districtName = ucwords(strtolower($districtName));

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
            'regency' => $regencyName,
            'district' => $districtName,
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
        Suspect::create([
            'report_id' => $report->id,
            'name' => $validated['suspect_name'] ?? null,
            'gender' => $validated['suspect_gender'],
            'description' => $validated['suspect_description'] ?? null,
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
