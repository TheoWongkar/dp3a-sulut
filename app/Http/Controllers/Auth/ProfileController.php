<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        // Ambil Data Pengguna
        $user = Auth::user();
        $employee = $user->employee;

        // Judul Halaman
        $title = "Karyawan: " . $employee->name;

        return view('profile.show', compact('title', 'employee'));
    }

    public function edit()
    {
        // Ambil Data Pengguna
        $user = Auth::user();
        $employee = $user->employee;

        // Judul Halaman
        $title = "Karyawan: " . $employee->name;

        return view('profile.edit', compact('title', 'employee'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:3|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->employee && $user->employee->avatar) {
                Storage::disk('public')->delete($user->employee->avatar);
            }
            $filePath = $request->file('avatar')->store('employees', 'public');
            $validated['avatar'] = $filePath;
        }

        // Update user data
        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        // Update employee profile (if exists)
        if ($user->employee) {
            $user->employee->update([
                'avatar' => $validated['avatar'] ?? $user->employee->avatar,
            ]);
        }

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate(
            [
                'current_password' => 'required|string|max:255',
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

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak valid.']);
        }

        // Update password
        $user->update(['password' => Hash::make($validated['password'])]);

        // Logout user after password change
        Auth::logout();

        return redirect()->route('profile.edit')->with('status', 'password-updated');
    }
}
