<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class UmkmManagementController extends Controller
{
    public function index(Request $request)
    {
        $umkms = UmkmProfile::with('user', 'category')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->q, fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.umkm.index', compact('umkms'));
    }

    public function show(UmkmProfile $umkm)
    {
        $umkm->load('user', 'category', 'products');
        $stats = [
            'total_orders' => $umkm->orders()->count(),
            'total_revenue' => $umkm->orders()->where('status', 'completed')->sum('total'),
        ];

        return view('admin.umkm.show', compact('umkm', 'stats'));
    }

    public function approve(UmkmProfile $umkm)
    {
        $umkm->update(['status' => 'approved']);

        \App\Models\Notification::create([
            'user_id' => $umkm->user_id,
            'title' => 'Toko Disetujui',
            'message' => "Selamat! Toko \"{$umkm->name}\" telah disetujui dan kini tampil di LOKALIN.",
            'url' => route('umkm.dashboard'),
        ]);

        return back()->with('success', 'UMKM berhasil disetujui.');
    }

    public function reject(Request $request, UmkmProfile $umkm)
    {
        $umkm->update(['status' => 'rejected']);

        \App\Models\Notification::create([
            'user_id' => $umkm->user_id,
            'title' => 'Toko Ditolak',
            'message' => "Pendaftaran toko \"{$umkm->name}\" ditolak. Silakan lengkapi data dan hubungi admin.",
            'url' => route('umkm.profile.edit'),
        ]);

        return back()->with('success', 'UMKM ditolak.');
    }

    public function suspend(UmkmProfile $umkm)
    {
        $umkm->update(['status' => 'suspended']);

        return back()->with('success', 'UMKM berhasil disuspend.');
    }

    public function reactivate(UmkmProfile $umkm)
    {
        $umkm->update(['status' => 'approved']);

        return back()->with('success', 'UMKM berhasil diaktifkan kembali.');
    }
}
