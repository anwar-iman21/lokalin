<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id', 'category_id', 'name', 'slug', 'description', 'price',
        'stock', 'image', 'status', 'sold_count',
    ];

    protected $casts = [
    'price' => 'decimal:2',
];

    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->stock > 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
