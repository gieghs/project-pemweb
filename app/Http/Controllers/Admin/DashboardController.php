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

        return view('admin.dashboard', compact('totalRevenue', 'totalSales', 'avgSalePrice'));
    }
}