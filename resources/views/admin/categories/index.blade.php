<x-layouts.dashboard title="Kelola Kategori">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Kelola Kategori</h1>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="card lg:col-span-1 h-fit">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Kategori</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="label">Nama Kategori</label>
                    <input type="text" name="name" required class="input">
                </div>
                <div>
                    <label class="label">Ikon (emoji)</label>
                    <input type="text" name="icon" placeholder="🍔" class="input">
                </div>
                <button type="submit" class="btn-primary w-full">Tambah</button>
            </form>
        </div>

        <div class="lg:col-span-2 card overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b">
                        <th class="pb-2">Kategori</th>
                        <th class="pb-2">UMKM</th>
                        <th class="pb-2">Produk</th>
                        <th class="pb-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="py-3">{{ $category->icon }} {{ $category->name }}</td>
                            <td class="py-3">{{ $category->umkm_profiles_count }}</td>
                            <td class="py-3">{{ $category->products_count }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-8 text-center text-gray-400">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $categories->links() }}</div>
        </div>
    </div>
</x-layouts.dashboard>
