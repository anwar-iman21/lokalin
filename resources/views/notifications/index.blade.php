<x-layouts.app title="Notifikasi">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit" class="text-sm text-primary-600 hover:underline">Tandai semua dibaca</button>
        </form>
    </div>

    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                @csrf
                <button type="submit" class="card w-full text-left flex items-start gap-3 {{ $notification->is_read ? '' : 'bg-primary-50 border-primary-200' }}">
                    <span class="mt-1 h-2 w-2 shrink-0 rounded-full {{ $notification->is_read ? 'bg-gray-300' : 'bg-primary-500' }}"></span>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $notification->title }}</p>
                        <p class="text-sm text-gray-500">{{ $notification->message }}</p>
                        <p class="mt-1 text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </button>
            </form>
        @empty
            <div class="card text-center py-16">
                <p class="text-gray-500">Belum ada notifikasi.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>
</x-layouts.app>
