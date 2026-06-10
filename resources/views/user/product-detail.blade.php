@extends('layouts.user')

@section('content')
<div class="px-8 pb-24 max-w-7xl mx-auto flex flex-col md:flex-row gap-12 text-black">
    
    <div class="w-full md:w-[55%] flex flex-col gap-4">
         <div id="image-container" class="w-full aspect-[4/5] relative overflow-hidden cursor-zoom-in group" onmousemove="zoomImage(event)" onmouseleave="resetZoom()">
        <img id="main-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-multiply transition-transform duration-200 origin-center">
    </div>
    
         <div class="grid grid-cols-4 gap-4">
                 <button onclick="changeImage('{{ asset('storage/' . $product->image) }}')" class="aspect-square border border-transparent hover:border-black focus:border-black transition-colors">
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover mix-blend-multiply" alt="Depan">
        </button>
        
                 @if($product->image_2)
        <button onclick="changeImage('{{ asset('storage/' . $product->image_2) }}')" class="aspect-square border border-transparent hover:border-black focus:border-black transition-colors">
            <img src="{{ asset('storage/' . $product->image_2) }}" class="w-full h-full object-cover mix-blend-multiply" alt="Samping Kiri">
        </button>
        @endif
    </div>
</div>

    <div class="w-full md:w-[45%] flex flex-col">
        <div class="text-[9px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-8 border-b border-gray-200 pb-4 flex gap-2">
            <a href="{{ route('shop') }}" class="hover:text-black">SHOP</a> <span>/</span> <span class="text-black">TRUCKER CAP</span>
        </div>
        
        <h1 class="text-2xl font-bold uppercase tracking-wider mb-2">{{ $product->name }}</h1>
        <p class="text-sm font-bold mb-10">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        <form action="{{ route('user.cart.store') }}" method="POST" class="w-full">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            @auth
                <button type="submit" class="w-full bg-black text-white py-5 text-[11px] font-bold tracking-[0.2em] uppercase mb-3 hover:bg-gray-800 transition-colors">
                    ADD TO CART
                </button>
            @else
                <button type="button" onclick="showLoginModal()" class="w-full bg-black text-white py-5 text-[11px] font-bold tracking-[0.2em] uppercase mb-3 hover:bg-gray-800 transition-colors">
                    ADD TO CART
                </button>
            @endauth
        </form>
        
        <form action="{{ route('user.cart.store') }}" method="POST" class="w-full">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="_checkout" value="1">
            
            @auth
                <button type="submit" class="w-full bg-white text-black border border-black py-5 text-[11px] font-bold tracking-[0.2em] uppercase text-center flex justify-center items-center hover:bg-black hover:text-white transition-all duration-300 rounded-none mb-10">
                    CHECKOUT
                </button>
            @else
                <button type="button" onclick="showLoginModal()" class="w-full bg-white text-black border border-black py-5 text-[11px] font-bold tracking-[0.2em] uppercase text-center flex justify-center items-center hover:bg-black hover:text-white transition-all duration-300 rounded-none mb-10">
                    CHECKOUT
                </button>
            @endauth
        </form>

        <div class="border-t border-gray-200 pt-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase">DESCRIPTION</h3>
                <span>&minus;</span>
            </div>
            <p class="text-xs text-gray-500 leading-loose">
                {{ $product->description }}
            </p>
        </div>
    </div>
</div>
@endsection

<script>
    function changeImage(src) {
        document.getElementById('main-image').src = src;
    }

    function zoomImage(event) {
        const container = document.getElementById('image-container');
        const img = document.getElementById('main-image');
        
        const rect = container.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        
        const xPercent = (x / rect.width) * 100;
        const yPercent = (y / rect.height) * 100;
        
        img.style.transformOrigin = xPercent + '% ' + yPercent + '%';
        img.style.transform = "scale(2.2)";
    }

    function resetZoom() {
        const img = document.getElementById('main-image');
        img.style.transformOrigin = "center center";
        img.style.transform = "scale(1)";
    }
</script>
