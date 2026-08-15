<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class OrderService
{
    /**
     * Convert a customer's cart into an order inside a DB transaction so
     * stock deduction and order creation always stay consistent.
     */
    public function createFromCart(Cart $cart, array $checkoutData): Order
    {
        if ($cart->items->isEmpty()) {
            throw new InvalidArgumentException('Keranjang kosong.');
        }

        return DB::transaction(function () use ($cart, $checkoutData) {
            $subtotal = 0;

            // Lock products to prevent race conditions on stock.
            foreach ($cart->items as $item) {
                $product = Product::whereKey($item->product_id)->lockForUpdate()->first();

                if (! $product || ! $product->isActive()) {
                    throw new InvalidArgumentException("Produk \"{$item->product->name}\" sudah tidak tersedia.");
                }

                if ($product->stock < $item->quantity) {
                    throw new InvalidArgumentException("Stok produk \"{$product->name}\" tidak mencukupi.");
                }

                $subtotal += $product->price * $item->quantity;
            }

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $cart->user_id,
                'umkm_id' => $cart->umkm_id,
                'fulfillment_method' => $checkoutData['fulfillment_method'],
                'status' => 'pending',
                'recipient_name' => $checkoutData['recipient_name'],
                'recipient_phone' => $checkoutData['recipient_phone'],
                'address' => $checkoutData['address'] ?? null,
                'latitude' => $checkoutData['latitude'] ?? null,
                'longitude' => $checkoutData['longitude'] ?? null,
                'delivery_note' => $checkoutData['delivery_note'] ?? null,
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $product->price * $item->quantity,
                ]);

                $product->decrement('stock', $item->quantity);
                $product->increment('sold_count', $item->quantity);
            }

            $cart->items()->delete();
            $cart->update(['umkm_id' => null]);

            return $order->load('items');
        });
    }

    public function advanceStatus(Order $order): Order
    {
        $next = $order->nextStatus();

        if (! $next) {
            throw new InvalidArgumentException('Order sudah berada pada status akhir.');
        }

        return DB::transaction(function () use ($order, $next) {
            $order->status = $next;

            if ($next === 'confirmed') {
                $order->confirmed_at = now();
            }

            if ($next === 'completed') {
                $order->completed_at = now();
            }

            $order->save();

            return $order;
        });
    }

    public function cancel(Order $order, ?string $reason = null): Order
    {
        if (! $order->canBeCancelled()) {
            throw new InvalidArgumentException('Order tidak dapat dibatalkan pada status ini.');
        }

        return DB::transaction(function () use ($order, $reason) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                    $item->product->decrement('sold_count', $item->quantity);
                }
            }

            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancel_reason' => $reason,
            ]);

            return $order;
        });
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'LKN-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
