<x-layouts.dashboard title="Kelola Pesanan">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Kelola Pesanan</h1>

    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center">
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari no. pesanan..." class="input sm:max-w-xs">
            <button type="submit" class="btn-secondary">Cari</button>
        </form>
    </div>

    <div class="mb-4 flex gap-2 overflow-x-auto">
        @foreach (['' => 'Semua', 'pending' => 'Menunggu', 'processing' => 'Diproses', 'delivering' => 'Diantar', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
            <a href="{{ route('admin.orders.index', $value ? ['status' => $value] : []) }}"
               class="badge shrink-0 {{ request('status', '') == $value ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">No. Pesanan</th>
                    <th class="pb-2">Pelanggan</th>
                    <th class="pb-2">Toko</th>
                    <th class="pb-2">Total</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($orders as $order)
                    <tr>
                        <td class="py-3 font-medium">{{ $order->order_number }}</td>
                        <td class="py-3">{{ $order->user->name }}</td>
                        <td class="py-3">{{ $order->umkm->name }}</td>
                        <td class="py-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="py-3"><x-status-badge :status="$order->status" /></td>
                        <td class="py-3"><a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:underline">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</x-layouts.dashboard>
