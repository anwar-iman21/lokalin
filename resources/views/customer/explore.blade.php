<x-layouts.app title="Jelajahi UMKM">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Jelajahi UMKM</h1>
        <p class="text-sm text-gray-500">Temukan usaha lokal terbaik di sekitar Anda.</p>
    </div>

    <form method="GET" class="mb-6 flex flex-col gap-3 sm:flex-row">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama UMKM..." class="input sm:max-w-xs">
        <select name="category" class="input sm:max-w-xs" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->icon }} {{ $category->name }}</option>
            @endforeach
        </select>
        <select name="sort" class="input sm:max-w-xs" onchange="this.form.submit()">
            <option value="rating" {{ request('sort', 'rating') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
        </select>
        <button type="submit" class="btn-primary">Cari</button>
    </form>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($umkms as $umkm)
            <x-umkm-card :umkm="$umkm" />
        @empty
            <p class="col-span-full text-center text-sm text-gray-500 py-12">Tidak ada UMKM yang ditemukan.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $umkms->links() }}</div>
</x-layouts.app>
