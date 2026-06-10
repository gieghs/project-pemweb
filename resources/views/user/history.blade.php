@extends('layouts.user')

@section('content')
@php $user = auth()->user(); @endphp
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-black uppercase tracking-wider">History Belanja</h1>
    </div>

    @php
        $userOrders = collect($orders ?? [])->sortByDesc(function ($o) {
            return $o->created_at ?? $o['created_at'];
        });
        $totalSpent = $userOrders->sum(function ($o) {
            return $o->price ?? $o['price'];
        });
    @endphp

    @if ($userOrders->isEmpty())
        <div class="border border-gray-200 p-16 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-300 mb-4"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <p class="text-gray-500 text-sm uppercase tracking-widest">Belum ada pembelian</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($userOrders as $order)
                <div class="border border-gray-200 p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-base uppercase tracking-wider truncate">{{ $order->product_name ?? $order['product_name'] }}</h3>
                            <p class="text-[11px] text-gray-400 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($order->created_at ?? $order['created_at'])->locale('id')->translatedFormat('j F Y') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 text-[10px] font-bold uppercase tracking-widest bg-green-100 text-green-700 flex-shrink-0 ml-4">Selesai</span>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[11px] text-gray-500 uppercase tracking-widest">Total Pembayaran</span>
                        <span class="font-bold text-lg">Rp {{ number_format($order->price ?? $order['price'], 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 bg-black p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Total Pembelanjaan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Transaksi</p>
                    <p class="text-2xl font-bold">{{ $userOrders->count() }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
