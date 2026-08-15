<x-layouts.app title="Pesanan Saya">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Pesanan Saya</h1>

    <div class="mb-4 flex gap-2 overflow-x-auto">
        @foreach (['' => 'Semua', 'pending' => 'Menunggu', 'processing' => 'Diproses', 'delivering' => 'Diantar', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
            <a href="{{ route('customer.orders.index', $value ? ['status' => $value] : []) }}"
               class="badge shrink-0 {{ request('status', '') == $value ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse ($orders as $order)
            <a href="{{ route('customer.orders.show', $order) }}" class="card block hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                    <x-status-badge :status="$order->status" />
                </div>
                <p class="mt-1 text-sm text-gray-500">{{ $order->umkm->name }} · {{ $order->items->count() }} produk</p>
                <div class="mt-2 flex items-center justify-between text-sm">
                    <span class="text-gray-400">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>
                    <span class="font-semibold text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </a>
        @empty
            <div class="card text-center py-16">
                <p class="text-gray-500">Belum ada pesanan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</x-layouts.app>
