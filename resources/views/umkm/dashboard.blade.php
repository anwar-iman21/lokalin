<x-layouts.dashboard title="Dashboard UMKM">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    @if ($umkm->status !== 'approved')
        <div class="mb-6 rounded-xl bg-amber-50 border border-amber-200 p-4 text-sm text-amber-800">
            @if ($umkm->status === 'pending')
                Toko Anda sedang menunggu persetujuan admin. Anda akan mendapat notifikasi setelah disetujui.
            @elseif ($umkm->status === 'rejected')
                Pendaftaran toko Anda ditolak. Silakan lengkapi profil dan hubungi admin.
            @elseif ($umkm->status === 'suspended')
                Toko Anda sedang disuspend oleh admin.
            @endif
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="card">
            <p class="text-xs text-gray-400">Produk Aktif</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $stats['active_products'] }}</p>
        </div>
        <div class="card">
            <p class="text-xs text-gray-400">Pesanan Baru</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $stats['pending_orders'] }}</p>
        </div>
        <div class="card">
            <p class="text-xs text-gray-400">Pesanan Selesai</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $stats['completed_orders'] }}</p>
        </div>
        <div class="card">
            <p class="text-xs text-gray-400">Total Pendapatan</p>
            <p class="mt-1 text-xl font-bold text-primary-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="card lg:col-span-2">
            <h2 class="font-semibold text-gray-800 mb-4">Pendapatan 7 Hari Terakhir</h2>
            <canvas id="salesChart" height="100"></canvas>
        </div>
        <div class="card">
            <h2 class="font-semibold text-gray-800 mb-4">Produk Terlaris</h2>
            <div class="space-y-3">
                @forelse ($topProducts as $product)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 truncate">{{ $product->name }}</span>
                        <span class="font-medium text-gray-800">{{ $product->sold_count }} terjual</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Belum ada penjualan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-800">Pesanan Terbaru</h2>
            <a href="{{ route('umkm.orders.index') }}" class="text-sm text-primary-600 hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b">
                        <th class="pb-2">No. Pesanan</th>
                        <th class="pb-2">Pelanggan</th>
                        <th class="pb-2">Total</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="py-2"><a href="{{ route('umkm.orders.show', $order) }}" class="text-primary-600 hover:underline">{{ $order->order_number }}</a></td>
                            <td class="py-2">{{ $order->user->name }}</td>
                            <td class="py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="py-2"><x-status-badge :status="$order->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-6 text-center text-gray-400">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($chartData),
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.1)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    </script>
</x-layouts.dashboard>
