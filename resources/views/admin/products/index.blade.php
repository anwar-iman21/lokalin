<x-layouts.dashboard title="Kelola Produk">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Kelola Produk</h1>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="input sm:max-w-xs">
    </form>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($products as $product)
            <div class="card">
                <div class="h-32 w-full overflow-hidden rounded-xl bg-gray-100 mb-3">
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <p class="text-xs text-gray-400">{{ $product->umkm->name ?? '-' }}</p>
                <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                <p class="text-sm text-primary-600 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="mt-2 flex items-center justify-between">
                    <x-status-badge :status="$product->status" />
                    <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                        @csrf
                        <button type="submit" class="text-xs text-primary-600 hover:underline">
                            {{ $product->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-400 py-12">Belum ada produk.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</x-layouts.dashboard>
