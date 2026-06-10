<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('product')
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = auth()->user()->orders()
            ->with('product')
            ->findOrFail($id);

        $hasReviewed = auth()->user()->reviews()->exists();

        return view('user.order-detail', compact('order', 'hasReviewed'));
    }
}