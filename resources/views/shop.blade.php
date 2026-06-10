@extends('layouts.user')

@section('content')
<div class="px-8 mb-8 border-b border-gray-200 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-[9px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-6 flex gap-2">
            <a href="{{ url('/') }}" class="hover:text-black">HOME</a> <span>></span>
            <a href="{{ route('shop') }}" class="hover:text-black">SHOP</a>
            @if(strtoupper($currentCategory) !== 'ALL PRODUCTS' && strtoupper($currentCategory) !== 'ALL')
                <span>></span> <span class="text-black">{{ $currentCategory }}</span>
            @endif
        </div>
        
        <h1 class="text-3xl md:text-5xl font-extrabold uppercase tracking-widest mb-8">{{ $currentCategory }}</h1>
        <div class="flex justify-between items-center text-[10px] font-bold tracking-[0.2em] uppercase border-t border-gray-200 pt-4">
            <span>{{ $availableProducts->count() }} PRODUCT(S)</span>
            <button onclick="document.getElementById('filter-modal').classList.toggle('hidden')" class="hover:text-gray-500 transition-colors flex items-center gap-2">
                FILTERS <span class="text-lg"></span>
            </button>
        </div>
    </div>
</div>

<div class="px-8 pb-16">
    <div class="max-w-7xl mx-auto">
        @if ($availableProducts->isEmpty())
            <div class="bg-white border border-gray-200 p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-300 mb-4"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <p class="text-gray-500 text-[11px] tracking-[0.2em] uppercase">Tidak ada produk di kategori ini</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($availableProducts as $product)
                <div class="group flex flex-col mb-8">
                    <a href="{{ url('/user/products/' . $product->id) }}" class="relative block w-full aspect-square bg-gray-50 overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                    </a>
                    <div class="flex flex-col mt-4">
                        <a href="{{ url('/user/products/' . $product->id) }}" class="text-sm font-bold text-black uppercase tracking-widest hover:text-gray-500 transition-colors">
                            {{ $product->name }}
                        </a>
                        <span class="text-sm text-gray-600 mt-1">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div id="filter-modal" class="hidden fixed inset-0 bg-black/50 flex items-end md:items-center justify-center p-4 z-[130]">
    <div class="bg-white w-full md:max-w-md max-h-[80vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-sm font-bold tracking-[0.2em] uppercase">FILTER & SORT</h3>
            <button onclick="document.getElementById('filter-modal').classList.add('hidden')" class="text-gray-500 hover:text-black text-xl">&times;</button>
        </div>
        <form method="GET" action="{{ route('shop') }}" class="p-6 space-y-6">
            <div class="mb-8">
                <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase mb-4 text-black">SORT BY</h3>
                <div class="grid grid-cols-2 gap-2">
                    @php $sortOptions = ['default' => 'SELECTED', 'price_asc' => 'PRICE LOW TO HIGH', 'price_desc' => 'PRICE HIGH TO LOW', 'newest' => 'NEW IN']; @endphp
                    @foreach ($sortOptions as $sortVal => $sortLabel)
                        <label class="cursor-pointer w-full">
                            <input type="radio" name="sort" value="{{ $sortVal }}" class="hidden peer" {{ (request('sort') == $sortVal) || (!request('sort') && $sortVal == 'default') ? 'checked' : '' }}>
                            <div class="border border-black p-3 text-center text-[10px] font-bold tracking-[0.1em] uppercase peer-checked:bg-black peer-checked:text-white transition-colors">{{ $sortLabel }}</div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase mb-4 text-black">CATEGORY</h3>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer w-full">
                        <input type="radio" name="category" value="ALL" class="hidden peer" {{ request('category') == 'ALL' || !request('category') ? 'checked' : '' }}>
                        <div class="border border-black p-3 text-center text-[10px] font-bold tracking-[0.1em] uppercase peer-checked:bg-black peer-checked:text-white transition-colors">ALL</div>
                    </label>
                    @php
                        $categories = ['Trucker Cap', 'Flat Cap', 'Bucket Hat', 'Jungle Hat', 'Snapback', 'Baseball Cap', 'Newsboy Cap'];
                    @endphp
                    @foreach ($categories as $cat)
                        <label class="cursor-pointer w-full">
                            <input type="radio" name="category" value="{{ $cat }}" class="hidden peer" {{ request('category') == $cat ? 'checked' : '' }}>
                            <div class="border border-black p-3 text-center text-[10px] font-bold tracking-[0.1em] uppercase peer-checked:bg-black peer-checked:text-white transition-colors">{{ strtoupper($cat) }}</div>
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <h4 class="font-bold text-[11px] tracking-[0.2em] uppercase mb-3">PRICE RANGE</h4>
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-500 uppercase tracking-[0.2em] block mb-1">Min</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                            class="w-full px-4 py-3 border border-gray-300 focus:border-black outline-none text-sm" placeholder="0">
                    </div>
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-500 uppercase tracking-[0.2em] block mb-1">Max</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                            class="w-full px-4 py-3 border border-gray-300 focus:border-black outline-none text-sm" placeholder="1000000">
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex gap-3 -mx-6 -mb-6">
                <a href="{{ route('shop') }}" class="flex-1 px-6 py-3 border border-black text-black text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-100 transition-colors text-center">RESET</a>
                <button type="submit" class="flex-1 px-6 py-3 bg-black text-white text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">APPLY</button>
            </div>
        </form>
    </div>
</div>
@endsection
