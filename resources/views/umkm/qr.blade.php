<x-layouts.dashboard title="QR Code Toko">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">QR Code Digital Store</h1>

    <div class="max-w-md card text-center">
        <p class="text-sm text-gray-500 mb-4">Cetak dan tempel QR Code ini di toko fisik Anda agar pelanggan bisa langsung membuka Digital Store Anda hanya dengan memindai.</p>

        <div class="mx-auto flex h-56 w-56 items-center justify-center rounded-2xl border border-gray-200 bg-white p-4">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($storeUrl) }}"
                 alt="QR Code {{ $umkm->name }}" class="h-full w-full object-contain">
        </div>

        <p class="mt-4 text-sm font-medium text-gray-700 break-all">{{ $storeUrl }}</p>

        <div class="mt-4 flex flex-col items-center gap-2">
            <div class="flex justify-center gap-3">
                <a href="{{ route('store.show', $umkm->slug) }}" target="_blank" class="btn-secondary">Buka Toko</a>
                <a href="https://api.qrserver.com/v1/create-qr-code/?size=600x600&data={{ urlencode($storeUrl) }}" target="_blank" class="btn-primary">Buka Gambar Ukuran Besar</a>
            </div>
            <p class="text-xs text-gray-400">Klik "Buka Gambar Ukuran Besar", lalu klik kanan pada gambar &rarr; "Save Image As" untuk mengunduh.</p>
        </div>
    </div>
</x-layouts.dashboard>