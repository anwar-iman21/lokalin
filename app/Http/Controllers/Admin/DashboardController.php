<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UmkmProfile;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'total_umkm' => UmkmProfile::count(),
            'pending_umkm' => UmkmProfile::where('status', 'pending')->count(),
            'approved_umkm' => UmkmProfile::where('status', 'approved')->count(),
            'total_orders' => Order::count(),
            'total_transaction_value' => Order::where('status', 'completed')->sum('total'),
        ];

        $recentUmkm = UmkmProfile::latest()->take(5)->get();
        $recentOrders = Order::with(['user', 'umkm'])->latest()->take(8)->get();

        $revenueLast6Months = Order::where('status', 'completed')
            ->where('completed_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(completed_at, '%Y-%m') as month, SUM(total) as total")
            ->groupBy('month')->orderBy('month')->get()->keyBy('month');

        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->translatedFormat('M Y');
            $data[] = (float) ($revenueLast6Months[$key]->total ?? 0);
        }

        return view('admin.dashboard', compact('stats', 'recentUmkm', 'recentOrders', 'labels', 'data'));
    }
}
