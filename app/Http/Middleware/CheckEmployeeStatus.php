<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Employee;
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
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $employee = Employee::where('user_id', Auth::id())->first();

            if ($employee && $employee->status === 'Nonaktif') {
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Silahkan hubungi admin.']);
            }
        }

        return $next($request);
    }
}
