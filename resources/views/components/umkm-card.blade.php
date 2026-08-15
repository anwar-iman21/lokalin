@props(['umkm'])

<a href="{{ route('store.show', $umkm->slug) }}" class="card group flex flex-col hover:shadow-md transition">
    <div class="mb-3 h-32 w-full overflow-hidden rounded-xl bg-gradient-to-br from-primary-100 to-primary-200">
        @if ($umkm->cover)
            <img src="{{ Storage::url($umkm->cover) }}" alt="{{ $umkm->name }}" class="h-full w-full object-cover">
        @endif
    </div>
    <div class="flex items-center gap-2">
        <div class="h-8 w-8 shrink-0 overflow-hidden rounded-full bg-gray-200">
            @if ($umkm->logo)
                <img src="{{ Storage::url($umkm->logo) }}" class="h-full w-full object-cover">
            @endif
        </div>
        <h3 class="font-semibold text-gray-800 truncate">{{ $umkm->name }}</h3>
    </div>
    <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $umkm->description }}</p>
    <div class="mt-3 flex items-center justify-between text-xs text-gray-500">
        <span>{{ $umkm->category->name ?? 'Umum' }} · {{ $umkm->products_count ?? $umkm->products()->count() }} produk</span>
        <span class="flex items-center gap-1 font-medium text-amber-500">⭐ {{ number_format($umkm->rating_avg, 1) }}</span>
    </div>
</a>
