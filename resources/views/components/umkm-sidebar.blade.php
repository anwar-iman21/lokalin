@php $current = request()->route()->getName(); @endphp
@php
    $links = [
        ['route' => 'umkm.dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
        ['route' => 'umkm.products.index', 'label' => 'Produk', 'icon' => '📦'],
        ['route' => 'umkm.orders.index', 'label' => 'Pesanan', 'icon' => '🧾'],
        ['route' => 'umkm.analytics', 'label' => 'Analitik', 'icon' => '📈'],
        ['route' => 'umkm.ai.index', 'label' => 'Asisten AI', 'icon' => '🤖'],
        ['route' => 'umkm.qr', 'label' => 'QR Code Toko', 'icon' => '📱'],
        ['route' => 'umkm.profile.edit', 'label' => 'Profil Toko', 'icon' => '🏪'],
    ];
@endphp
@foreach ($links as $link)
    <a href="{{ route($link['route']) }}"
       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ str_starts_with($current, str_replace('.index', '', $link['route'])) || $current == $link['route'] ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
        <span>{{ $link['icon'] }}</span> {{ $link['label'] }}
    </a>
@endforeach
