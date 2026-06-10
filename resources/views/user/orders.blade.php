@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-black uppercase tracking-wider">Pesanan Saya</h1>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-6 text-[11px] uppercase tracking-widest">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="border border-gray-200 p-16 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-300 mb-4"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <p class="text-gray-500 text-sm uppercase tracking-widest">Belum ada pesanan</p>
            <a href="{{ route('shop') }}" class="inline-block mt-6 bg-black text-white px-8 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">Belanja Sekarang</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($orders as $order)
                <div class="border border-gray-200 p-5">
                    <div class="flex items-start justify-between mb-1">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest">Order #{{ $order->id }}</p>
                        </div>
                        @php
                            $statusColors = [
                                'Pending Payment' => 'bg-yellow-100 text-yellow-700',
                                'Paid' => 'bg-blue-100 text-blue-700',
                                'Processing' => 'bg-indigo-100 text-indigo-700',
                                'Shipped' => 'bg-purple-100 text-purple-700',
                                'Completed' => 'bg-green-100 text-green-700',
                                'Cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'Pending Payment' => 'Pending Payment',
                                'Paid' => 'Paid',
                                'Processing' => 'Processing',
                                'Shipped' => 'Shipped',
                                'Completed' => 'Completed',
                                'Cancelled' => 'Cancelled',
                            ];
                            $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                            $label = $statusLabels[$order->status] ?? $order->status;
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 text-[10px] font-bold uppercase tracking-widest {{ $color }} flex-shrink-0 ml-4">{{ $label }}</span>
                    </div>

                    <h3 class="font-bold text-base uppercase tracking-wider truncate mb-1">{{ $order->product_name }}</h3>
                    <p class="text-[11px] text-gray-400 uppercase tracking-widest">{{ $order->created_at->locale('id')->translatedFormat('j F Y, H:i') }}</p>

                    <div class="pt-3 mt-3 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-gray-500 uppercase tracking-widest">Total</span>
                            <span class="font-bold text-base ml-2">Rp {{ number_format(($order->price ?? 0) + ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('user.orders.show', $order->id) }}" class="text-[11px] font-bold tracking-[0.2em] uppercase text-black hover:text-gray-500 transition-colors flex items-center gap-1">
                            Lihat Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @php
            $totalSpent = $orders->sum(fn($o) => ($o->price ?? 0) + ($o->shipping_cost ?? 0));
        @endphp
        <div class="mt-8 bg-black p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Total Pembelanjaan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Pesanan</p>
                    <p class="text-2xl font-bold">{{ $orders->count() }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
