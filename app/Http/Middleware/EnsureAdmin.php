<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! $request->user()->isAdmin()) {
            if ($request->user()->isKasir()) {
                return redirect()->route('admin.services.index')->with('error', 'Akses ditolak. Fitur kelola tarif dan master layanan hanya dapat dilakukan oleh Administrator.');
            }

            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman tersebut hanya untuk administrator.');
        }

        return $next($request);
    }
}
