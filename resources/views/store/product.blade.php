<x-layouts.app :title="$product->name">
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('store.show', $store->slug) }}" class="hover:text-primary-600">{{ $store->name }}</a> / {{ $product->name }}
    </nav>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        <div class="aspect-square overflow-hidden rounded-2xl bg-gray-100">
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 4h16v16H4V4z" /></svg>
                </div>
            @endif
        </div>

        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">Dijual oleh <a href="{{ route('store.show', $store->slug) }}" class="text-primary-600 hover:underline">{{ $store->name }}</a></p>
            <p class="mt-4 text-3xl font-extrabold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="mt-1 text-sm {{ $product->stock > 0 ? 'text-gray-500' : 'text-red-500 font-medium' }}">
                {{ $product->stock > 0 ? 'Stok tersedia: '.$product->stock : 'Stok habis' }}
            </p>

            <p class="mt-4 text-gray-600">{{ $product->description }}</p>

            @auth
                @if (auth()->user()->isCustomer())
                    <form method="POST" action="{{ route('customer.cart.add', $product) }}" class="mt-6 flex items-center gap-3">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="input !w-20" {{ $product->stock < 1 ? 'disabled' : '' }}>
                        <button type="submit" class="btn-primary" {{ $product->stock < 1 ? 'disabled' : '' }}>Tambah ke Keranjang</button>
                    </form>

                    @if (session('confirm_clear_cart'))
                        <div class="mt-3 rounded-xl bg-amber-50 border border-amber-200 p-4 text-sm text-amber-800">
                            <p>Keranjang Anda berisi produk dari toko lain. Menambahkan produk ini akan mengosongkan keranjang sebelumnya.</p>
                            <form method="POST" action="{{ route('customer.cart.switchStore', $product) }}" class="mt-2">
                                @csrf
                                <button type="submit" class="btn-secondary !py-1.5 !text-xs">Ya, Ganti Keranjang</button>
                            </form>
                        </div>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-primary mt-6">Masuk untuk Memesan</a>
            @endauth
        </div>
    </div>

    @if ($reviews->isNotEmpty())
        <div class="mt-10">
            <h2 class="text-lg font-bold text-gray-800">Ulasan Produk</h2>
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

    @if ($relatedProducts->isNotEmpty())
        <div class="mt-10">
            <h2 class="text-lg font-bold text-gray-800">Produk Lain dari Toko Ini</h2>
            <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach ($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.app>
