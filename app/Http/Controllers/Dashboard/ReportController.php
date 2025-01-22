<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Reporter;
use App\Models\Perpetrator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Judul Halaman
        $title = "Tambah Laporan";

        return view('dashboard.report.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'violence_category' => 'required|string|max:255',
            'chronology' => 'required|string|max:255',
            'date' => 'required|date',
            'scene' => 'required|string|max:255',
            'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

            'victim_name' => 'required|string|max:255',
            'victim_phone' => 'required|string|max:13',
            'victim_address' => 'required|string|max:255',
            'victim_age' => 'required|integer|min:0',
            'victim_gender' => 'required|string|in:Pria,Wanita',
            'victim_description' => 'nullable|string|max:255',

            'perpetrator_name' => 'nullable|string|max:255',
            'perpetrator_age' => 'nullable|integer|min:0',
            'perpetrator_gender' => 'required|string|in:Pria,Wanita',
            'perpetrator_description' => 'nullable|string|max:255',

            'reporter_name' => 'nullable|string|max:255',
            'reporter_phone' => 'nullable|string|max:13',
            'reporter_address' => 'nullable|string|max:255',
            'reporter_relationship_between' => 'required|string|max:255',
        ]);

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
            'chronology' => $validated['chronology'],
            'date' => $validated['date'],
            'scene' => $validated['scene'],
            'evidence' => $validated['evidence'],
        ]);

        // Simpan Data Korban
        $victim = Victim::create([
            'report_id' => $report->id,
            'name' => $validated['victim_name'],
            'phone' => $validated['victim_phone'],
            'address' => $validated['victim_address'],
            'age' => $validated['victim_age'],
            'gender' => $validated['victim_gender'],
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Simpan Data Pelaku
        Perpetrator::create([
            'report_id' => $report->id,
            'name' => $validated['perpetrator_name'] ?? null,
            'age' => $validated['perpetrator_age'] ?? null,
            'gender' => $validated['perpetrator_gender'],
            'description' => $validated['perpetrator_description'] ?? null,
        ]);

        // Simpan Data Pelapor
        Reporter::create([
            'report_id' => $report->id,
            'name' => $validated['reporter_name'] ?? null,
            'phone' => $validated['reporter_phone'] ?? null,
            'address' => $validated['reporter_address'] ?? null,
            'relationship_between' => $validated['reporter_relationship_between'],
        ]);

        // Simpan Data Status
        Status::create([
            'report_id' => $report->id,
        ]);

        return redirect()->route('dashboard.reports.create')->with('success', $ticket_number);
    }

    /**
     * Display a listing of the resource.
     */
    public function received(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:50',
        ]);

        // Ambil Nilai
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Ambil Semua Laporan Diterima
        $reports = Report::with('latestStatus')
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diterima');
            })
            ->when($start_date, function ($query, $start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query, $end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('ticket_number', 'like', "%$search%")
                        ->orWhere('violence_category', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Judul Halaman
        $title = 'Diterima';

        return view('dashboard.report.received', compact('title', 'reports', 'start_date', 'end_date', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function receivedShow(string $ticket_number)
    {

        // Ambil Data Berdasarkan Nomor Tiket Serta Statusnya
        $report = Report::with(['victim', 'perpetrator', 'reporter'])->where('ticket_number', $ticket_number)->firstOrFail();

        // Judul Halaman
        $title = "Laporan: " . $ticket_number;

        return view('dashboard.report.verification', compact('title', 'report'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function receivedVerification(string $ticket_number)
    {
        // Ambil Data Berdasarkan Nomor Tiket
        $report = Report::where('ticket_number', $ticket_number)->firstOrFail();

        // Cek apakah laporan sudah memiliki status "Diproses"
        $existingStatus = $report->statuses()->where('status', 'Diproses')->first();
        if ($existingStatus) {
            return redirect()->to(route('dashboard.reports.received-show', $report->ticket_number) . '#status-update')
                ->with('error', 'Laporan ini sudah diverifikasi sebelumnya.');
        }

        // Tambahkan Status
        $report->statuses()->create([
            'report_id' => $report->id,
            'status' => 'Diproses',
            'description' => 'Laporan telah disetujui admin',
        ]);

        return redirect()->to(route('dashboard.reports.received-show', $report->ticket_number) . '#status-update')
            ->with('success', 'Laporan berhasil diverifikasi dan status diperbarui.');
    }

    /**
     * Display a listing of the resource.
     */
    public function processed(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:10',
        ]);

        // Ambil Nilai
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Ambil Semua Laporan Diterima
        $reports = Report::with('latestStatus')
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'Diproses');
            })
            ->when($start_date, function ($query, $start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query, $end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('ticket_number', 'like', "%$search%")
                        ->orWhere('violence_category', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Judul Halaman
        $title = 'Diproses';

        return view('dashboard.report.processed', compact('title', 'reports', 'start_date', 'end_date', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function processedShow(string $ticket_number)
    {
        // Ambil Data Berdasarkan Nomor Tiket Serta Statusnya
        $report = Report::with(['statuses', 'victim', 'perpetrator', 'reporter'])->where('ticket_number', $ticket_number)->firstOrFail();

        // Judul Halaman
        $title = "Laporan: " . $ticket_number;

        return view('dashboard.report.status-update', compact('title', 'report'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function processedUpdate(Request $request, string $ticket_number)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Ambil Data Berdasarkan Nomor Tiket
        $report = Report::with(['statuses', 'victim', 'perpetrator', 'reporter'])->where('ticket_number', $ticket_number)->firstOrFail();

        // Cek apakah status terakhir adalah "Selesai" atau "Dibatalkan"
        $lastStatus = $report->statuses->last(); // Mengambil status terakhir
        if ($lastStatus && in_array($lastStatus->status, ['Selesai', 'Dibatalkan'])) {
            return redirect()->route('dashboard.reports.processed-show', ['ticket_number' => $ticket_number])
                ->with('error', 'Status tidak bisa ditambahkan karena laporan sudah selesai atau dibatalkan.');
        }

        // Isi Data Ditangani Oleh
        if (!$report->employee_id) {
            $user = Auth::user();

            if ($user && $user->employee_id) {
                $report->employee_id = $user->employee_id;
                $report->save();
            }
        }

        // Isi Data Status
        $report->statuses()->create([
            'report_id' => $report->id,
            'status' => $validatedData['status'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->to(route('dashboard.reports.processed-show', $report->ticket_number) . '#status-update')
            ->with('success', 'Status berhasil ditambahkan.');
    }

    /**
     * Display a listing of the resource.
     */
    public function completed(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|in:Semua,Selesai,Dibatalkan',
        ]);

        // Ambil Nilai
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        // Ambil Semua Laporan Diterima
        $reports = Report::with('latestStatus')
            ->whereHas('latestStatus', function ($query) use ($status) {
                $query->where(function ($query) use ($status) {
                    if ($status) {
                        $query->where('status', $status); // Filter berdasarkan status jika dipilih
                    } else {
                        $query->whereIn('status', ['Selesai', 'Dibatalkan']); // Default filter
                    }
                });
            })
            ->when($start_date, function ($query, $start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query, $end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('ticket_number', 'like', "%$search%")
                        ->orWhere('violence_category', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Judul Halaman
        $title = 'Selesai';

        return view('dashboard.report.completed', compact('title', 'reports', 'start_date', 'end_date', 'search', 'status'));
    }

    /**
     * Display the specified resource.
     */
    public function completedShow(string $ticket_number)
    {
        // Ambil Data Berdasarkan Nomor Tiket Serta Statusnya
        $report = Report::with(['victim', 'perpetrator', 'reporter'])->where('ticket_number', $ticket_number)->firstOrFail();

        // Judul Halaman
        $title = "Laporan: " . $ticket_number;

        return view('dashboard.report.show', compact('title', 'report'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticket_number)
    {
        // Ambil Data Berdasarkan Nomor Tiket
        $report = Report::where('ticket_number', $ticket_number)->firstOrFail();

        // Laporan Tidak Ditemukan
        if (!$report) {
            return redirect()->route('dashboard.reports.index')
                ->with('error', 'Laporan tidak ditemukan.');
        }

        // Hapus Data Laporan
        $report->delete();

        return redirect()->route('dashboard.reports.completed')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
