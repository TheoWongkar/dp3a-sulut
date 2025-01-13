<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $nip)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nip)
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
