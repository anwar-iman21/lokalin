<x-layouts.dashboard title="Detail UMKM">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <a href="{{ route('admin.umkm.index') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Kembali ke Kelola UMKM</a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-800">{{ $umkm->name }}</h1>
        <x-status-badge :status="$umkm->status" />
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            <div class="card">
                <h2 class="font-semibold text-gray-800 mb-3">Informasi Toko</h2>
                <div class="space-y-1 text-sm text-gray-600">
                    <p><span class="text-gray-400">Deskripsi:</span> {{ $umkm->description ?: '-' }}</p>
                    <p><span class="text-gray-400">Kategori:</span> {{ $umkm->category->name ?? '-' }}</p>
                    <p><span class="text-gray-400">Alamat:</span> {{ $umkm->address ?: '-' }}</p>
                    <p><span class="text-gray-400">Telepon:</span> {{ $umkm->phone ?: '-' }}</p>
                    <p><span class="text-gray-400">Jam Operasional:</span> {{ $umkm->opening_hours ?: '-' }}</p>
                    <p><span class="text-gray-400">Pemilik:</span> {{ $umkm->user->name }} ({{ $umkm->user->email }})</p>
                </div>
            </div>

            <div class="card">
                <h2 class="font-semibold text-gray-800 mb-3">Produk ({{ $umkm->products->count() }})</h2>
                <div class="space-y-2 text-sm">
                    @forelse ($umkm->products as $product)
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ $product->name }}</span>
                            <span class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400">Belum ada produk.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card h-fit space-y-4">
            <div>
                <p class="text-xs text-gray-400">Total Pesanan</p>
                <p class="text-xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total Pendapatan</p>
                <p class="text-xl font-bold text-primary-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('store.show', $umkm->slug) }}" target="_blank" class="btn-secondary w-full">Lihat Digital Store</a>

            @if ($umkm->status === 'pending')
                <form method="POST" action="{{ route('admin.umkm.approve', $umkm) }}">
                    @csrf
                    <button type="submit" class="btn-primary w-full">Setujui UMKM</button>
                </form>
                <form method="POST" action="{{ route('admin.umkm.reject', $umkm) }}" onsubmit="return confirm('Tolak pendaftaran UMKM ini?')">
                    @csrf
                    <button type="submit" class="btn-danger w-full">Tolak UMKM</button>
                </form>
            @elseif ($umkm->status === 'approved')
                <form method="POST" action="{{ route('admin.umkm.suspend', $umkm) }}" onsubmit="return confirm('Suspend toko ini?')">
                    @csrf
                    <button type="submit" class="btn-danger w-full">Suspend Toko</button>
                </form>
            @elseif ($umkm->status === 'suspended')
                <form method="POST" action="{{ route('admin.umkm.reactivate', $umkm) }}">
                    @csrf
                    <button type="submit" class="btn-primary w-full">Aktifkan Kembali</button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
