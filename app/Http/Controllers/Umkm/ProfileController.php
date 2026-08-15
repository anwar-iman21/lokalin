<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Umkm\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $umkm = auth()->user()->umkmProfile;
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('umkm.profile', compact('umkm', 'categories'));
    }

    public function update(ProfileRequest $request)
    {
        $umkm = auth()->user()->umkmProfile;
        $data = $request->validated();

        if ($umkm->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(5));
        }

        if ($request->hasFile('logo')) {
            if ($umkm->logo) {
                Storage::disk('public')->delete($umkm->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($umkm->cover) {
                Storage::disk('public')->delete($umkm->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $umkm->update($data);

        return back()->with('success', 'Profil toko berhasil diperbarui.');
    }
}
