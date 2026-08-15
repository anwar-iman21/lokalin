<x-layouts.dashboard title="Kelola UMKM">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Kelola UMKM</h1>

    <div class="mb-4 flex gap-2 overflow-x-auto">
        @foreach (['' => 'Semua', 'pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'suspended' => 'Disuspend'] as $value => $label)
            <a href="{{ route('admin.umkm.index', $value ? ['status' => $value] : []) }}"
               class="badge shrink-0 {{ request('status', '') == $value ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">Nama Toko</th>
                    <th class="pb-2">Pemilik</th>
                    <th class="pb-2">Kategori</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($umkms as $umkm)
                    <tr>
                        <td class="py-3"><a href="{{ route('admin.umkm.show', $umkm) }}" class="font-medium text-primary-600 hover:underline">{{ $umkm->name }}</a></td>
                        <td class="py-3">{{ $umkm->user->name }}</td>
                        <td class="py-3">{{ $umkm->category->name ?? '-' }}</td>
                        <td class="py-3"><x-status-badge :status="$umkm->status" /></td>
                        <td class="py-3 space-x-2 whitespace-nowrap">
                            @if ($umkm->status === 'pending')
                                <form method="POST" action="{{ route('admin.umkm.approve', $umkm) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-primary-600 hover:underline">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('admin.umkm.reject', $umkm) }}" class="inline" onsubmit="return confirm('Tolak pendaftaran UMKM ini?')">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:underline">Tolak</button>
                                </form>
                            @elseif ($umkm->status === 'approved')
                                <form method="POST" action="{{ route('admin.umkm.suspend', $umkm) }}" class="inline" onsubmit="return confirm('Suspend toko ini?')">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:underline">Suspend</button>
                                </form>
                            @elseif ($umkm->status === 'suspended')
                                <form method="POST" action="{{ route('admin.umkm.reactivate', $umkm) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-primary-600 hover:underline">Aktifkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-gray-400">Tidak ada data UMKM.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $umkms->links() }}</div>
</x-layouts.dashboard>
