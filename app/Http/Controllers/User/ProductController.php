<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('user.products', [
            'products' => Product::with('images')->latest()->get(),
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('user.product-detail', compact('product'));
    }
}