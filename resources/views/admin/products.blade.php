@extends('layouts.admin')

@section('content')
@php
    $hatCategories = ['Trucker Cap', 'Flat Cap', 'Bucket Hat', 'Jungle Hat', 'Baseball Cap', 'Snapback', 'Newsboy Cap'];
@endphp

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold uppercase tracking-widest">Products</h1>
    <button onclick="document.getElementById('add-product-form').classList.toggle('hidden')"
        class="bg-black text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-800 transition-colors">
        + Add Product
    </button>
</div>

<div id="add-product-form" class="hidden bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
    <h3 class="text-xl font-bold mb-4">Add New Product</h3>
    <form method="POST" action="{{ url('/admin/products') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none" required />
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none" rows="3" required>{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Price (Rp)</label>
            <input type="number" name="price" value="{{ old('price') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none" required />
            @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">UPLOAD FOTO PRODUK</label>
            <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-2">1 foto wajib diunggah.<br>Maks. 2 MB (JPG, JPEG, PNG, WEBP)</p>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none" required />
            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select name="category"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none" required>
                @foreach ($hatCategories as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">Save</button>
            <button type="button" onclick="document.getElementById('add-product-form').classList.add('hidden')" class="bg-gray-200 text-black px-6 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse ($products ?? [] as $product)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name ?? $product['name'] }}" class="w-full h-48 object-cover" />
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="inline-block bg-black text-white px-2 py-1 rounded text-xs font-semibold">{{ $product->category ?? $product['category'] }}</span>
                    <span class="text-xs text-gray-500">ID: {{ $product->id ?? $product['id'] }}</span>
                </div>
                <h3 class="font-bold text-lg mb-2">{{ $product->name ?? $product['name'] }}</h3>
                <p class="text-lg font-bold mb-1">Rp {{ number_format($product->price ?? $product['price'], 0, ',', '.') }}</p>

                @php $pStatus = $product->status ?? $product['status'] ?? 'available'; @endphp
                @if ($pStatus === 'sold')
                    <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-center font-semibold flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Sold
                    </div>
                @else
                    <button onclick="openSoldModal('{{ $product->id ?? $product['id'] }}', '{{ addslashes($product->name ?? $product['name']) }}', {{ $product->price ?? $product['price'] }})"
                        class="w-full bg-black text-white py-2 rounded-lg mt-4 hover:bg-gray-800 transition-colors">
                        Mark as Sold
                    </button>
                @endif
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500 py-12 col-span-full">No products yet</p>
    @endforelse
</div>

<div id="sold-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Konfirmasi Penjualan</h3>
        <p class="text-gray-600 mb-1">Product:</p>
        <p class="font-bold mb-4" id="sold-product-name"></p>

        <form method="POST" action="" id="sold-form" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buyer Username</label>
                <input type="text" name="buyer_username" id="sold-buyer-username"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none"
                    placeholder="Enter buyer username" required />
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm text-gray-600">Final Price:</p>
                <p class="font-bold text-lg" id="sold-final-price"></p>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">Confirm Sale</button>
                <button type="button" onclick="document.getElementById('sold-modal').classList.add('hidden')" class="flex-1 bg-gray-200 text-black px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openSoldModal(productId, productName, productPrice) {
    document.getElementById('sold-product-name').textContent = productName;
    document.getElementById('sold-final-price').textContent = 'Rp ' + productPrice.toLocaleString('id-ID');
    document.getElementById('sold-form').action = '/admin/products/' + productId + '/sold';
    document.getElementById('sold-modal').classList.remove('hidden');
}
</script>
@endsection