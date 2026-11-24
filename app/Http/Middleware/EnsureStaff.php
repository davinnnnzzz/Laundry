<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isStaff()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman tersebut hanya untuk staf (Admin & Kasir).');
        }

        return $next($request);
    }
}
