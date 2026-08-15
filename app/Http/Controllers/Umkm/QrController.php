<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;

class QrController extends Controller
{
    public function show()
    {
        $umkm = auth()->user()->umkmProfile;
        $storeUrl = route('store.show', $umkm->slug);

        return view('umkm.qr', compact('umkm', 'storeUrl'));
    }
}
