<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Suspect;
use App\Models\Reporter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    public function index(Request $request, $status)
    {
        // Validasi Form
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:50',
        ]);

        // Ambil Nilai Filter
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Konversi Status ke Database
        $statusMapping = [
            'diterima' => 'Diterima',
            'diproses' => 'Diproses',
            'selesai' => ['Selesai', 'Dibatalkan'],
        ];

        if (!isset($statusMapping[$status])) {
            abort(404);
        }

        // Ambil Data Sesuai Status
        $reports = Report::with('latestStatus')
            ->whereHas('latestStatus', function ($query) use ($status, $statusMapping) {
                $query->whereIn('status', (array) $statusMapping[$status]);
            })
            ->when($start_date, fn($query) => $query->whereDate('created_at', '>=', $start_date))
            ->when($end_date, fn($query) => $query->whereDate('created_at', '<=', $end_date))
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('ticket_number', 'like', "$search")
                        ->orWhere('violence_category', 'like', "%$search%")
                        ->orWhere('regency', 'like', "$search")
                        ->orWhere('district', 'like', "$search");
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Judul Halaman
        $titleMapping = [
            'diterima' => 'Laporan Diterima',
            'diproses' => 'Laporan Diproses',
            'selesai' => 'Laporan Selesai',
        ];

        return view('dashboard.report.index', [
            'title' => $titleMapping[$status],
            'reports' => $reports,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create()
    {
        // Judul Halaman
        $title = "Tambah Laporan";

        return view('dashboard.report.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'violence_category' => 'required|string|max:255',
            'chronology' => 'required|string|max:10000',
            'date' => 'required|date',
            'regency' => 'required|integer',
            'district' => 'required|integer',
            'scene' => 'required|string|min:3|max:255',
            'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

            'victim_nik' => 'nullable|numeric|digits:16',
            'victim_name' => 'required|string|min:3|max:255',
            'victim_phone' => 'required|numeric|digits_between:10,13',
            'victim_address' => 'nullable|string|min:3|max:255',
            'victim_age' => 'nullable|integer|min:1|max:150',
            'victim_gender' => 'required|string|in:Pria,Wanita',
            'victim_description' => 'nullable|string|max:255',

            'suspect_nik' => 'nullable|numeric|digits:16',
            'suspect_name' => 'nullable|string|min:3|max:255',
            'suspect_phone' => 'nullable|numeric|digits_between:10,13',
            'suspect_address' => 'nullable|string|min:3|max:255',
            'suspect_age' => 'nullable|integer|min:1|max:150',
            'suspect_gender' => 'required|string|in:Pria,Wanita',
            'suspect_description' => 'nullable|string|max:255',

            'reporter_nik' => 'nullable|numeric|digits:16',
            'reporter_name' => 'required|string|min:3|max:255',
            'reporter_phone' => 'required|numeric|digits_between:10,13',
            'reporter_address' => 'required|string|min:3|max:255',
            'reporter_age' => 'required|integer|min:1|max:150',
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
            'handled_id' => Auth::user()->id,
            'ticket_number' => $ticket_number,
            'violence_category' => $validated['violence_category'],
            'chronology' => $validated['chronology'],
            'date' => $validated['date'],
            'regency' => $regencyName,
            'district' => $districtName,
            'scene' => $validated['scene'],
            'evidence' => $validated['evidence'],
        ]);

        // Simpan Data Korban
        Victim::create([
            'report_id' => $report->id,
            'nik' => $validated['victim_nik'] ?? null,
            'name' => $validated['victim_name'],
            'phone' => $validated['victim_phone'],
            'address' => $validated['victim_address'] ?? null,
            'age' => $validated['victim_age'] ?? 0,
            'gender' => $validated['victim_gender'],
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Simpan Data Pelaku
        Suspect::create([
            'report_id' => $report->id,
            'nik' => $validated['suspect_nik'] ?? null,
            'name' => $validated['suspect_name'] ?? null,
            'phone' => $validated['suspect_phone'] ?? null,
            'address' => $validated['suspect_address'] ?? null,
            'age' => $validated['suspect_age'] ?? 0,
            'gender' => $validated['suspect_gender'],
            'description' => $validated['suspect_description'] ?? null,
        ]);

        // Simpan Data Pelapor
        Reporter::create([
            'report_id' => $report->id,
            'nik' => $validated['reporter_nik'] ?? null,
            'name' => $validated['reporter_name'],
            'phone' => $validated['reporter_phone'],
            'address' => $validated['reporter_address'],
            'age' => $validated['reporter_age'],
            'gender' => $validated['reporter_gender'],
            'relationship_between' => $validated['reporter_relationship_between'],
        ]);

        // Simpan Data Status
        Status::create([
            'report_id' => $report->id,
        ]);

        return redirect()->route('dashboard.reports.create')->with('success', $ticket_number);
    }

    public function edit(string $ticket_number)
    {
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Judul Halaman
        $title = "Ubah Laporan " . $report->ticket_number;

        return view('dashboard.report.edit', compact('title', 'report'));
    }

    public function update(Request $request, $ticket_number)
    {
        $validated = $request->validate([
            'violence_category' => 'required|string|max:255',
            'chronology' => 'required|string|max:10000',
            'date' => 'required|date',
            'regency' => 'required|integer',
            'district' => 'required|integer',
            'scene' => 'required|string|min:3|max:255',
            'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

            'victim_nik' => 'required|numeric|digits:16',
            'victim_name' => 'required|string|min:3|max:255',
            'victim_phone' => 'required|numeric|digits_between:10,13',
            'victim_address' => 'required|string|min:3|max:255',
            'victim_age' => 'required|integer|min:1|max:150',
            'victim_gender' => 'required|string|in:Pria,Wanita',
            'victim_description' => 'nullable|string|max:255',

            'suspect_nik' => 'required|numeric|digits:16',
            'suspect_name' => 'required|string|min:3|max:255',
            'suspect_phone' => 'required|numeric|digits_between:10,13',
            'suspect_address' => 'required|string|min:3|max:255',
            'suspect_age' => 'required|integer|min:1|max:150',
            'suspect_gender' => 'required|string|in:Pria,Wanita',
            'suspect_description' => 'nullable|string|max:255',

            'reporter_nik' => 'required|numeric|digits:16',
            'reporter_name' => 'required|string|min:3|max:255',
            'reporter_phone' => 'required|numeric|digits_between:10,13',
            'reporter_address' => 'required|string|min:3|max:255',
            'reporter_age' => 'required|integer|min:1|max:150',
            'reporter_gender' => 'required|string|in:Pria,Wanita',
            'reporter_relationship_between' => 'required|string|in:Orang Tua,Saudara,Guru,Teman,Lainnya',
        ]);

        $report = Report::where('ticket_number', $ticket_number)->firstOrFail();

        // Update nama wilayah berdasarkan ID
        $regencyData = Http::get("https://ibnux.github.io/data-indonesia/kabupaten/71.json")->json();
        $districtData = Http::get("https://ibnux.github.io/data-indonesia/kecamatan/{$validated['regency']}.json")->json();

        $regencyName = collect($regencyData)->firstWhere('id', $validated['regency'])['nama'] ?? null;
        $districtName = collect($districtData)->firstWhere('id', $validated['district'])['nama'] ?? null;

        if (!$regencyName || !$districtName) {
            return back()->withErrors(['error' => 'Data wilayah tidak ditemukan']);
        }

        $validated['regency'] = ucwords(strtolower($regencyName));
        $validated['district'] = ucwords(strtolower($districtName));

        // Update evidence jika ada file baru
        if ($request->hasFile('evidence')) {
            if ($report->evidence) {
                Storage::disk('public')->delete($report->evidence);
            }
            $validated['evidence'] = $request->file('evidence')->store('evidences', 'public');
        } else {
            $validated['evidence'] = $report->evidence;
        }

        $report->update($validated);

        // Update data korban
        $report->victim()->updateOrCreate(['report_id' => $report->id], [
            'nik' => $validated['victim_nik'],
            'name' => $validated['victim_name'],
            'phone' => $validated['victim_phone'],
            'address' => $validated['victim_address'],
            'age' => $validated['victim_age'],
            'gender' => $validated['victim_gender'],
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Update data pelaku
        $report->suspect()->updateOrCreate(['report_id' => $report->id], [
            'nik' => $validated['suspect_nik'],
            'name' => $validated['suspect_name'],
            'phone' => $validated['suspect_phone'],
            'address' => $validated['suspect_address'],
            'age' => $validated['suspect_age'],
            'gender' => $validated['suspect_gender'],
            'description' => $validated['suspect_description'] ?? null,
        ]);

        // Update data pelapor
        $report->reporter()->updateOrCreate(['report_id' => $report->id], [
            'nik' => $validated['reporter_nik'],
            'name' => $validated['reporter_name'],
            'phone' => $validated['reporter_phone'],
            'address' => $validated['reporter_address'],
            'age' => $validated['reporter_age'],
            'gender' => $validated['reporter_gender'],
            'relationship_between' => $validated['reporter_relationship_between'],
        ]);

        return redirect()->route('dashboard.reports.edit', $ticket_number)->with('success', 'Laporan berhasil diperbarui.');
    }

    public function receivedShow(string $status, string $ticket_number)
    {
        // Ambil Data Laporan
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diterima');
            })
            ->firstOrFail();

        // Judul Halaman
        $title = "Laporan";

        return view('dashboard.report.received.show', compact('title', 'report', 'status'));
    }

    public function receivedUpdate(string $status, string $ticket_number)
    {
        // Ambil Data Laporan
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diterima');
            })
            ->firstOrFail();

        // Cek Izin
        if (! Gate::allows('verification-report', $report)) {
            abort(403);
        }

        // Tambah Status
        $report->statuses()->create([
            'report_id' => $report->id,
            'status' => 'Diproses',
            'description' => 'Laporan telah disetujui admin',
        ]);

        return redirect()->route('dashboard.reports.index', $status)->with('success', 'Laporan berhasil diverifikasi');
    }

    public function processedShow(string $status, string $ticket_number)
    {
        // Ambil Data Laporan
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diproses');
            })
            ->firstOrFail();

        // Judul Halaman
        $title = "Laporan";

        return view('dashboard.report.processed.show', compact('title', 'report', 'status'));
    }

    public function processedUpdate(Request $request, string $status, string $ticket_number)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Ambil Data Laporan
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diproses');
            })
            ->firstOrFail();

        // Isi Data Ditangani Oleh
        if (!$report->handled_id) {
            $user = Auth::user();
            $report->handled_id = $user->id;
            $report->save();
        }

        // Isi Data Status
        $report->statuses()->create([
            'report_id' => $report->id,
            'status' => $validatedData['status'],
            'description' => $validatedData['description'],
        ]);

        // Return View Berdasarkan Status Yang Dipilih
        if ($validatedData['status'] === 'Diproses') {
            return redirect()->to(route('dashboard.reports.processed.show', ['status' => $status, 'ticket_number' => $report->ticket_number]) . '#status-update')
                ->with('success', 'Status berhasil diperbarui.');
        }

        return redirect()->route('dashboard.reports.index', $status)
            ->with('success', 'Status berhasil diperbarui.');
    }

    public function completedShow(string $status, string $ticket_number)
    {
        // Ambil Data Laporan
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Selesai')
                    ->orWhere('status', 'Dibatalkan');
            })
            ->firstOrFail();

        // Judul Halaman
        $title = "Laporan: " . $ticket_number;

        return view('dashboard.report.completed.show', compact('title', 'report', 'status'));
    }

    public function printPDF(string $status, string $ticket_number)
    {
        // Ambil data laporan berdasarkan nomor tiket
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])->where('ticket_number', $ticket_number)->firstOrFail();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('dashboard.report.completed.pdf', compact('report'));

        // Mengunduh PDF
        return $pdf->stream("Laporan_{$ticket_number}.pdf");
    }
}
