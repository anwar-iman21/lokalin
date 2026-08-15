<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index(Request $request)
    {
        $orders = auth()->user()->umkmProfile->orders()
            ->with(['user', 'items'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('umkm.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeOwnership($order);
        $order->load(['items.product', 'user']);

        return view('umkm.orders.show', compact('order'));
    }

    public function advance(Order $order)
    {
        $this->authorizeOwnership($order);

        try {
            $this->orderService->advanceStatus($order);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Status pesanan diperbarui menjadi "'.$order->statusLabel().'".');
    }

    public function cancel(Request $request, Order $order)
    {
        $this->authorizeOwnership($order);

        try {
            $this->orderService->cancel($order, $request->input('reason', 'Dibatalkan oleh penjual'));
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Pesanan dibatalkan.');
    }

    protected function authorizeOwnership(Order $order): void
    {
        abort_unless($order->umkm_id === auth()->user()->umkmProfile->id, 403);
    }
}
