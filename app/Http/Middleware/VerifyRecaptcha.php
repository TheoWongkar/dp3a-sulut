<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $action = 'general'): Response
    {
        $token = $request->input('recaptcha_token');

        if (!$token) {
            return back()->withErrors(['recaptcha' => 'Token reCAPTCHA tidak ditemukan.']);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ])->json();

        if (
            !$response['success'] ||
            $response['score'] < 0.5 ||
            ($response['action'] !== $action)
        ) {
            return back()->withErrors(['recaptcha' => 'Verifikasi reCAPTCHA gagal.']);
        }

        return $next($request);
    }
}
