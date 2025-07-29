<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Report;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request, string $status)
    {
        // Validasi status supaya hanya yang diizinkan
        $statusMap = [
            'diterima' => 'Diterima',
            'menunggu-verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        abort_unless(isset($statusMap[$status]), 404);
        $statusMapped = $statusMap[$status];

        // Validasi Search Form
        $validated = $request->validate([
            'violence_category' => 'nullable|string|in:Fisik,Psikis,Seksual,Penelantaran,Eksploitasi,Lainnya',
            'victim_gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'suspect_gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $violence_category = $validated['violence_category'] ?? null;
        $victim_gender = $validated['victim_gender'] ?? null;
        $suspect_gender = $validated['suspect_gender'] ?? null;
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Ambil Laporan Dengan Data Korban, Terduga, dan Status Terakhir
        $reports = Report::with(['victim', 'suspect', 'latestStatus'])
            ->whereHas('latestStatus', function ($query) use ($statusMapped) {
                $query->where('status', $statusMapped);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('ticket_number', 'LIKE', "%{$search}%")
                        ->orWhere('regency', 'LIKE', "%{$search}%")
                        ->orWhere('district', 'LIKE', "%{$search}%");
                });
            })
            ->when($victim_gender, function ($query) use ($victim_gender) {
                $query->whereHas('victim', function ($q) use ($victim_gender) {
                    $q->where('gender', $victim_gender);
                });
            })
            ->when($suspect_gender, function ($query) use ($suspect_gender) {
                $query->whereHas('suspect', function ($q) use ($suspect_gender) {
                    $q->where('gender', $suspect_gender);
                });
            })
            ->when($violence_category, function ($query) use ($violence_category) {
                $query->where('violence_category', $violence_category);
            })
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('dashboard.reports.index', compact('reports', 'status', 'statusMapped'));
    }

    public function create()
    {
        return view('dashboard.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Reporter
            'reporter_nik' => 'nullable|digits:16',
            'reporter_name' => 'required|string|max:255',
            'reporter_phone' => 'required|string|max:20',
            'reporter_address' => 'required|string',
            'reporter_age' => 'required|integer',
            'reporter_gender' => 'required|in:Laki-laki,Perempuan',
            'reporter_relationship_between' => 'required|in:Diri Sendiri,Orang Tua,Saudara,Guru,Teman,Lainnya',

            // Step 2: Victim
            'victim_nik' => 'nullable|digits:16',
            'victim_name' => 'required|string|max:255',
            'victim_phone' => 'required|string|max:20',
            'victim_address' => 'required|string',
            'victim_age' => 'required|integer',
            'victim_gender' => 'required|in:Laki-laki,Perempuan',
            'victim_description' => 'nullable|string',

            // Step 3: Suspect
            'suspect_nik' => 'nullable|digits:16',
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
            $evidencePath = $request->file('evidence')->store('reports', 'public');
            $report->update(['evidence' => $evidencePath]);
        }

        // Simpan Reporter
        $report->reporter()->create([
            'name' => $validated['reporter_name'],
            'nik' => $validated['reporter_nik'] ?? null,
            'phone' => $validated['reporter_phone'],
            'gender' => $validated['reporter_gender'],
            'relationship_between' => $validated['reporter_relationship_between'],
            'address' => $validated['reporter_address'] ?? null,
            'age' => $validated['reporter_age'] ?? null,
        ]);

        // Simpan Korban
        $report->victim()->create([
            'name' => $validated['victim_name'],
            'nik' => $validated['victim_nik'] ?? null,
            'gender' => $validated['victim_gender'],
            'age' => $validated['victim_age'] ?? null,
            'phone' => $validated['victim_phone'] ?? null,
            'address' => $validated['victim_address'] ?? null,
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Simpan Terduga
        $report->suspect()->create([
            'name' => $validated['suspect_name'],
            'nik' => $validated['suspect_nik'] ?? null,
            'gender' => $validated['suspect_gender'],
            'age' => $validated['suspect_age'] ?? null,
            'phone' => $validated['suspect_phone'] ?? null,
            'address' => $validated['suspect_address'] ?? null,
            'description' => $validated['suspect_description'] ?? null,
        ]);

        // Simpan Status
        $report->statuses()->create([
            'changed_by' => Auth::id(),
            'status' => 'Diterima',
            'description' => 'Laporan telah diterima. Petugas kami akan segera menghubungi Anda.',
        ]);

        return redirect()->route('dashboard.report.create')->with([
            'success' => 'Laporan berhasil dikirim!',
            'ticket_number' => $ticketNumber,
        ]);
    }

    public function edit(string $status, string $ticket_number)
    {
        // Validasi status supaya hanya yang diizinkan
        $statusMap = [
            'diterima' => 'Diterima',
            'menunggu-verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        abort_unless(isset($statusMap[$status]), 404);
        $statusMapped = $statusMap[$status];

        // Ambil laporan berdasarkan nomor tiket
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses', 'statuses.changedBy.employee'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Cek status terakhir sesuai dengan dipilih
        if ($report->latestStatus->status !== $statusMapped) {
            abort(403);
        }

        // Beri halaman sesuai status
        switch ($statusMapped) {
            case 'Diterima':
                return view('dashboard.reports.received.edit', compact('report'));

            case 'Menunggu Verifikasi':
                return view('dashboard.reports.waiting-verification.edit', compact('report'));

            case 'Diproses':
                return view('dashboard.reports.processed.edit', compact('report'));

            case 'Selesai':
                return view('dashboard.reports.completed.edit', compact('report'));

            case 'Dibatalkan':
                return view('dashboard.reports.canceled.edit', compact('report'));

            default:
                abort(404);
        }
    }

    public function receivedUpdate(Request $request, string $status, string $ticket_number)
    {
        // Validasi status supaya hanya yang diizinkan
        $statusMap = [
            'diterima' => 'Diterima',
            'menunggu-verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        abort_unless(isset($statusMap[$status]), 404);
        $statusMapped = $statusMap[$status];

        // Ambil laporan berdasarkan nomor tiket
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Cek status terakhir sesuai dengan dipilih
        if ($report->latestStatus->status !== $statusMapped) {
            abort(403);
        }

        // Jika tombol cancle dipilih
        if ($request->action === 'cancel') {
            $report->statuses()->create([
                'changed_by' => Auth::id(),
                'status' => 'Dibatalkan',
                'description' => 'Laporan telah dibatalkan karena alasan tertentu.',
            ]);

            return redirect()->route('dashboard.report.index', 'diterima')->with('success', 'Laporan berhasil dibatalkan, status telah diperbarui ke "Dibatalkan".');
        }

        // Jika tombol save dipilih
        $validated = $request->validate([
            // Step 1: Reporter
            'reporter_nik' => 'nullable|digits:16',
            'reporter_name' => 'required|string|max:255',
            'reporter_phone' => 'required|string|max:20',
            'reporter_address' => 'required|string',
            'reporter_age' => 'required|integer',
            'reporter_gender' => 'required|in:Laki-laki,Perempuan',
            'reporter_relationship_between' => 'required|in:Diri Sendiri,Orang Tua,Saudara,Guru,Teman,Lainnya',

            // Step 2: Victim
            'victim_nik' => 'nullable|digits:16',
            'victim_name' => 'required|string|max:255',
            'victim_phone' => 'required|string|max:20',
            'victim_address' => 'required|string',
            'victim_age' => 'required|integer',
            'victim_gender' => 'required|in:Laki-laki,Perempuan',
            'victim_description' => 'nullable|string',

            // Step 3: Suspect
            'suspect_nik' => 'nullable|digits:16',
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
        ]);

        // Update Laporan
        $report->update([
            'violence_category' => $validated['violence_category'],
            'incident_date' => $validated['incident_date'],
            'regency' => $validated['regency'],
            'district' => $validated['district'],
            'scene' => $validated['scene'],
            'chronology' => $validated['chronology'] ?? null,
        ]);

        // Simpan file evidence jika ada
        if ($request->hasFile('evidence')) {
            if ($report->evidence && Storage::disk('public')->exists($report->evidence)) {
                Storage::disk('public')->delete($report->evidence);
            }
            $evidencePath = $request->file('evidence')->store('reports', 'public');
            $report->update(['evidence' => $evidencePath]);
        }

        // Simpan Reporter
        $report->reporter->update([
            'name' => $validated['reporter_name'],
            'nik' => $validated['reporter_nik'] ?: null,
            'phone' => $validated['reporter_phone'],
            'gender' => $validated['reporter_gender'],
            'relationship_between' => $validated['reporter_relationship_between'],
            'address' => $validated['reporter_address'] ?: null,
            'age' => $validated['reporter_age'] ?? null,
        ]);

        // Simpan Korban
        $report->victim->update([
            'name' => $validated['victim_name'],
            'nik' => $validated['victim_nik'] ?: null,
            'gender' => $validated['victim_gender'],
            'age' => $validated['victim_age'] ?? null,
            'phone' => $validated['victim_phone'] ?? null,
            'address' => $validated['victim_address'] ?: null,
            'description' => $validated['victim_description'] ?? null,
        ]);

        // Simpan Terduga
        $report->suspect->update([
            'name' => $validated['suspect_name'] ?? null,
            'nik' => $validated['suspect_nik'] ?: null,
            'gender' => $validated['suspect_gender'],
            'age' => $validated['suspect_age'] ?? null,
            'phone' => $validated['suspect_phone'] ?? null,
            'address' => $validated['suspect_address'] ?: null,
            'description' => $validated['suspect_description'] ?? null,
        ]);

        // Cek kelengkapan field
        $requiredFields = [
            $report->reporter->getRawOriginal('nik'),
            $report->reporter->name,
            $report->reporter->phone,
            $report->reporter->getRawOriginal('address'),
            $report->reporter->age,
            $report->reporter->gender,
            $report->reporter->relationship_between,

            $report->victim->getRawOriginal('nik'),
            $report->victim->name,
            $report->victim->phone,
            $report->victim->getRawOriginal('address'),
            $report->victim->age,
            $report->victim->gender,

            $report->suspect->getRawOriginal('nik'),
            $report->suspect->name,
            $report->suspect->phone,
            $report->suspect->getRawOriginal('address'),
            $report->suspect->age,
            $report->suspect->gender,

            $report->incident_date,
            $report->violence_category,
            $report->regency,
            $report->district,
            $report->scene,
            $report->chronology,
        ];

        $isComplete = !in_array(null, $requiredFields, true);

        // Buat status jika semua lengkap
        if ($isComplete) {
            $report->statuses()->create([
                'changed_by' => Auth::id(),
                'status' => 'Menunggu Verifikasi',
                'description' => 'Laporan dinyatakan lengkap dan sedang menunggu verifikasi admin.',
            ]);

            return redirect()->route('dashboard.report.index', 'diterima')->with('success', 'Laporan berhasil dilengkapi, status telah diperbarui ke "Menunggu Verifikasi".');
        }

        return redirect()->back()->with('success', 'laporan berhasil diperbarui, lengkapi semua data untuk melanjutkan ke tahap verifikasi.');
    }

    public function waitingVerificationUpdate(Request $request, string $status, string $ticket_number)
    {
        // Validasi status supaya hanya yang diizinkan
        $statusMap = [
            'diterima' => 'Diterima',
            'menunggu-verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        abort_unless(isset($statusMap[$status]), 404);
        $statusMapped = $statusMap[$status];

        // Ambil laporan berdasarkan nomor tiket
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Cek status terakhir sesuai dengan dipilih
        if ($report->latestStatus->status !== $statusMapped) {
            abort(403);
        }

        // Jika tombol cancle dipilih
        if ($request->action === 'cancel') {
            $report->statuses()->create([
                'changed_by' => Auth::id(),
                'status' => 'Dibatalkan',
                'description' => 'Laporan telah dibatalkan karena alasan tertentu.',
            ]);

            return redirect()->route('dashboard.report.index', 'menunggu-verifikasi')->with('success', 'Laporan berhasil dibatalkan, status telah diperbarui ke "Dibatalkan".');
        }

        // Buat status jika semua lengkap
        $report->statuses()->create([
            'changed_by' => Auth::id(),
            'status' => 'Diproses',
            'description' => 'Laporan berhasil diverifikasi dan sedang dalam proses penanganan.',
        ]);

        return redirect()->route('dashboard.report.index', 'menunggu-verifikasi')->with('success', 'Laporan berhasil diverifikasi, status telah diperbarui ke "Diproses".');
    }

    public function processedUpdate(Request $request, string $status, string $ticket_number)
    {
        // Validasi status supaya hanya yang diizinkan
        $statusMap = [
            'diterima' => 'Diterima',
            'menunggu-verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        abort_unless(isset($statusMap[$status]), 404);
        $statusMapped = $statusMap[$status];

        // Ambil laporan berdasarkan nomor tiket
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Cek status terakhir sesuai dengan dipilih
        if ($report->latestStatus->status !== $statusMapped) {
            abort(403);
        }

        // Validasi Input
        $validated = $request->validate([
            'status' => 'required|string|in:Diproses,Selesai,Dibatalkan',
            'description' => 'required|string',
        ]);

        // Buat status
        $report->statuses()->create([
            'changed_by' => Auth::id(),
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        if ($validated['status'] == 'Selesai') {
            return redirect()->route('dashboard.report.index', 'diproses')->with('success', 'Laporan telah diselesaikan, status telah diperbarui ke "Selesai".');
        } else if ($validated['status'] == 'Dibatalkan') {
            return redirect()->route('dashboard.report.index', 'diproses')->with('success', 'Laporan berhasil dibatalkan, status telah diperbarui ke "Dibatalkan".');
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function completedPdf($status, $ticket_number)
    {
        // Ambil data laporan
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Buat PDF dari view Blade
        $pdf = Pdf::loadView('dashboard.reports.completed.pdf', compact('report'));

        // Stream PDF ke browser (hanya tampil, tidak download otomatis)
        return $pdf->stream('Laporan-' . $ticket_number . '.pdf');
    }

    public function destroy(string $status, string $ticket_number)
    {
        // Validasi status supaya hanya yang diizinkan
        $statusMap = [
            'diterima' => 'Diterima',
            'menunggu-verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        abort_unless(isset($statusMap[$status]), 404);
        $statusMapped = $statusMap[$status];

        // Ambil laporan berdasarkan nomor tiket
        $report = Report::with(['victim', 'suspect', 'reporter', 'statuses'])
            ->where('ticket_number', $ticket_number)->firstOrFail();

        // Hapus file evidence jika ada
        if ($report->evidence && Storage::disk('public')->exists($report->evidence)) {
            Storage::disk('public')->delete($report->evidence);
        }

        // Hapus report
        $report->delete();

        return redirect()->route('dashboard.report.index', $status)->with('success', 'Laporan berhasil dihapus.');
    }
}
