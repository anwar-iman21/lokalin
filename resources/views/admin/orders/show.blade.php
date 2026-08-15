<x-layouts.dashboard title="Detail Pesanan">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Kembali</a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h1>
        <x-status-badge :status="$order->status" />
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 card">
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

        <div class="card h-fit space-y-3">
            <div><p class="text-xs text-gray-400">Pelanggan</p><p class="font-medium">{{ $order->user->name }}</p></div>
            <div><p class="text-xs text-gray-400">Toko</p><p class="font-medium">{{ $order->umkm->name }}</p></div>
            <div><p class="text-xs text-gray-400">Metode</p><p class="font-medium">{{ $order->fulfillment_method === 'delivery' ? 'Diantar' : 'Diambil Sendiri' }}</p></div>
            <div><p class="text-xs text-gray-400">Tanggal</p><p class="font-medium">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p></div>
        </div>
    </div>
</x-layouts.dashboard>
