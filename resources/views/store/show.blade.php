<x-layouts.app :title="$store->name">
    {{-- Store header --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="h-40 w-full bg-gradient-to-br from-primary-100 to-primary-300 sm:h-56">
            @if ($store->cover)
                <img src="{{ Storage::url($store->cover) }}" class="h-full w-full object-cover">
            @endif
        </div>
        <div class="relative px-6 pb-6">
            <div class="-mt-10 h-20 w-20 overflow-hidden rounded-2xl border-4 border-white bg-gray-200 shadow">
                @if ($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" class="h-full w-full object-cover">
                @endif
            </div>
            <div class="mt-3 flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $store->name }}</h1>
                    <p class="text-sm text-gray-500">{{ $store->category->name ?? 'Umum' }} · ⭐ {{ number_format($store->rating_avg, 1) }} ({{ $store->rating_count }} ulasan)</p>
                </div>
                @auth
                    @if (auth()->user()->isUmkm() && auth()->user()->umkmProfile->id === $store->id)
                        <a href="{{ route('umkm.profile.edit') }}" class="btn-secondary">Kelola Toko Saya</a>
                    @endif
                @endauth
            </div>
            <p class="mt-3 text-sm text-gray-600">{{ $store->description }}</p>
            <div class="mt-3 grid grid-cols-1 gap-2 text-sm text-gray-500 sm:grid-cols-2">
                <p>📍 {{ $store->address }}</p>
                <p>🕐 {{ $store->opening_hours ?? '-' }}</p>
                <p>📞 {{ $store->phone }}</p>
                @if ($store->latitude && $store->longitude)
                    <a href="https://www.google.com/maps?q={{ $store->latitude }},{{ $store->longitude }}" target="_blank" class="text-primary-600 hover:underline">🗺️ Buka di Google Maps</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Products --}}
    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Produk</h2>
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="input !w-56">
            </form>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-full text-sm text-gray-500 py-8 text-center">Belum ada produk tersedia.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>

    {{-- Reviews --}}
    @if ($reviews->isNotEmpty())
        <div class="mt-8">
            <h2 class="text-lg font-bold text-gray-800">Ulasan Pelanggan</h2>
            <div class="mt-4 space-y-3">
                @foreach ($reviews as $review)
                    <div class="card">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-gray-700">{{ $review->user->name }}</p>
                            <span class="text-amber-500">{{ str_repeat('⭐', $review->rating) }}</span>
                        </div>
                        @if ($review->comment)
                            <p class="mt-1 text-sm text-gray-600">{{ $review->comment }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.app>
