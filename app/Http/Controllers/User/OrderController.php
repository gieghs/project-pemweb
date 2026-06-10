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
            ->latest()
            ->get();

        return view('user.history', compact('orders'));
    }

    public function store(Request $request)
    {
        $cartItems = auth()->user()->cartItems()
            ->with('product')
            ->get()
            ->filter(fn ($item) => $item->product && !$item->product->sold);

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'Keranjang kosong']);
        }

        foreach ($cartItems as $item) {
            auth()->user()->orders()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'username' => auth()->user()->username,
                'price' => $item->product->price,
            ]);

            $item->product->update(['sold' => true]);
            $item->delete();
        }

        return redirect()->route('user.history.index')
            ->with('success', 'Checkout berhasil! Silakan hubungi admin via WhatsApp untuk pembayaran.');
    }
}