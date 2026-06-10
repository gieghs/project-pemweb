@extends('layouts.user')

@section('content')
@php
    $hatCategories = ['Semua Kategori', 'Trucker Cap', 'Flat Cap', 'Bucket Hat', 'Jungle Hat', 'Baseball Cap', 'Snapback', 'Newsboy Cap'];
@endphp

<div class="h-screen w-full bg-cover bg-center bg-no-repeat relative flex flex-col justify-center items-center" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1920&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-black/40 z-0"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-white text-4xl md:text-6xl font-bold tracking-widest uppercase drop-shadow-lg">
            WHITE NORTH STORE
        </h1>
        <p class="text-white text-sm md:text-base tracking-[0.3em] uppercase mt-4 mb-8 drop-shadow-md">
            PREMIUM THRIFTED HEADWEAR
        </p>

        <a href="{{ route('shop') }}" class="bg-white text-black px-10 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-200 transition-colors mt-2 shadow-lg">
            Shop Now
        </a>

    </div>
</div>

<div class="w-full bg-white pt-8 relative group/section">
    <div class="px-8 pb-4 border-b border-gray-200 mb-6 flex justify-between items-center">
        <h2 class="text-[10px] md:text-[11px] font-bold tracking-[0.2em] uppercase text-black">SHOP BY CATEGORIES</h2>
    </div>

    <div class="relative w-full">
        
        <button onclick="slideCategory('left')" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white text-black w-10 h-10 flex items-center justify-center border border-gray-200 shadow-sm hover:bg-black hover:text-white transition-all text-lg opacity-0 group-hover/section:opacity-100 hidden md:flex">
            &#10094;
        </button>

        <div id="category-slider" class="flex overflow-x-auto gap-2 px-8 pb-16 snap-x snap-mandatory scroll-smooth hide-scrollbar relative">
            
            <a href="{{ route('shop', ['category' => 'Trucker Cap']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">TRUCKER CAP</span>
            </a>
            
            <a href="{{ route('shop', ['category' => 'Flat Cap']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1520063802958-ee2bce2bc60c?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">FLAT CAP</span>
            </a>

            <a href="{{ route('shop', ['category' => 'Bucket Hat']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1618354691792-d1d42acfd860?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">BUCKET HAT</span>
            </a>

            <a href="{{ route('shop', ['category' => 'Jungle Hat']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1534062630501-b27b3bba1298?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">JUNGLE HAT</span>
            </a>

            <a href="{{ route('shop', ['category' => 'Snapback']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1556306535-0f09a536f0ab?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">SNAPBACK</span>
            </a>

            <a href="{{ route('shop', ['category' => 'Baseball Cap']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1533827432537-70133748f5c8?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">BASEBALL CAP</span>
            </a>

            <a href="{{ route('shop', ['category' => 'Newsboy Cap']) }}" class="min-w-[70vw] md:min-w-[280px] flex-shrink-0 aspect-[3/4] relative group cursor-pointer overflow-hidden flex items-end justify-center pb-8 snap-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1554568218-0f1715e72254?auto=format&fit=crop&w=500&q=80')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-0 transition-opacity group-hover:opacity-60"></div>
                <span class="relative z-10 text-[11px] text-white tracking-[0.2em] uppercase font-bold group-hover:-translate-y-2 transition-transform duration-300">NEWSBOY CAP</span>
            </a>

        </div>

        <button onclick="slideCategory('right')" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white text-black w-10 h-10 flex items-center justify-center border border-gray-200 shadow-sm hover:bg-black hover:text-white transition-all text-lg opacity-0 group-hover/section:opacity-100 hidden md:flex">
            &#10095;
        </button>

    </div>
</div>

<!-- Why White North Section -->
<section class="w-full px-4 md:px-8 lg:px-12 py-24">
    <h2 class="text-[10px] md:text-[11px] font-bold tracking-[0.2em] uppercase text-black mb-14 text-center md:text-left">WHY WHITE NORTH?</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
            <div class="group border border-black p-8 flex flex-col items-center text-center transition-all duration-200 hover:bg-black hover:text-white cursor-default">
                <svg class="w-8 h-8 mb-6 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase mb-3">Carefully Curated</h3>
                <p class="text-[10px] leading-relaxed text-gray-500 group-hover:text-white/70 transition-colors">Setiap produk dipilih secara selektif untuk menjaga kualitas dan karakter unik.</p>
            </div>

            <div class="group border border-black p-8 flex flex-col items-center text-center transition-all duration-200 hover:bg-black hover:text-white cursor-default">
                <svg class="w-8 h-8 mb-6 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase mb-3">One-of-a-Kind Pieces</h3>
                <p class="text-[10px] leading-relaxed text-gray-500 group-hover:text-white/70 transition-colors">Produk thrift bersifat unik dan tidak diproduksi ulang.</p>
            </div>

            <div class="group border border-black p-8 flex flex-col items-center text-center transition-all duration-200 hover:bg-black hover:text-white cursor-default">
                <svg class="w-8 h-8 mb-6 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase mb-3">Fast WhatsApp Response</h3>
                <p class="text-[10px] leading-relaxed text-gray-500 group-hover:text-white/70 transition-colors">Respon cepat untuk pertanyaan, konfirmasi, dan bantuan pelanggan.</p>
            </div>

            <div class="group border border-black p-8 flex flex-col items-center text-center transition-all duration-200 hover:bg-black hover:text-white cursor-default">
                <svg class="w-8 h-8 mb-6 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase mb-3">Nationwide Shipping</h3>
                <p class="text-[10px] leading-relaxed text-gray-500 group-hover:text-white/70 transition-colors">Pengiriman ke seluruh Indonesia dengan proses yang aman dan terpercaya.</p>
            </div>
        </div>
</section>

<!-- Parallax Collection Banner -->
<div class="relative w-full py-40 bg-cover bg-center bg-fixed" style="background-image: url('https://images.unsplash.com/photo-1550246140-5119ae4790b8?auto=format&fit=crop&w=1920&q=80');">
    <div class="absolute inset-0 bg-black/70 z-0"></div>

    <div class="flex flex-col items-center justify-center px-4 md:px-12 w-full max-w-4xl mx-auto">
        <h2 class="text-white text-sm md:text-xl font-bold tracking-[0.2em] uppercase mb-6 text-center drop-shadow-md">The Story Behind White North</h2>
        <p class="text-white text-xs md:text-sm text-center leading-loose drop-shadow-md font-medium">
            Kami percaya bahwa setiap topi memiliki ceritanya sendiri. White North hadir untuk memberikan kehidupan kedua pada koleksi headwear premium pilihan. Setiap produk dikurasi secara ketat untuk memastikan kualitas, orisinalitas, dan gaya yang merepresentasikan karakter unikmu. Thrift bukan sekadar gaya, melainkan cara kita menghargai nilai dari sebuah karya.
        </p>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function slideCategory(direction) {
        const slider = document.getElementById('category-slider');
        const scrollAmount = 300;
        
        if (direction === 'left') {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }
</script>

@endsection
