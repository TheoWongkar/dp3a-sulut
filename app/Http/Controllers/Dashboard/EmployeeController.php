<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'status' => 'nullable|string|in:Aktif,Nonaktif,all',
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
        $employees = Employee::with(['user.posts', 'user.reports'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nip', 'LIKE', "{$search}%")
                        ->orWhere('gender', 'LIKE', "{$search}");
                });
            })
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);

        // Cek Izin
        if (! Gate::allows('crud-employee', $employees)) {
            abort(403);
        }

        // Judul Halaman
        $title = "Karyawan";

        return view('dashboard.employee.index', compact('title', 'employees', 'status', 'start_date', 'end_date', 'search'));
    }

    public function create(Employee $employee)
    {
        // Judul Halaman
        $title = "Tambah Karyawan";

        // Cek Izin
        if (! Gate::allows('crud-employee', $employee)) {
            abort(403);
        }

        return view('dashboard.employee.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'nip' => 'required|digits:18|unique:employees',
            'name' => 'required|string|min:3|max:255',
            'gender' => 'required|string|in:Pria,Wanita',
            'position' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|numeric|digits_between:10,13',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'required|string|in:Petugas,Admin',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|min:3|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                'regex:/[0-9]/',
            ],
        ], [
            'password.regex' => 'Kata sandi harus mengandung setidaknya satu angka.',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Simpan Gambar (jika ada)
        if ($request->hasFile('avatar')) {
            $filePath = $request->file('avatar')->store('employees', 'public');
        } else {
            $filePath = null;
        }

        Employee::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'avatar' => $filePath,
        ]);

        return redirect()->route('dashboard.employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::with(['user', 'user.posts', 'user.reports'])->where('nip', $nip)->firstOrFail();

        // Cek Izin
        if (! Gate::allows('crud-employee', $employee)) {
            abort(403);
        }

        // Judul Halaman
        $title = "Karyawan: " . $employee->name;

        return view('dashboard.employee.show', compact('title', 'employee'));
    }

    public function edit(string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::with('user')->where('nip', $nip)->firstOrFail();

        // Cek Izin
        if (! Gate::allows('crud-employee', $employee)) {
            abort(403);
        }

        // Judul Halaman
        $title = "Ubah Karyawan: " . $employee->name;

        return view('dashboard.employee.edit', compact('title', 'employee'));
    }

    public function update(Request $request, string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Cek Izin
        if (! Gate::allows('crud-employee', $employee)) {
            abort(403);
        }

        // Validasi Input
        $validated = $request->validate([
            'nip' => 'required|digits:18|unique:employees,nip,' . $nip . ',nip',
            'name' => 'required|string|min:3|max:255',
            'gender' => 'required|string|in:Pria,Wanita',
            'position' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'status' => 'required|string|in:Aktif,Nonaktif',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|numeric|digits_between:10,13',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'required|string|in:Petugas,Admin',
            'username' => 'required|string|max:255|unique:users,username,' . $employee->user->username . ',username',
            'email' => 'required|email|min:3|max:255|unique:users,email,' . $employee->user->email . ',email',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                'regex:/[0-9]/',
            ],
        ], [
            'password.regex' => 'Kata sandi harus mengandung setidaknya satu angka.',
        ]);

        // Update User
        $user = $employee->user;
        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Update Password jika ada
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Simpan Gambar (jika ada perubahan)
        if ($request->hasFile('avatar')) {
            // Hapus gambar lama jika ada
            if ($employee->avatar) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $filePath = $request->file('avatar')->store('employees', 'public');
        } else {
            $filePath = $employee->avatar;
        }

        // Update Employee
        $employee->update([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'status' => $validated['status'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'avatar' => $filePath,
        ]);

        return redirect()->route('dashboard.employees.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(string $nip)
    {
        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Cek Izin
        if (! Gate::allows('crud-employee', $employee)) {
            abort(403);
        }

        // Hapus Gambar Jika Ada
        if ($employee->avatar) {
            Storage::disk('public')->delete($employee->avatar);
        }

        // Ambil User ID terkait
        $user = $employee->user;

        // Hapus Data User
        if ($user) {
            $user->delete();
        }

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
