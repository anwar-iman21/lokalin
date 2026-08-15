<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $umkm = auth()->user()->umkmProfile;

        $stats = [
            'total_products' => $umkm->products()->count(),
            'active_products' => $umkm->products()->where('status', 'active')->count(),
            'pending_orders' => $umkm->orders()->where('status', 'pending')->count(),
            'completed_orders' => $umkm->orders()->where('status', 'completed')->count(),
            'total_revenue' => $umkm->orders()->where('status', 'completed')->sum('total'),
            'rating_avg' => $umkm->rating_avg,
            'rating_count' => $umkm->rating_count,
        ];

        $recentOrders = $umkm->orders()->with('user')->latest()->take(5)->get();

        $salesLast7Days = $umkm->orders()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(completed_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->translatedFormat('d M');
            $chartData[] = (float) ($salesLast7Days[$date]->total ?? 0);
        }

        $topProducts = $umkm->products()->orderByDesc('sold_count')->take(5)->get();

        return view('umkm.dashboard', compact('umkm', 'stats', 'recentOrders', 'chartLabels', 'chartData', 'topProducts'));
    }
}
