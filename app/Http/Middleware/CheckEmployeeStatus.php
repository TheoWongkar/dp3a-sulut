<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployeeStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah user terhubung ke employee dan apakah statusnya aktif
        if ($user && $user->employee && !$user->employee->status) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'message' => __('Akun anda dinonaktifkan. Mohon untuk menghubungi admin.'),
            ])->onlyInput('email');
        }

        return $next($request);
    }
}
