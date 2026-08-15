<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function index()
    {
        $umkm = auth()->user()->umkmProfile;

        $monthlyRevenue = $umkm->orders()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(completed_at, '%Y-%m') as month, SUM(total) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->translatedFormat('M Y');
            $data[] = (float) ($monthlyRevenue[$key]->total ?? 0);
        }

        $bestSellers = $umkm->products()->orderByDesc('sold_count')->take(5)->get();
        $ordersByStatus = $umkm->orders()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('umkm.analytics', compact('labels', 'data', 'bestSellers', 'ordersByStatus'));
    }
}
