<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->currentCart();
        $cart->load(['items.product.umkm']);

        return view('customer.cart', compact('cart'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);
        $quantity = $request->integer('quantity', 1);

        if (! $product->isActive()) {
            return back()->with('error', 'Produk ini sedang tidak tersedia.');
        }

        $cart = $this->currentCart();

        // A cart can only hold products from a single UMKM at a time to
        // keep checkout & delivery simple (one order = one store).
        if ($cart->umkm_id && $cart->umkm_id !== $product->umkm_id) {
            return back()->with('confirm_clear_cart', $product->id);
        }

        if (! $cart->umkm_id) {
            $cart->update(['umkm_id' => $product->umkm_id]);
        }

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $newQty = ($item->exists ? $item->quantity : 0) + $quantity;

        if ($newQty > $product->stock) {
            return back()->with('error', "Stok \"{$product->name}\" tidak mencukupi.");
        }

        $item->quantity = $newQty;
        $item->cart_id = $cart->id;
        $item->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function switchStore(Request $request, Product $product)
    {
        $cart = $this->currentCart();
        $cart->items()->delete();
        $cart->update(['umkm_id' => $product->umkm_id]);

        $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

        return back()->with('success', 'Keranjang sebelumnya dikosongkan, produk baru ditambahkan.');
    }

    public function update(Request $request, $itemId)
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);

        $item = $this->currentCart()->items()->with('product')->findOrFail($itemId);

        if ($request->integer('quantity') > $item->product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $item->update(['quantity' => $request->integer('quantity')]);

        return back();
    }

    public function destroy($itemId)
    {
        $cart = $this->currentCart();
        $cart->items()->where('id', $itemId)->delete();

        if ($cart->items()->count() === 0) {
            $cart->update(['umkm_id' => null]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    protected function currentCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }
}
