@php $current = request()->route()->getName(); @endphp
@php
    $links = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
        ['route' => 'admin.umkm.index', 'label' => 'Kelola UMKM', 'icon' => '🏪'],
        ['route' => 'admin.customers.index', 'label' => 'Kelola Pelanggan', 'icon' => '👥'],
        ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => '🏷️'],
        ['route' => 'admin.products.index', 'label' => 'Kelola Produk', 'icon' => '📦'],
        ['route' => 'admin.orders.index', 'label' => 'Kelola Pesanan', 'icon' => '🧾'],
        ['route' => 'admin.reviews.index', 'label' => 'Moderasi Ulasan', 'icon' => '⭐'],
    ];
@endphp
@foreach ($links as $link)
    <a href="{{ route($link['route']) }}"
       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ str_starts_with($current, str_replace('.index', '', $link['route'])) || $current == $link['route'] ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
        <span>{{ $link['icon'] }}</span> {{ $link['label'] }}
    </a>
@endforeach
