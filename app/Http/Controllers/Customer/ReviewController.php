<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ReviewRequest;
use App\Models\Order;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if (! $order->isCompleted()) {
            return back()->with('error', 'Ulasan hanya bisa diberikan setelah pesanan selesai.');
        }

        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            Review::updateOrCreate(
                ['order_id' => $order->id, 'product_id' => $item->product_id],
                [
                    'umkm_id' => $order->umkm_id,
                    'user_id' => auth()->id(),
                    'rating' => $request->validated('rating'),
                    'comment' => $request->validated('comment'),
                ]
            );
        }

        $this->recalculateUmkmRating($order->umkm_id);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    protected function recalculateUmkmRating(int $umkmId): void
    {
        $stats = Review::where('umkm_id', $umkmId)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
            ->first();

        \App\Models\UmkmProfile::whereKey($umkmId)->update([
            'rating_avg' => round($stats->avg_rating ?? 0, 2),
            'rating_count' => $stats->total ?? 0,
        ]);
    }
}
