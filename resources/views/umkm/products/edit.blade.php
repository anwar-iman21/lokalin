<x-layouts.dashboard title="Edit Produk">
    <x-slot name="sidebar"><x-umkm-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Edit Produk</h1>

    <div class="card max-w-2xl">
        <form method="POST" action="{{ route('umkm.products.update', $product) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            @include('umkm.products._form')
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</x-layouts.dashboard>
