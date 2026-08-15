<x-layouts.app title="Keranjang Saya">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Keranjang Saya</h1>

    @if ($cart->items->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-500">Keranjang Anda masih kosong.</p>
            <a href="{{ route('customer.explore') }}" class="btn-primary mt-4 inline-flex">Mulai Belanja</a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="card">
                    <p class="text-sm text-gray-500">Belanja dari toko</p>
                    <p class="font-semibold text-gray-800">{{ $cart->umkm->name ?? '-' }}</p>
                </div>

                @foreach ($cart->items as $item)
                    <div class="card flex items-center gap-4">
                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-gray-100">
                            @if ($item->product->image)
                                <img src="{{ Storage::url($item->product->image) }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                            <p class="text-sm text-primary-600 font-medium">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                        </div>
                        <form method="POST" action="{{ route('customer.cart.update', $item->id) }}" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="input !w-16 !py-1.5" onchange="this.form.submit()">
                        </form>
                        <form method="POST" action="{{ route('customer.cart.destroy', $item->id) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" aria-label="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="card h-fit">
                <h2 class="font-semibold text-gray-800">Ringkasan Belanja</h2>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-semibold">Rp {{ number_format($cart->subtotal(), 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('customer.checkout') }}" class="btn-primary mt-6 w-full">Lanjut ke Checkout</a>
            </div>
        </div>
    @endif
</x-layouts.app>
