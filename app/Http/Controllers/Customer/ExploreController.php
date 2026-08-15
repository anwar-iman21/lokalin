<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::query()
            ->where('status', 'approved')
            ->withCount('products')
            ->with('category');

        if ($search = $request->string('q')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->integer('category')) {
            $query->where('category_id', $categoryId);
        }

        $sort = $request->string('sort')->value() ?: 'rating';
        match ($sort) {
            'newest' => $query->latest(),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('rating_avg'),
        };

        $umkms = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('customer.explore', compact('umkms', 'categories'));
    }
}
