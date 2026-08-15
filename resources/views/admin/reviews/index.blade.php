<x-layouts.dashboard title="Moderasi Ulasan">
    <x-slot name="sidebar"><x-admin-sidebar /></x-slot>

    <h1 class="mb-6 text-xl font-bold text-gray-800">Moderasi Ulasan</h1>

    <div class="space-y-4">
        @forelse ($reviews as $review)
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>
                        <p class="text-xs text-gray-400">untuk {{ $review->product->name ?? '-' }} · {{ $review->umkm->name ?? '-' }}</p>
                    </div>
                    <span class="text-amber-500">{{ str_repeat('⭐', $review->rating) }}</span>
                </div>
                @if ($review->comment)
                    <p class="mt-2 text-sm text-gray-600">{{ $review->comment }}</p>
                @endif
                <div class="mt-3 flex items-center justify-between">
                    <x-status-badge :status="$review->status" />
                    <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                        @csrf
                        <button type="submit" class="text-xs text-primary-600 hover:underline">
                            {{ $review->status === 'visible' ? 'Sembunyikan' : 'Tampilkan' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card text-center py-16">
                <p class="text-gray-500">Belum ada ulasan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $reviews->links() }}</div>
</x-layouts.dashboard>
