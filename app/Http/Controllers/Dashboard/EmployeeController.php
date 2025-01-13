<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Karyawan";

        $validated = $request->validate([
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        $employees = Employee::with(['user', 'posts', 'reports'])
            ->withTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                if ($status == 'active') {
                    return $query->whereNull('deleted_at');
                } elseif ($status == 'inactive') {
                    return $query->onlyTrashed();
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
        $validated = $request->validate([
            'nip' => 'required|string|max:255|unique:employees',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'position' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|in:user,admin,operator',
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('employees', 'public');
            $validated['picture'] = $imagePath;
        } else {
            $imagePath = null;
        }

        // Menyimpan data employee
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

        // Menyimpan data user dengan nama yang diambil dari username
        $employee->user()->create([
            'role' => $validated['role'],
            'name' => $validated['username'],  // Menggunakan username untuk kolom name
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
        $title = "Karyawan" . $nip;

        $employee = Employee::with(['user', 'posts', 'reports'])->withTrashed()->where('nip', $nip)->firstOrFail();

        return view('dashboard.employee.show', compact('title', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nip)
    {
        $employee = Employee::where('nip', $nip)->firstOrFail();

        if (!$employee) {
            return redirect()->route('dashboard.employees.index')
                ->with('error', 'Karyawan tidak ditemukan.');
        }

        $employee->delete();

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
