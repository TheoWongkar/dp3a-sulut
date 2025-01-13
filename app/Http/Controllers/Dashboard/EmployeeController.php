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

        $validated = $request->validate([
            'search' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

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

        $employee = Employee::with(['user', 'posts', 'reports'])->where('nip', $nip)->firstOrFail();

        return view('dashboard.employee.show', compact('title', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nip)
    {
        $title = "Ubah Karyawan " . $nip;

        $employee = Employee::with('user')->where('nip', $nip)->firstOrFail();

        return view('dashboard.employee.edit', compact('title', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nip)
    {
        $employee = Employee::where('nip', $nip)->firstOrFail();

        $validated = $request->validate([
            'nip' => 'required|string|max:255|unique:employees,nip,' . $nip . ',nip',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'position' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:13',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|in:user,admin,operator',
            'username' => 'required|string|max:255|unique:users,name,' . $employee->user->name . ',name',
            'email' => 'required|email|max:255|unique:users,email,' . $employee->user->email . ',email',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ]);


        if ($request->hasFile('picture')) {
            if ($employee->picture) {
                Storage::disk('public')->delete($employee->picture);
            }

            $imagePath = $request->file('picture')->store('employees', 'public');
            $validated['picture'] = $imagePath;
        }

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

        $employee->user->update([
            'role' => $validated['role'],
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $employee->user->password,
        ]);

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
