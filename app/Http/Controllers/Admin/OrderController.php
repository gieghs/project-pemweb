<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function markPaid($id)
    {
        $order = Order::with('product')->findOrFail($id);
        $order->update(['status' => 'Paid']);

        if ($order->product) {
            $order->product->update([
                'status' => 'sold',
            ]);
        }

        return back()->with('success', 'Pesanan ditandai lunas.');
    }
}