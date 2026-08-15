<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiGeneration extends Model
{
    use HasFactory;

    protected $table = 'ai_generations';

    protected $fillable = ['umkm_id', 'type', 'input', 'output', 'is_fallback'];

    protected $casts = [
    'input' => 'array',
    'is_fallback' => 'boolean',
];

    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }
}
