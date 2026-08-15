<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    public function umkmProfiles()
    {
        return $this->hasMany(UmkmProfile::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
