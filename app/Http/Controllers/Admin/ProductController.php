<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            $data['image'] = 'https://images.unsplash.com/photo-1534215754734-18e55d13e346?w=400';
        }

        $data['status'] = $request->status ?? 'Available';
        $data['sold'] = $request->sold ?? 0;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function markSold(Request $request, Product $product)
    {
        if ($product->sold) {
            return back()->with('info', 'Produk sudah ditandai terjual');
        }

        $validated = $request->validate([
            'buyer_username' => 'required|string',
        ]);

        $buyer = User::where('username', $validated['buyer_username'])->first();

        if ($buyer) {
            $buyer->orders()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'username' => $buyer->username,
                'price' => $product->price,
                'phone' => $buyer->phone,
                'address' => $buyer->address,
                'status' => 'Pending WA',
            ]);
        }

        $product->update(['sold' => true]);

        return back()->with('success', "Produk {$product->name} ditandai terjual");
    }
}