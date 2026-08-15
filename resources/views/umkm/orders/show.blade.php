<x-layouts.dashboard title="Detail Pesanan">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <a href="{{ route('umkm.orders.index') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Kembali ke Pesanan</a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h1>
        <x-status-badge :status="$order->status" />
    </div>

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

            <div class="card">
                <h2 class="font-semibold text-gray-800 mb-2">
                    {{ $order->fulfillment_method === 'delivery' ? 'Info Pengantaran' : 'Info Pengambilan' }}
                </h2>
                @if ($order->fulfillment_method === 'delivery')
                    <p class="text-sm text-gray-500">{{ $order->address }}</p>
                    @if ($order->delivery_note)
                        <p class="text-sm text-gray-500 mt-1">Catatan: {{ $order->delivery_note }}</p>
                    @endif
                    @if ($order->latitude && $order->longitude)
                        <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="btn-secondary mt-3 inline-flex !py-2 !text-xs">🗺️ Buka Rute di Google Maps</a>
                    @endif
                @else
                    <p class="text-sm text-gray-500">Pelanggan akan mengambil pesanan langsung di toko Anda.</p>
                @endif
            </div>
        </div>

        <div class="card h-fit space-y-4">
            <div>
                <p class="text-xs text-gray-400">Pelanggan</p>
                <p class="font-medium text-gray-800">{{ $order->recipient_name }} · {{ $order->recipient_phone }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tanggal Pesanan</p>
                <p class="font-medium text-gray-800">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>

            @if (!in_array($order->status, ['completed', 'cancelled']))
                <div class="space-y-2">
                    @if ($order->nextStatus())
                        <form method="POST" action="{{ route('umkm.orders.advance', $order) }}">
                            @csrf
                            <button type="submit" class="btn-primary w-full">
                                Lanjutkan ke "{{ \App\Models\Order::labelFor($order->nextStatus()) }}"
                            </button>
                        </form>
                    @endif

                    @if ($order->canBeCancelled())
                        <form method="POST" action="{{ route('umkm.orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan ini? Stok produk akan dikembalikan.')">
                            @csrf
                            <input type="hidden" name="reason" value="Dibatalkan oleh penjual">
                            <button type="submit" class="btn-danger w-full">Batalkan Pesanan</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
