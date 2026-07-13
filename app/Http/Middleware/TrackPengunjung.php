<?php

namespace App\Http\Middleware;

use App\Models\Pengunjung;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPengunjung
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya catat kunjungan ke halaman publik (pakta), bukan admin/asset
        if ($request->is('pakta') || $request->is('/')) {
            Pengunjung::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'halaman' => $request->path(),
            ]);
        }

        return $next($request);
    }
}