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
        // Cek Izin Akses
        Gate::authorize('viewAny', Employee::class);

        // Validasi Search Form
        $validated = $request->validate([
            'status' => 'nullable|string|in:Aktif,Pensiun,Meninggal Dunia,Diberhentikan',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $status = $validated['status'] ?? null;
        $gender = $validated['gender'] ?? null;
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Karyawan Dengan Data Berita dan Laporan
        $employees = Employee::with(['user.posts', 'user.statusChanges'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nip', 'LIKE', "{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($gender, function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('name', 'ASC')
            ->paginate(20);

        return view('dashboard.employees.index', compact('employees'));
    }

    public function create()
    {
        // Cek Izin Akses
        Gate::authorize('create', Employee::class);

        return view('dashboard.employees.create');
    }

    public function store(Request $request)
    {
        // Cek Izin Akses
        Gate::authorize('create', Employee::class);

        // Validasi Input
        $validated = $request->validate(
            [
                // Data Pegawai
                'nip' => 'required|numeric|unique:employees,nip',
                'name' => 'required|string|max:255',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'position' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'address' => 'required|string',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

                // Data User
                'username' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email:rfc,dns|max:255|unique:users,email',
                'role' => 'required|in:Admin,Petugas',
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
                'password.regex' => 'Password harus mengandung minimal 1 angka.',
            ]
        );

        // Simpan avatar (jika ada)
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('employees', 'public');
        } else {
            $avatarPath = null;
        }

        // Simpan user
        $user = User::create([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        // Simpan employee & hubungkan ke user
        $employee = Employee::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'place_of_birth' => $validated['place_of_birth'],
            'address' => $validated['address'],
            'avatar' => $avatarPath,
        ]);

        return redirect()->back()->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(string $nip)
    {
        // Ambil data pegawai berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Cek Izin Akses
        Gate::authorize('update', $employee);

        return view('dashboard.employees.edit', compact('employee'));
    }

    public function update(Request $request, string $nip)
    {
        // Ambil employee berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Cek Izin Akses
        Gate::authorize('update', $employee);

        // Validasi Input
        $validated = $request->validate(
            [
                // Data Pegawai
                'nip' => 'required|numeric|unique:employees,nip,' . $employee->id,
                'name' => 'required|string|max:255',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'position' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'address' => 'required|string',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => 'required|in:Aktif,Pensiun,Meninggal Dunia,Diberhentikan',

                // Data User
                'username' => 'required|string|max:255|unique:users,name,' . $employee->user->id,
                'email' => 'required|email:rfc,dns|max:255|unique:users,email,' . $employee->user->id,
                'role' => 'required|in:Admin,Petugas',
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
                'password.regex' => 'Password harus mengandung minimal 1 angka.',
            ]
        );

        // Update avatar jika ada file baru
        if ($request->hasFile('avatar')) {
            if ($employee->avatar) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $avatarPath = $request->file('avatar')->store('employees', 'public');
        } else {
            $avatarPath = $employee->avatar;
        }

        // Update user lewat relasi
        $employee->user->update([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $employee->user->password,
        ]);

        // Update data employee
        $employee->update([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'place_of_birth' => $validated['place_of_birth'],
            'address' => $validated['address'],
            'status' => $validated['status'],
            'avatar' => $avatarPath,
        ]);

        return redirect()->back()->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(string $nip)
    {
        // Ambil data pegawai berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Cek Izin Akses
        Gate::authorize('delete', $employee);

        // Hapus avatar jika ada
        if ($employee->avatar && Storage::disk('public')->exists($employee->avatar)) {
            Storage::disk('public')->delete($employee->avatar);
        }

        // Hapus user login terkait (jika ada relasi ke user)
        if ($employee->user) {
            $employee->user->delete();
        }

        // Hapus data pegawai
        $employee->delete();

        return redirect()->back()->with('success', 'Data pegawai berhasil dihapus.');
    }
}
