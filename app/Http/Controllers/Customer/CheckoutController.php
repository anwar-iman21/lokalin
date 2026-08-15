<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Models\Cart;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function show()
    {
        $cart = Cart::with(['items.product', 'umkm'])->firstOrCreate(['user_id' => auth()->id()]);

        if ($cart->items->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang Anda kosong.');
        }

        return view('customer.checkout', compact('cart'));
    }

    public function store(CheckoutRequest $request)
    {
        $cart = Cart::with('items.product')->firstOrCreate(['user_id' => auth()->id()]);

        try {
            $order = $this->orderService->createFromCart($cart, $request->validated());
        } catch (\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('customer.orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
    }
}
