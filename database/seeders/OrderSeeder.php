<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@lokalin.test')->first();
        $umkm = UmkmProfile::where('name', 'Kopi Senja')->first();

        if (! $customer || ! $umkm) {
            return;
        }

        $product = $umkm->products()->first();

        if (! $product) {
            return;
        }

        // A completed order with review, to demo the review flow out of the box.
        $order = Order::updateOrCreate(
            ['order_number' => 'LKN-DEMO-COMPLETED'],
            [
                'user_id' => $customer->id,
                'umkm_id' => $umkm->id,
                'fulfillment_method' => 'pickup',
                'status' => 'completed',
                'recipient_name' => $customer->name,
                'recipient_phone' => $customer->phone,
                'subtotal' => $product->price * 2,
                'total' => $product->price * 2,
                'confirmed_at' => now()->subDays(3),
                'completed_at' => now()->subDays(2),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order->id, 'product_id' => $product->id],
            [
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => 2,
                'subtotal' => $product->price * 2,
            ]
        );

        Review::updateOrCreate(
            ['order_id' => $order->id, 'product_id' => $product->id],
            [
                'umkm_id' => $umkm->id,
                'user_id' => $customer->id,
                'rating' => 5,
                'comment' => 'Kopinya enak banget, kekinian tapi tetap khas lokal. Pasti order lagi!',
                'status' => 'visible',
            ]
        );

        $umkm->update([
            'rating_avg' => 5,
            'rating_count' => 1,
        ]);

        // A pending order, to demo the UMKM order-management flow out of the box.
        $pendingOrder = Order::updateOrCreate(
            ['order_number' => 'LKN-DEMO-PENDING'],
            [
                'user_id' => $customer->id,
                'umkm_id' => $umkm->id,
                'fulfillment_method' => 'delivery',
                'status' => 'pending',
                'recipient_name' => $customer->name,
                'recipient_phone' => $customer->phone,
                'address' => 'Jl. Demo Pengantaran No. 1, Bandar Lampung',
                'latitude' => -5.3971,
                'longitude' => 105.2668,
                'delivery_note' => 'Tolong tanpa gula tambahan, terima kasih.',
                'subtotal' => $product->price,
                'total' => $product->price,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $pendingOrder->id, 'product_id' => $product->id],
            [
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ]
        );
    }
}
