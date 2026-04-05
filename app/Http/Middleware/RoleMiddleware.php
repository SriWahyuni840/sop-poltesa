<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage:
     * ->middleware('role:unit')
     * ->middleware('role:admin_p2mpp')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Kalau belum login
        if (!session()->has('user_id') || !session()->has('role')) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Kalau role tidak sesuai
        if (session('role') !== $role) {
            return redirect()
                ->route('login')
                ->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}