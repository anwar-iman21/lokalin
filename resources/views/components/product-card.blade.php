@props(['product'])

<a href="{{ route('store.product', [$product->umkm->slug, $product->slug]) }}" class="card group flex flex-col hover:shadow-md transition">
    <div class="mb-3 aspect-square w-full overflow-hidden rounded-xl bg-gray-100">
        @if ($product->image)
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 4h16v16H4V4z" /></svg>
            </div>
        @endif
    </div>
    <p class="text-xs text-gray-400 truncate">{{ $product->umkm->name }}</p>
    <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $product->name }}</h3>
    <p class="mt-1 font-bold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
</a>
