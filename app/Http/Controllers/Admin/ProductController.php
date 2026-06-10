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
        $products = Product::with('images')->latest()->get();

        return view('admin.products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'required|string',
        ], [
            'image.required' => 'Foto produk wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto produk maksimal 2 MB.',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'status' => $request->status ?? 'available',
        ];

        $product = Product::create($data);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->images()->create([
                'image_path' => $path,
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function markSold(Request $request, Product $product)
    {
        if ($product->isSold()) {
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

        $product->update(['status' => Product::STATUS_SOLD]);

        return back()->with('success', "Produk {$product->name} ditandai terjual");
    }
}