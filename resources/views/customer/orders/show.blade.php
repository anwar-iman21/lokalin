<x-layouts.app title="Detail Pesanan">
    <a href="{{ route('customer.orders.index') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Kembali ke Pesanan Saya</a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">{{ $order->order_number }}</h1>
        <x-status-badge :status="$order->status" />
    </div>

    {{-- Order status tracker --}}
    @if (!in_array($order->status, ['cancelled']))
        <div class="card mt-4">
            <div class="flex flex-wrap items-center gap-2">
                @foreach ($order->statusFlow() as $step)
                    @php $reached = array_search($order->status, $order->statusFlow()) >= array_search($step, $order->statusFlow()); @endphp
                    <span class="badge {{ $reached ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-500' }}">{{ \App\Models\Order::labelFor($step) }}</span>
                    @if (!$loop->last) <span class="text-gray-300">→</span> @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            <div class="card">
                <h2 class="font-semibold text-gray-800 mb-3">Produk Dipesan</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->product_name }} x{{ $item->quantity }}</span>
                            <span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 border-t pt-3 flex justify-between font-semibold">
                    <span>Total</span>
                    <span class="text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($order->fulfillment_method === 'delivery')
                <div class="card">
                    <h2 class="font-semibold text-gray-800 mb-2">Info Pengantaran</h2>
                    <p class="text-sm text-gray-500">{{ $order->address }}</p>
                    @if ($order->latitude && $order->longitude)
                        <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="btn-secondary mt-3 inline-flex !py-2 !text-xs">🗺️ Buka Rute di Google Maps</a>
                    @endif
                </div>
            @else
                <div class="card">
                    <h2 class="font-semibold text-gray-800 mb-2">Info Pengambilan</h2>
                    <p class="text-sm text-gray-500">📍 {{ $order->umkm->address }}</p>
                </div>
            @endif

            @if ($order->isCompleted())
                <div class="card">
                    <h2 class="font-semibold text-gray-800 mb-3">Beri Ulasan</h2>
                    @if ($order->review->isNotEmpty())
                        <p class="text-sm text-gray-500">Terima kasih, Anda sudah memberi ulasan untuk pesanan ini. ⭐ {{ $order->review->first()->rating }}/5</p>
                    @else
                        <form method="POST" action="{{ route('customer.orders.review', $order) }}" x-data="{ rating: 5 }">
                            @csrf
                            <div class="flex gap-1 mb-3">
                                <template x-for="i in 5" :key="i">
                                    <button type="button" @click="rating = i" class="text-2xl" :class="i <= rating ? 'text-amber-400' : 'text-gray-300'">★</button>
                                </template>
                            </div>
                            <input type="hidden" name="rating" x-bind:value="rating">
                            <textarea name="comment" rows="3" placeholder="Ceritakan pengalaman Anda..." class="input"></textarea>
                            <button type="submit" class="btn-primary mt-3">Kirim Ulasan</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        <div class="card h-fit space-y-3">
            <div>
                <p class="text-xs text-gray-400">Toko</p>
                <p class="font-medium text-gray-800">{{ $order->umkm->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Penerima</p>
                <p class="font-medium text-gray-800">{{ $order->recipient_name }} · {{ $order->recipient_phone }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tanggal Pesanan</p>
                <p class="font-medium text-gray-800">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>

            @if ($order->canBeCancelled())
                <form method="POST" action="{{ route('customer.orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf
                    <button type="submit" class="btn-danger w-full">Batalkan Pesanan</button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.app>
