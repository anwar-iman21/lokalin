<header class="sticky top-0 z-40 border-b border-gray-100 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('landing') }}" class="text-xl font-extrabold text-primary-600">LOKALIN</a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-gray-600 md:flex">
            <a href="{{ route('landing') }}" class="hover:text-primary-600">Beranda</a>
            @auth
                @if (auth()->user()->isCustomer())
                    <a href="{{ route('customer.explore') }}" class="hover:text-primary-600">Jelajahi UMKM</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="hover:text-primary-600">Daftarkan UMKM Anda</a>
            @endauth
        </nav>

        <div class="flex items-center gap-3">
            @auth
                @if (auth()->user()->isCustomer())
                    <a href="{{ route('customer.cart') }}" class="relative rounded-lg p-2 hover:bg-gray-100" aria-label="Keranjang">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </a>
                    @include('components.notification-bell')
                @endif
                <a href="{{ auth()->user()->isCustomer() ? route('customer.explore') : (auth()->user()->isUmkm() ? route('umkm.dashboard') : route('admin.dashboard')) }}" class="btn-secondary !px-4 !py-2">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-secondary !px-4 !py-2">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary !px-4 !py-2">Daftar</a>
            @endauth
        </div>
    </div>
</header>
