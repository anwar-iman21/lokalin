<x-layouts.dashboard title="Analitik Toko">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Analitik Toko</h1>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="card lg:col-span-2">
            <h2 class="font-semibold text-gray-800 mb-4">Pendapatan 6 Bulan Terakhir</h2>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

        <div class="card">
            <h2 class="font-semibold text-gray-800 mb-4">Status Pesanan</h2>
            <div class="space-y-2 text-sm">
                @forelse ($ordersByStatus as $status => $count)
                    <div class="flex justify-between">
                        <x-status-badge :status="$status" />
                        <span class="font-medium">{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-gray-400">Belum ada data pesanan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <h2 class="font-semibold text-gray-800 mb-4">Produk Terlaris</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">Produk</th>
                    <th class="pb-2">Terjual</th>
                    <th class="pb-2">Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($bestSellers as $product)
                    <tr>
                        <td class="py-2">{{ $product->name }}</td>
                        <td class="py-2">{{ $product->sold_count }}</td>
                        <td class="py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-6 text-center text-gray-400">Belum ada data penjualan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($data),
                    backgroundColor: '#22c55e',
                    borderRadius: 6,
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    </script>
</x-layouts.dashboard>
