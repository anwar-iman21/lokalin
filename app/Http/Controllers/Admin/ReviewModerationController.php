<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewModerationController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product', 'umkm'])->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggle(Review $review)
    {
        $review->update(['status' => $review->status === 'visible' ? 'hidden' : 'visible']);

        return back()->with('success', 'Status ulasan diperbarui.');
    }
}
