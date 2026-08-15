<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUmkmApproved
{
    /**
     * Blocks UMKM dashboard actions (product management, order handling)
     * until the admin has approved the UMKM profile. Profile editing itself
     * stays reachable so the owner can complete their data.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profile = $request->user()->umkmProfile;

        if (! $profile || $profile->status !== 'approved') {
            return redirect()->route('umkm.profile.edit')->with('warning',
                'Toko Anda belum disetujui oleh admin. Lengkapi profil dan tunggu persetujuan untuk mengelola produk & pesanan.');
        }

        return $next($request);
    }
}
