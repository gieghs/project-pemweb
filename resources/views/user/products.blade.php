@extends('layouts.user')

@section('content')
@php
    $categories = ['Semua Kategori', 'Trucker Cap', 'Flat Cap', 'Bucket Hat', 'Jungle Hat', 'Baseball Cap', 'Snapback', 'Newsboy Cap'];
    $selectedCategory = request('category', 'Semua Kategori');
    $filteredProducts = collect($products ?? [])->filter(function ($p) use ($selectedCategory) {
        $cat = $p->category ?? $p['category'] ?? '';
        return $selectedCategory === 'Semua Kategori' || $cat === $selectedCategory;
    });
@endphp
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-black">Produk</h1>
        <button onclick="document.getElementById('filter-modal').classList.remove('hidden')"
            class="flex items-center gap-2 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="4" y2="4"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="20" y2="20"/><line x1="8" x2="16" y1="8" y2="8"/><line x1="10" x2="14" y1="16" y2="16"/></svg>
            Filter
        </button>
    </div>

    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        @foreach ($categories as $cat)
            <a href="{{ url('/user/products' . ($cat !== 'Semua Kategori' ? '?category=' . urlencode($cat) : '')) }}"
                class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-colors {{ $selectedCategory === $cat ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    @if ($filteredProducts->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
            <p class="text-gray-500">Tidak ada produk ditemukan</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($filteredProducts as $product)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                    onclick="window.location='{{ url('/user/products/' . ($product->id ?? $product['id'])) }}'">
                    <img src="{{ asset('storage/' . ($product->image ?? $product['image'])) }}" alt="{{ $product->name ?? $product['name'] }}" class="w-full h-48 object-cover" />
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-block bg-black text-white px-2 py-1 rounded text-xs font-semibold">{{ $product->category ?? $product['category'] }}</span>
                            <span class="text-xs text-gray-500">ID: {{ $product->id ?? $product['id'] }}</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2">{{ $product->name ?? $product['name'] }}</h3>
                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $product->description ?? $product['description'] }}</p>
                        <p class="font-bold text-xl mb-3">Rp {{ number_format($product->price ?? $product['price'], 0, ',', '.') }}</p>
                        <form action="{{ route('user.cart.store') }}" method="POST" class="w-full" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id ?? $product['id'] }}">
                            <button type="submit" class="w-full bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div id="filter-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white p-6 rounded-lg max-w-sm w-full">
        <h3 class="text-xl font-bold mb-4">Filter Kategori</h3>
        <div class="space-y-2">
            @foreach ($categories as $cat)
                <a href="{{ url('/user/products' . ($cat !== 'Semua Kategori' ? '?category=' . urlencode($cat) : '')) }}"
                    class="w-full text-left px-4 py-2 rounded-lg transition-colors block {{ $selectedCategory === $cat ? 'bg-black text-white' : 'hover:bg-gray-100' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
        <button onclick="document.getElementById('filter-modal').classList.add('hidden')"
            class="w-full mt-4 bg-gray-200 text-black px-4 py-2 rounded-lg hover:bg-gray-300">
            Tutup
        </button>
    </div>
</div>
@endsection
