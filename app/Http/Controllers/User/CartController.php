<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return redirect()->route('shop');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'])
                : redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->sold) {
            return $request->wantsJson()
                ? $this->jsonResponse(false, 'Produk sudah terjual')
                : back()->with('error', 'Produk sudah terjual');
        }

        $exists = auth()->user()->cartItems()
            ->where('product_id', $product->id)
            ->exists();

        if (!$exists) {
            auth()->user()->cartItems()->create([
                'product_id' => $product->id,
            ]);
        }

        if ($request->_checkout) {
            return redirect()->route('checkout');
        }

        if ($request->wantsJson()) {
            $success = !$exists;
            return $this->jsonResponse($success, $success ? 'Produk ditambahkan ke keranjang' : 'Produk sudah ada di keranjang');
        }

        return back()->with(['success' => $exists ? 'Produk sudah ada di keranjang' : 'Produk ditambahkan ke keranjang', 'open_cart' => true]);
    }

    public function destroy($id)
    {
        $cartItem = \App\Models\CartItem::find($id);
        
        if ($cartItem && $cartItem->user_id == auth()->id()) {
            $cartItem->delete();
            return back()->with(['success' => 'Produk berhasil dihapus dari keranjang.', 'open_cart' => true]);
        }

        return back()->with('error', 'Gagal menghapus produk.');
    }

    private function jsonResponse($success, $message)
    {
        $cartItems = auth()->user()->cartItems()
            ->with('product')
            ->get()
            ->filter(fn ($item) => $item->product && !$item->product->sold)
            ->values();

        $totalPrice = $cartItems->sum(fn ($item) => $item->product->price);

        $itemsHtml = view('components.cart-drawer-items', compact('cartItems', 'totalPrice'))->render();

        return response()->json([
            'success' => $success,
            'message' => $message,
            'itemsHtml' => $itemsHtml,
        ]);
    }
}
