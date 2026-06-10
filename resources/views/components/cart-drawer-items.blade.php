@if ($globalCart->isEmpty())
    <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300 mb-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
        <p class="text-xs text-gray-500">Keranjang kosong</p>
    </div>
@else
    <div class="flex-1 overflow-y-auto p-6 space-y-4" id="cart-items-list">
        @forelse ($globalCart as $item)
            @php $p = $item->product; @endphp
            <div class="flex gap-3 border-b border-gray-100 pb-4">
                <div class="w-16 h-16 bg-[#f2f2f2] flex-shrink-0">
                    <img src="{{ asset('storage/' . ($p->image ?? $p['image'])) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start gap-2">
                    <h3 class="text-[11px] font-bold uppercase tracking-wider leading-tight">{{ $p->name }}</h3>
                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-700 font-bold text-sm flex items-center justify-center w-6 h-6 rounded-none border border-red-400 hover:border-red-700 hover:bg-red-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </form>
                </div>
                    <p class="text-[11px] font-bold mt-1.5">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                </div>
            </div>
        @empty
    @endforelse
    </div>

    <div class="p-6 border-t border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Total</span>
            <span class="text-sm font-bold">Rp {{ number_format($globalCart->sum(fn ($item) => $item->product->price), 0, ',', '.') }}</span>
        </div>
        <a href="{{ route('checkout') }}"
            class="w-full bg-black text-white py-3.5 text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
            CHECKOUT
        </a>
    </div>
@endif
