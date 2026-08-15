@props(['status'])

@php
    $map = [
        'pending' => 'bg-amber-100 text-amber-700',
        'confirmed' => 'bg-blue-100 text-blue-700',
        'processing' => 'bg-blue-100 text-blue-700',
        'ready' => 'bg-indigo-100 text-indigo-700',
        'delivering' => 'bg-indigo-100 text-indigo-700',
        'completed' => 'bg-primary-100 text-primary-700',
        'cancelled' => 'bg-red-100 text-red-700',
        'approved' => 'bg-primary-100 text-primary-700',
        'rejected' => 'bg-red-100 text-red-700',
        'suspended' => 'bg-red-100 text-red-700',
        'active' => 'bg-primary-100 text-primary-700',
        'inactive' => 'bg-gray-100 text-gray-600',
        'visible' => 'bg-primary-100 text-primary-700',
        'hidden' => 'bg-gray-100 text-gray-600',
    ];
    $label = [
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'processing' => 'Diproses',
        'ready' => 'Siap',
        'delivering' => 'Diantar',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'suspended' => 'Disuspend',
        'active' => 'Aktif',
        'inactive' => 'Nonaktif',
        'visible' => 'Tampil',
        'hidden' => 'Disembunyikan',
    ];
@endphp

<span class="badge {{ $map[$status] ?? 'bg-gray-100 text-gray-600' }}">{{ $label[$status] ?? ucfirst($status) }}</span>
