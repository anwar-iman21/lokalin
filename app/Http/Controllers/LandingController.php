<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UmkmProfile;

class LandingController extends Controller
{
    public function index()
    {
        $featuredUmkms = UmkmProfile::where('status', 'approved')
            ->withCount('products')
            ->orderByDesc('rating_avg')
            ->take(6)
            ->get();

        $categories = Category::withCount('umkmProfiles')->orderBy('name')->take(8)->get();

        $stats = [
            'total_umkm' => UmkmProfile::where('status', 'approved')->count(),
            'total_products' => \App\Models\Product::where('status', 'active')->count(),
            'total_orders' => \App\Models\Order::where('status', 'completed')->count(),
        ];

        return view('landing.index', compact('featuredUmkms', 'categories', 'stats'));
    }
}
