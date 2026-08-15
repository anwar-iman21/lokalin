<x-layouts.dashboard title="Produk Saya">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Produk Saya</h1>
        <a href="{{ route('umkm.products.create') }}" class="btn-primary">+ Tambah Produk</a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">Produk</th>
                    <th class="pb-2">Harga</th>
                    <th class="pb-2">Stok</th>
                    <th class="pb-2">Terjual</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($products as $product)
                    <tr>
                        <td class="py-3 flex items-center gap-3">
                            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <span class="font-medium text-gray-800">{{ $product->name }}</span>
                        </td>
                        <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-3 {{ $product->stock < 5 ? 'text-red-600 font-semibold' : '' }}">{{ $product->stock }}</td>
                        <td class="py-3">{{ $product->sold_count }}</td>
                        <td class="py-3"><x-status-badge :status="$product->status" /></td>
                        <td class="py-3 space-x-2 whitespace-nowrap">
                            <a href="{{ route('umkm.products.edit', $product) }}" class="text-primary-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('umkm.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada produk. Tambahkan produk pertama Anda!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</x-layouts.dashboard>
