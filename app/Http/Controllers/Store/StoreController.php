<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show(Request $request, UmkmProfile $store)
    {
        abort_unless($store->status === 'approved', 404);

        $products = $store->products()
            ->where('status', 'active')
            ->when($request->q, fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->orderByDesc('sold_count')
            ->paginate(12)
            ->withQueryString();

        $reviews = $store->reviews()
            ->where('status', 'visible')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('store.show', compact('store', 'products', 'reviews'));
    }

    public function product(UmkmProfile $store, \App\Models\Product $product)
    {
        abort_unless($store->status === 'approved', 404);
        abort_unless($product->umkm_id === $store->id, 404);

        $product->load('images');
        $reviews = $product->reviews()->where('status', 'visible')->with('user')->latest()->take(10)->get();
        $relatedProducts = $store->products()->where('status', 'active')->where('id', '!=', $product->id)->take(4)->get();

        return view('store.product', compact('store', 'product', 'reviews', 'relatedProducts'));
    }

    public function qr(UmkmProfile $store)
    {
        abort_unless($store->status === 'approved', 404);

        return view('store.qr', compact('store'));
    }
}
