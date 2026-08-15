<x-layouts.dashboard title="Kelola Pelanggan">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Kelola Pelanggan</h1>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/email..." class="input sm:max-w-xs">
    </form>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">Nama</th>
                    <th class="pb-2">Email</th>
                    <th class="pb-2">Total Pesanan</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($customers as $customer)
                    <tr>
                        <td class="py-3 font-medium text-gray-800">{{ $customer->name }}</td>
                        <td class="py-3">{{ $customer->email }}</td>
                        <td class="py-3">{{ $customer->orders_count }}</td>
                        <td class="py-3"><x-status-badge :status="$customer->status" /></td>
                        <td class="py-3">
                            <form method="POST" action="{{ route('admin.customers.toggle', $customer) }}" onsubmit="return confirm('Ubah status akun ini?')">
                                @csrf
                                <button type="submit" class="text-primary-600 hover:underline">
                                    {{ $customer->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada pelanggan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $customers->links() }}</div>
</x-layouts.dashboard>
