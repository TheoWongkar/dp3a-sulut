<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function login(): View
    {
        // Judul Halaman
        $title = "Login";

        return view('auth.login', compact('title'));
    }

    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Google ReCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        $recaptchaVerify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
        ])->json();
        if (!$recaptchaVerify['success']) {
            return back()->withErrors([
                'g-recaptcha-response' => __('gagal verifikasi captcha, coba lagi.'),
            ])->onlyInput('email');
        }

        // Inisialisasi
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Attempt
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'message' => __('auth.failed'),
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        // Logout
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
