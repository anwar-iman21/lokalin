<x-layouts.dashboard title="Asisten Bisnis AI">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <h1 class="mb-2 text-xl font-bold text-gray-800">Asisten Bisnis AI</h1>
    <p class="mb-6 text-sm text-gray-500">Buat caption promosi, ide konten, deskripsi produk, dan strategi promosi secara otomatis untuk membantu toko Anda naik kelas.</p>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="card" x-data="{ type: 'caption' }">
            <form method="POST" action="{{ route('umkm.ai.generate') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Jenis Bantuan</label>
                    <select name="type" x-model="type" class="input">
                        <option value="caption">Caption Promosi Produk</option>
                        <option value="description">Deskripsi Produk</option>
                        <option value="content_idea">Ide Konten Media Sosial</option>
                        <option value="promotion_strategy">Strategi Promosi</option>
                    </select>
                </div>

                <div x-show="type === 'caption' || type === 'description'" x-cloak>
                    <label class="label">Nama Produk</label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" class="input">
                </div>

                <div x-show="type === 'caption'" x-cloak>
                    <label class="label">Deskripsi Singkat (opsional)</label>
                    <textarea name="description" rows="2" class="input">{{ old('description') }}</textarea>
                    <label class="label mt-3">Target Pelanggan (opsional)</label>
                    <input type="text" name="target_customer" value="{{ old('target_customer') }}" placeholder="Contoh: anak muda, pekerja kantoran" class="input">
                </div>

                <div x-show="type === 'description'" x-cloak>
                    <label class="label">Kata Kunci (opsional)</label>
                    <input type="text" name="keywords" value="{{ old('keywords') }}" placeholder="Contoh: alami, tanpa pengawet" class="input">
                </div>

                <div x-show="type === 'content_idea' || type === 'promotion_strategy'" x-cloak>
                    <label class="label">Jenis Usaha</label>
                    <input type="text" name="business_type" value="{{ old('business_type') }}" placeholder="Contoh: kedai kopi, toko batik" class="input">
                </div>

                <button type="submit" class="btn-primary w-full">✨ Buatkan Sekarang</button>
            </form>
        </div>

        <div class="card">
            <h2 class="font-semibold text-gray-800 mb-3">Hasil</h2>
            @if (session('ai_result'))
                @php $result = session('ai_result'); @endphp
                <div class="rounded-xl bg-primary-50 border border-primary-200 p-4 text-sm text-gray-700 whitespace-pre-line">{{ $result->output }}</div>
                @if ($result->is_fallback)
                    <p class="mt-2 text-xs text-gray-400">*Dibuat menggunakan generator bawaan LOKALIN (mode offline/fallback).</p>
                @endif
            @else
                <p class="text-sm text-gray-400">Hasil akan tampil di sini setelah Anda mengisi form di samping.</p>
            @endif
        </div>
    </div>

    <div class="card mt-6">
        <h2 class="font-semibold text-gray-800 mb-4">Riwayat</h2>
        <div class="space-y-3">
            @forelse ($history as $item)
                <div class="rounded-xl border border-gray-100 p-4">
                    <div class="flex items-center justify-between">
                        <span class="badge bg-gray-100 text-gray-600">{{ ucfirst(str_replace('_', ' ', $item->type)) }}</span>
                        <span class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 whitespace-pre-line">{{ \Illuminate\Support\Str::limit($item->output, 200) }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-400">Belum ada riwayat penggunaan Asisten AI.</p>
            @endforelse
        </div>
    </div>
</x-layouts.dashboard>
