<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Karyawan";

        // Validasi Search Form
        $validated = $request->validate([
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        // Semua Karyawan Dengan Data Berita dan Laporan
        $employees = Employee::with(['user', 'posts', 'reports'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                if ($status == 'active') {
                    return $query->where('status', true);
                } elseif ($status == 'inactive') {
                    return $query->where('status', false);
                }
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);

        return view('dashboard.employee.index', compact('title', 'employees', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Karyawan";

        return view('dashboard.employee.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'nip' => 'required|string|max:255|unique:employees',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'position' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|in:Customer Service,Moderator,Super Admin',
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan Gambar (jika ada)
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('employees', 'public');
            $validated['picture'] = $imagePath;
        } else {
            $imagePath = null;
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
        $title = "Karyawan " . $nip;

        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::with(['user', 'posts', 'reports'])->where('nip', $nip)->firstOrFail();

        return view('dashboard.employee.show', compact('title', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nip)
    {
        $title = "Ubah Karyawan " . $nip;

        // Ambil Data Karyawan Berdasarkan NIP
        $employee = Employee::with('user')->where('nip', $nip)->firstOrFail();

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
        $validated = $request->validate([
            'nip' => 'required|string|max:255|unique:employees,nip,' . $nip . ',nip',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'position' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:13',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|in:Customer Service,Moderator,Super Admin',
            'username' => 'required|string|max:255|unique:users,name,' . $employee->user->name . ',name',
            'email' => 'required|email|max:255|unique:users,email,' . $employee->user->email . ',email',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ]);

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
        ]);

        // Ubah Data Karyawan
        $employee->user->update([
            'role' => $validated['role'],
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $employee->user->password,
        ]);

        // Set Status Karyawan
        if ($request->status == 'active') {
            // Set status menjadi true (aktif)
            if (!$employee->status) {
                $employee->status = true;
                $employee->save();
            }
        } elseif ($request->status == 'inactive') {
            // Set status menjadi false (tidak aktif)
            if ($employee->status) {
                $employee->status = false;
                $employee->save();
            }
        }

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

        // Hapus Data Karyawan
        $employee->delete();

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
