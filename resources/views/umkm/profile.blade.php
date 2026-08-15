<x-layouts.dashboard title="Profil Toko">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Profil Toko</h1>

    <div class="max-w-2xl card">
        <div class="mb-4">
            <span class="text-xs text-gray-400">Status Toko:</span>
            <x-status-badge :status="$umkm->status" />
        </div>

        <form method="POST" action="{{ route('umkm.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="label">Nama Toko</label>
                <input type="text" name="name" value="{{ old('name', $umkm->name) }}" required class="input">
            </div>

            <div>
                <label class="label">Kategori</label>
                <select name="category_id" class="input">
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $umkm->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="label">Deskripsi</label>
                <textarea name="description" rows="3" class="input">{{ old('description', $umkm->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $umkm->phone) }}" required class="input">
                </div>
                <div>
                    <label class="label">Jam Operasional</label>
                    <input type="text" name="opening_hours" value="{{ old('opening_hours', $umkm->opening_hours) }}" placeholder="08.00 - 20.00 WIB" class="input">
                </div>
            </div>

            <div>
                <label class="label">Alamat</label>
                <textarea name="address" rows="2" required class="input">{{ old('address', $umkm->address) }}</textarea>
                <div class="mt-2 flex items-center gap-3">
                    <button type="button" class="btn-secondary !py-2 !text-xs" onclick="lokalinGetLocation('latitude', 'longitude', 'geo-status')">📍 Gunakan Lokasi Saya (GPS)</button>
                    <span id="geo-status" class="text-xs text-gray-500">
                        @if ($umkm->latitude) Lokasi tersimpan: {{ $umkm->latitude }}, {{ $umkm->longitude }} @endif
                    </span>
                </div>
                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $umkm->latitude) }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $umkm->longitude) }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Logo Toko</label>
                    <input type="file" name="logo" accept="image/*" class="input">
                    @if ($umkm->logo)
                        <img src="{{ Storage::url($umkm->logo) }}" class="mt-2 h-16 w-16 rounded-lg object-cover">
                    @endif
                </div>
                <div>
                    <label class="label">Foto Sampul</label>
                    <input type="file" name="cover" accept="image/*" class="input">
                    @if ($umkm->cover)
                        <img src="{{ Storage::url($umkm->cover) }}" class="mt-2 h-16 w-28 rounded-lg object-cover">
                    @endif
                </div>
            </div>

            <button type="submit" class="btn-primary">Simpan Profil</button>
        </form>
    </div>
</x-layouts.dashboard>
