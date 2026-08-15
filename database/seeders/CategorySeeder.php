<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan & Minuman', 'icon' => '🍔'],
            ['name' => 'Fashion & Aksesoris', 'icon' => '👗'],
            ['name' => 'Kerajinan Tangan', 'icon' => '🧶'],
            ['name' => 'Kecantikan & Perawatan', 'icon' => '💄'],
            ['name' => 'Jasa & Layanan', 'icon' => '🛠️'],
            ['name' => 'Pertanian & Sembako', 'icon' => '🌾'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'icon' => $category['icon']]
            );
        }
    }
}
