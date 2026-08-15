<x-layouts.app title="Beranda">
    {{-- Hero: Problem -> Solution -> Impact storytelling --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 to-primary-800 px-6 py-16 text-white sm:px-12 sm:py-24 -mx-4 sm:mx-0">
        <div class="mx-auto max-w-3xl text-center">
            <span class="badge bg-white/15 text-white">iTechnoCup 2026</span>
            <h1 class="mt-4 text-3xl font-extrabold leading-tight sm:text-5xl">
                Banyak UMKM Lokal Hebat, <br class="hidden sm:block">Tapi Sulit Ditemukan Secara Digital
            </h1>
            <p class="mt-4 text-base text-primary-100 sm:text-lg">
                LOKALIN hadir sebagai solusi: platform digitalisasi UMKM yang menghubungkan pelaku usaha lokal dengan pelanggan, lengkap dengan Digital Store, QR Code, dan Asisten Bisnis AI — agar UMKM naik kelas tanpa ribet.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('customer.explore') }}" class="btn-primary !bg-white !text-primary-700 hover:!bg-primary-50">Jelajahi UMKM Sekarang</a>
                <a href="{{ route('register') }}" class="btn-secondary !border-white/30 !bg-white/10 !text-white hover:!bg-white/20">Daftarkan UMKM Anda</a>
            </div>
        </div>
    </section>

    {{-- Impact stats --}}
<section class="relative z-10 mx-auto -mt-10 grid max-w-4xl grid-cols-1 gap-4 px-2 sm:-mt-12 sm:grid-cols-3 sm:px-0">
            <div class="card text-center shadow-lg">
            <p class="text-3xl font-extrabold text-primary-600">{{ $stats['total_umkm'] }}+</p>
            <p class="mt-1 text-sm text-gray-500">UMKM Terdaftar</p>
        </div>
        <div class="card text-center shadow-lg">
            <p class="text-3xl font-extrabold text-primary-600">{{ $stats['total_products'] }}+</p>
            <p class="mt-1 text-sm text-gray-500">Produk Lokal</p>
        </div>
        <div class="card text-center shadow-lg">
            <p class="text-3xl font-extrabold text-primary-600">{{ $stats['total_orders'] }}+</p>
            <p class="mt-1 text-sm text-gray-500">Transaksi Berhasil</p>
        </div>
    </section>

    {{-- Categories --}}
    <section class="mt-16">
        <h2 class="text-xl font-bold text-gray-800">Kategori Populer</h2>
        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-8">
            @foreach ($categories as $category)
                <a href="{{ route('customer.explore', ['category' => $category->id]) }}" class="card flex flex-col items-center justify-center gap-2 text-center hover:shadow-md">
                    <span class="text-2xl">{{ $category->icon }}</span>
                    <span class="text-xs font-medium text-gray-600">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured UMKM --}}
    <section class="mt-16">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">UMKM Pilihan</h2>
            <a href="{{ route('customer.explore') }}" class="text-sm font-medium text-primary-600 hover:underline">Lihat Semua →</a>
        </div>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($featuredUmkms as $umkm)
                <x-umkm-card :umkm="$umkm" />
            @empty
                <p class="col-span-full text-sm text-gray-500">Belum ada UMKM yang tampil. Jadilah yang pertama mendaftar!</p>
            @endforelse
        </div>
    </section>

    {{-- How it works --}}
    <section class="mt-16 rounded-3xl bg-white p-8 sm:p-12">
        <h2 class="text-center text-xl font-bold text-gray-800">Cara Kerja LOKALIN</h2>
        <div class="mt-8 grid grid-cols-1 gap-8 sm:grid-cols-3">
            <div class="text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-100 text-2xl">🏪</div>
                <h3 class="mt-4 font-semibold">1. UMKM Daftar & Buka Toko Digital</h3>
                <p class="mt-2 text-sm text-gray-500">Pelaku usaha membuat Digital Store lengkap dengan produk, foto, dan QR Code toko dalam hitungan menit.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-100 text-2xl">🛍️</div>
                <h3 class="mt-4 font-semibold">2. Pelanggan Jelajahi & Pesan</h3>
                <p class="mt-2 text-sm text-gray-500">Pelanggan menemukan UMKM terdekat, memesan produk untuk diantar atau diambil langsung.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-100 text-2xl">🤖</div>
                <h3 class="mt-4 font-semibold">3. UMKM Naik Kelas dengan AI</h3>
                <p class="mt-2 text-sm text-gray-500">Asisten Bisnis AI membantu membuat caption promosi & strategi pemasaran secara otomatis.</p>
            </div>
        </div>
    </section>
</x-layouts.app>
