<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $title = "Karyawan " . Auth::user()->name;

        // Ambil Data Pengguna
        $user = Auth::user();

        return view('profile.edit', compact('title', 'user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        // Ambil Data Pengguna
        $user = Auth::user();

        // Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan Gambar (jika ada)
        if ($request->hasFile('picture')) {
            if ($user->employee->picture) {
                Storage::disk('public')->delete($user->employee->picture);
            }
            $filePath = $request->file('picture')->store('employees', 'public');
            $validated['picture'] = $filePath;
        }

        // Update Data Pengguna
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update Profile Pengguna
        $user->employee->update([
            'picture' => $validated['picture'] ?? $user->employee->picture,
        ]);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function updatePassword(Request $request)
    {
        // Ambil Data Pengguna
        $user = Auth::user();

        // Validasi Input
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cek Kata Sandi
        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak valid.']);
        }

        // Update kata sandi
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Logout Pengguna
        Auth::logout();

        return redirect()->route('profile.edit')->with('status', 'password-updated');
    }
}