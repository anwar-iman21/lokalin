<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_FLOW_DELIVERY = ['pending', 'confirmed', 'processing', 'ready', 'delivering', 'completed'];
    public const STATUS_FLOW_PICKUP = ['pending', 'confirmed', 'processing', 'ready', 'completed'];

    protected $fillable = [
        'order_number', 'user_id', 'umkm_id', 'fulfillment_method', 'status',
        'recipient_name', 'recipient_phone', 'address', 'latitude', 'longitude',
        'delivery_note', 'subtotal', 'total', 'confirmed_at', 'completed_at',
        'cancelled_at', 'cancel_reason',
    ];

    protected $casts = [
    'latitude' => 'decimal:7',
    'longitude' => 'decimal:7',
    'subtotal' => 'decimal:2',
    'total' => 'decimal:2',
    'confirmed_at' => 'datetime',
    'completed_at' => 'datetime',
    'cancelled_at' => 'datetime',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function statusFlow(): array
    {
        return $this->fulfillment_method === 'delivery'
            ? self::STATUS_FLOW_DELIVERY
            : self::STATUS_FLOW_PICKUP;
    }

    public function nextStatus(): ?string
    {
        $flow = $this->statusFlow();
        $currentIndex = array_search($this->status, $flow);

        if ($currentIndex === false || $currentIndex === count($flow) - 1) {
            return null;
        }

        return $flow[$currentIndex + 1];
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function statusLabel(): string
    {
        return self::labelFor($this->status);
    }

    public static function labelFor(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'ready' => 'Siap',
            'delivering' => 'Sedang Diantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($status),
        };
    }
}
