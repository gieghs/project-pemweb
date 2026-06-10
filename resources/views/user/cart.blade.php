@extends('layouts.user')

@section('content')
@php
    $user = auth()->user();
    $itemList = '';
    $index = 1;
    foreach ($cartItems ?? [] as $item) {
        $itemProduct = $item->product ?? $item['product'] ?? [];
        $itemName = $itemProduct->name ?? $itemProduct['name'] ?? '';
        $itemPrice = $itemProduct->price ?? $itemProduct['price'] ?? 0;
        $itemList .= ($index) . '. *' . $itemName . '* - Rp ' . number_format($itemPrice, 0, ',', '.') . "\n";
        $index++;
    }
    $waCheckoutMsg = rawurlencode("Halo White North Store! Saya ingin melakukan checkout:\n\n*Username:* " . ($user->username ?? $user->name ?? '') . "\n*Alamat:* " . ($user->address ?? 'Belum diisi') . "\n\n*Daftar Produk:*\n" . $itemList . "\n*Total:* Rp " . number_format($totalPrice ?? 0, 0, ',', '.') . "\n\nMohon info total pembayaran dan nomor rekening tujuan. Terima kasih!");
@endphp
<div class="max-w-4xl mx-auto px-6 py-8">
    <h1 class="text-2xl md:text-3xl font-bold text-black uppercase tracking-wider mb-6">Keranjang</h1>

    @if (session('info'))
        <div class="border border-yellow-200 bg-yellow-50 p-4 mb-6">
            <p class="text-sm text-yellow-800">{{ session('info') }}</p>
        </div>
    @endif

    @if (session('success'))
        <div class="border border-green-200 bg-green-50 p-4 mb-6">
            <p class="text-sm text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if (empty($cartItems) || count($cartItems) === 0)
        <div class="border border-gray-200 p-16 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-300 mb-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            <p class="text-gray-500 text-sm uppercase tracking-widest">Keranjang kosong</p>
            <a href="{{ route('shop') }}" class="inline-block mt-6 border border-black text-black px-6 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-black hover:text-white transition-colors">Belanja Sekarang</a>
        </div>
    @else
        <div class="space-y-3 mb-6">
            @foreach ($cartItems as $item)
                @php
                    $itemProduct = $item->product ?? $item['product'] ?? [];
                    $itemId = $item->id ?? $item['id'];
                @endphp
                <div class="border border-gray-200 p-4">
                    <div class="flex gap-4">
                        <img src="{{ asset('storage/' . ($itemProduct->image ?? $itemProduct['image'])) }}" alt="{{ $itemProduct->name ?? $itemProduct['name'] }}" class="w-24 h-24 object-cover flex-shrink-0" />
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-1">
                                <div class="min-w-0 mr-2">
                                    <h3 class="font-bold text-sm uppercase tracking-wider truncate">{{ $itemProduct->name ?? $itemProduct['name'] }}</h3>
                                    <span class="inline-block bg-black text-white px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest mt-1">{{ $itemProduct->category ?? $itemProduct['category'] }}</span>
                                </div>
                                <form method="POST" action="{{ url('/user/cart/' . $itemId) }}" onsubmit="return confirm('Hapus produk dari keranjang?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors p-1 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                            <p class="text-gray-500 text-xs leading-relaxed line-clamp-1 mt-2">{{ $itemProduct->description ?? $itemProduct['description'] }}</p>
                            <p class="font-bold text-base mt-2">Rp {{ number_format($itemProduct->price ?? $itemProduct['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
