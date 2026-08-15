<x-layouts.dashboard title="Dashboard Admin">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="card">
            <p class="text-xs text-gray-400">Total UMKM</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $stats['total_umkm'] }}</p>
        </div>
        <div class="card">
            <p class="text-xs text-gray-400">UMKM Menunggu</p>
            <p class="mt-1 text-2xl font-bold text-amber-600">{{ $stats['pending_umkm'] }}</p>
        </div>
        <div class="card">
            <p class="text-xs text-gray-400">Total Pelanggan</p>
            <p class="mt-1 text-2xl font-bold text-gray-800">{{ $stats['total_customers'] }}</p>
        </div>
        <div class="card">
            <p class="text-xs text-gray-400">Total Transaksi</p>
            <p class="mt-1 text-xl font-bold text-primary-600">Rp {{ number_format($stats['total_transaction_value'], 0, ',', '.') }}</p>
        </div>
    </div>

    @if ($stats['pending_umkm'] > 0)
        <div class="mt-6 rounded-xl bg-amber-50 border border-amber-200 p-4 text-sm text-amber-800 flex items-center justify-between">
            <span>Ada {{ $stats['pending_umkm'] }} UMKM menunggu persetujuan Anda.</span>
            <a href="{{ route('admin.umkm.index', ['status' => 'pending']) }}" class="font-semibold hover:underline">Tinjau Sekarang →</a>
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="card lg:col-span-2">
            <h2 class="font-semibold text-gray-800 mb-4">Nilai Transaksi 6 Bulan Terakhir</h2>
            <canvas id="revenueChart" height="110"></canvas>
        </div>
        <div class="card">
            <h2 class="font-semibold text-gray-800 mb-4">UMKM Terbaru</h2>
            <div class="space-y-3">
                @forelse ($recentUmkm as $umkm)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 truncate">{{ $umkm->name }}</span>
                        <x-status-badge :status="$umkm->status" />
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Belum ada UMKM.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <h2 class="font-semibold text-gray-800 mb-4">Transaksi Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b">
                        <th class="pb-2">No. Pesanan</th>
                        <th class="pb-2">Pelanggan</th>
                        <th class="pb-2">Toko</th>
                        <th class="pb-2">Total</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="py-2"><a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:underline">{{ $order->order_number }}</a></td>
                            <td class="py-2">{{ $order->user->name }}</td>
                            <td class="py-2">{{ $order->umkm->name }}</td>
                            <td class="py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="py-2"><x-status-badge :status="$order->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Nilai Transaksi (Rp)',
                    data: @json($data),
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
