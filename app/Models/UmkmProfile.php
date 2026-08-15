<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $table = 'umkm_profiles';

    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug', 'description', 'logo', 'cover',
        'phone', 'address', 'latitude', 'longitude', 'opening_hours', 'status',
        'rating_avg', 'rating_count',
    ];

    protected $casts = [
    'latitude' => 'decimal:7',
    'longitude' => 'decimal:7',
    'rating_avg' => 'decimal:2',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'umkm_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'umkm_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'umkm_id');
    }

    public function aiGenerations()
    {
        return $this->hasMany(AiGeneration::class, 'umkm_id');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
