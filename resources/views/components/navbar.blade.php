<header class="sticky top-0 z-40 border-b border-gray-100 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('landing') }}"
           class="text-xl font-extrabold text-primary-600">
            LOKALIN
        </a>

        {{-- Navigation --}}
        <nav class="hidden items-center gap-6 text-sm font-medium text-gray-600 md:flex">

            <a href="{{ route('landing') }}"
               class="hover:text-primary-600">
                Beranda
            </a>

            @auth

                {{-- Customer --}}
                @if (auth()->user()->isCustomer())
                    <a href="{{ route('customer.explore') }}"
                       class="hover:text-primary-600">
                        Jelajahi UMKM
                    </a>
                @endif

            @else

                <a href="{{ route('register') }}"
                   class="hover:text-primary-600">
                    Daftarkan UMKM Anda
                </a>

            @endauth

        </nav>

        {{-- Right Side --}}
        <div class="flex items-center gap-3">

            @auth

                {{-- ================= CUSTOMER ================= --}}
                @if (auth()->user()->isCustomer())

                    {{-- Cart --}}
                    <a href="{{ route('customer.cart') }}"
                       class="relative rounded-lg p-2 hover:bg-gray-100"
                       aria-label="Keranjang">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6 text-gray-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />

                        </svg>
                    </a>

                    {{-- Notification --}}
                    @include('components.notification-bell')

                    {{-- Profile --}}
                    <a href="{{ route('customer.profile.edit') }}"
                       class="btn-secondary !px-4 !py-2">
                        Profil Saya
                    </a>

                {{-- ================= UMKM ================= --}}
                @elseif (auth()->user()->isUmkm())

                    <a href="{{ route('umkm.dashboard') }}"
                       class="btn-secondary !px-4 !py-2">
                        Dashboard
                    </a>

                {{-- ================= ADMIN ================= --}}
                @elseif (auth()->user()->isAdmin())

                    <a href="{{ route('admin.dashboard') }}"
                       class="btn-secondary !px-4 !py-2">
                        Dashboard
                    </a>

                @endif


                {{-- ================= LOGOUT ================= --}}
                <form method="POST"
                      action="{{ route('logout') }}"
                      class="inline">

                    @csrf

                    <button type="submit"
                            class="rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                        Logout
                    </button>

                </form>


            @else

                {{-- Guest --}}
                <a href="{{ route('login') }}"
                   class="btn-secondary !px-4 !py-2">
                    Masuk
                </a>

                <a href="{{ route('register') }}"
                   class="btn-primary !px-4 !py-2">
                    Daftar
                </a>

            @endauth

        </div>
    </div>
</header>