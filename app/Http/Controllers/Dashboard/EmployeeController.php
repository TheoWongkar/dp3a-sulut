<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'status' => 'nullable|string|in:1,0,all',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:50',
        ]);

        // Ambil Nilai
        $status = $validated['status'] ?? 'all';
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Karyawan Dengan Data Berita dan Laporan
        $employees = Employee::with(['posts', 'reports'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nip', 'LIKE', "{$search}%")
                        ->orWhere('gender', 'LIKE', "{$search}");
                });
            })
            ->when($status !== 'all', function ($query) use ($status) {
                if (is_numeric($status)) {
                    return $query->where('status', (bool) $status);
                }
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);

        // Judul Halaman
        $title = "Karyawan";

        return view('dashboard.employee.index', compact('title', 'employees', 'status', 'start_date', 'end_date', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Employee $employee)
    {
        // Judul Halaman
        $title = "Tambah Karyawan";

        // Cek Izin
        if (! Gate::allows('create-employee', $employee)) {
            abort(403);
        }

        return view('dashboard.employee.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate(
            [
                'nip' => 'required|string|min:15|max:18|unique:employees',
                'name' => 'required|string|min:3|max:255',
                'gender' => 'required|string|in:Pria,Wanita',
                'position' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'address' => 'required|string|max:255',
                'phone' => 'nullable|string|max:13',
                'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'role' => 'required|string|in:Petugas,Admin,Developer',
                'username' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|min:3|max:255|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:255',
                    'confirmed',
                    'regex:/[0-9]/',
                ],
            ],
            [
                'password.regex' => 'Kata sandi harus mengandung setidaknya satu angka.',
            ]
        );

        // Simpan Gambar (jika ada)
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('employees', 'public');
            $validated['picture'] = $imagePath;
        } else {
            $validated['picture'] = null;
        }

        // Simpan Data Karyawan
        $employee = Employee::create([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'picture' => $validated['picture'],
        ]);

        // Simpan Data User
        $employee->user()->create([
            'role' => $validated['role'],
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('dashboard.employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::with(['user', 'posts', 'reports'])->where('nip', $nip)->firstOrFail();

        // Cek Izin
        if (! Gate::allows('show-employee', $employee)) {
            abort(403);
        }

        // Judul Halaman
        $title = "Karyawan: " . $employee->name;

        return view('dashboard.employee.show', compact('title', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::with('user')->where('nip', $nip)->firstOrFail();

        // Cek Izin
        if (! Gate::allows('update_delete-employee', $employee)) {
            abort(403);
        }

        // Judul Halaman
        $title = "Ubah Karyawan: " . $employee->name;

        return view('dashboard.employee.edit', compact('title', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Validasi Input
        $validated = $request->validate(
            [
                'nip' => 'required|string|min:15|max:18|unique:employees,nip,' . $nip . ',nip',
                'name' => 'required|string|min:3|max:255',
                'gender' => 'required|string|in:Pria,Wanita',
                'position' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'address' => 'required|string|max:255',
                'phone' => 'nullable|string|max:13',
                'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => 'required|boolean',
                'role' => 'required|string|in:Petugas,Admin,Developer',
                'username' => 'required|string|max:255|unique:users,name,' . $employee->user->name . ',name',
                'email' => 'required|email|min:3|max:255|unique:users,email,' . $employee->user->email . ',email',
                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'max:255',
                    'confirmed',
                    'regex:/[0-9]/',
                ],
            ],
            [
                'password.regex' => 'Kata sandi harus mengandung setidaknya satu angka.',
            ]
        );

        // Simpan Gambar (jika ada)
        if ($request->hasFile('picture')) {
            if ($employee->picture) {
                Storage::disk('public')->delete($employee->picture);
            }
            $filePath = $request->file('picture')->store('employees', 'public');
            $validated['picture'] = $filePath;
        }

        // Ubah Data Karyawan
        $employee->update([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'phone' => $validated['phone'] ?? $employee->phone,
            'picture' => $validated['picture'] ?? $employee->picture,
            'status' => $validated['status'],
        ]);

        // Ubah Data Karyawan
        $employee->user->update([
            'role' => $validated['role'],
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $employee->user->password,
        ]);

        return redirect()->route('dashboard.employees.index')->with('success', 'Karyawan berhasil diubah.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Data Karyawan Tidak Ditemukan
        if (!$employee) {
            return redirect()->route('dashboard.employees.index')
                ->with('error', 'Karyawan tidak ditemukan.');
        }

        // Cek Izin
        if (! Gate::allows('update_delete-employee', $employee)) {
            abort(403);
        }

        // Hapus Data Karyawan
        $employee->delete();

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
