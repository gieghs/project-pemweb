<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::sum('price');
        $totalSales = Order::count();
        $avgSalePrice = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        $revenueOverTime = Order::selectRaw('DATE(created_at) as date, SUM(price) as revenue')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $recentSales = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'totalSales', 'avgSalePrice', 'revenueOverTime', 'recentSales'));
    }
}