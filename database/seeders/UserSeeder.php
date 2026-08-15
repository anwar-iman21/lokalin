<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // --- Admin demo account ---
        User::updateOrCreate(
            ['email' => 'admin@lokalin.test'],
            [
                'name' => 'Admin LOKALIN',
                'phone' => '081200000001',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // --- Customer demo account ---
        $customer = User::updateOrCreate(
            ['email' => 'customer@lokalin.test'],
            [
                'name' => 'Budi Santoso',
                'phone' => '081200000002',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        Cart::firstOrCreate(['user_id' => $customer->id]);

        // A handful of extra random customers for demo variety.
        User::factory()->count(8)->create(['role' => 'customer'])->each(function ($user) {
            Cart::firstOrCreate(['user_id' => $user->id]);
        });

        // --- UMKM demo accounts (approved & ready to browse) ---
        $categoryIds = Category::pluck('id')->all();

        $umkmSeed = [
            ['name' => 'Kopi Senja', 'email' => 'umkm1@lokalin.test', 'desc' => 'Kedai kopi rumahan dengan biji kopi lokal pilihan dari petani sekitar.'],
            ['name' => 'Batik Rahayu', 'email' => 'umkm2@lokalin.test', 'desc' => 'Produsen batik tulis dan cap khas daerah, diwariskan turun-temurun.'],
            ['name' => 'Kriya Anyaman Asri', 'email' => 'umkm3@lokalin.test', 'desc' => 'Kerajinan anyaman bambu dan rotan ramah lingkungan.'],
            ['name' => 'Sabun Herbal Alami', 'email' => 'umkm4@lokalin.test', 'desc' => 'Sabun dan perawatan kulit berbahan herbal alami tanpa bahan kimia keras.'],
            ['name' => 'Warung Nasi Ibu Sri', 'email' => 'umkm5@lokalin.test', 'desc' => 'Warung makan rumahan dengan menu masakan rumahan khas nusantara.'],
        ];

        foreach ($umkmSeed as $index => $item) {
            $owner = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'].' (Pemilik)',
                    'phone' => '08130000000'.$index,
                    'password' => Hash::make('password'),
                    'role' => 'umkm',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            UmkmProfile::updateOrCreate(
                ['user_id' => $owner->id],
                [
                    'category_id' => $categoryIds[$index % count($categoryIds)],
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'description' => $item['desc'],
                    'phone' => '08130000000'.$index,
                    'address' => 'Jl. Contoh Raya No. '.($index + 1).', Bandar Lampung',
                    'latitude' => -5.3971 + ($index * 0.01),
                    'longitude' => 105.2668 + ($index * 0.01),
                    'opening_hours' => '08.00 - 20.00 WIB (Senin - Sabtu)',
                    'status' => 'approved',
                ]
            );
        }

        // One UMKM left pending, to demo the admin approval flow.
        $pendingOwner = User::updateOrCreate(
            ['email' => 'umkm-pending@lokalin.test'],
            [
                'name' => 'Toko Baru (Pemilik)',
                'phone' => '081300000099',
                'password' => Hash::make('password'),
                'role' => 'umkm',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        UmkmProfile::updateOrCreate(
            ['user_id' => $pendingOwner->id],
            [
                'category_id' => $categoryIds[0],
                'name' => 'Toko Camilan Baru',
                'slug' => Str::slug('Toko Camilan Baru'),
                'description' => 'UMKM baru yang baru saja mendaftar dan menunggu persetujuan admin.',
                'phone' => '081300000099',
                'address' => 'Jl. Pendaftar Baru No. 9, Bandar Lampung',
                'status' => 'pending',
            ]
        );
    }
}
