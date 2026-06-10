@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8">

    {{-- Status Badge --}}
    @php
        $statusColors = [
            'Pending Payment' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'Paid' => 'bg-blue-100 text-blue-700 border-blue-200',
            'Processing' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
            'Shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
            'Completed' => 'bg-green-100 text-green-700 border-green-200',
            'Cancelled' => 'bg-red-100 text-red-700 border-red-200',
        ];
        $statusLabels = [
            'Pending Payment' => 'Pending Payment',
            'Paid' => 'Paid',
            'Processing' => 'Processing',
            'Shipped' => 'Shipped',
            'Completed' => 'Completed',
            'Cancelled' => 'Cancelled',
        ];
        $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
        $label = $statusLabels[$order->status] ?? $order->status;
    @endphp

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold uppercase tracking-wider">Order #{{ $order->id }}</h1>
        <span class="inline-flex items-center px-4 py-2 text-[10px] font-bold uppercase tracking-widest border {{ $color }}">{{ $label }}</span>
    </div>

    {{-- Product --}}
    <div class="border border-gray-200 p-5 mb-4">
        <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-4">Produk</h3>
        <div class="flex items-center gap-4">
            @if ($order->product && $order->product->image)
                <div class="w-20 h-20 flex-shrink-0 bg-gray-50">
                    <img src="{{ $order->product->imageUrl() }}" alt="{{ $order->product_name }}" class="w-full h-full object-cover mix-blend-multiply">
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <h4 class="font-bold text-base uppercase tracking-wider truncate">{{ $order->product_name }}</h4>
                <p class="text-sm font-bold mt-1">Rp {{ number_format($order->price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Payment Info --}}
    <div class="border border-gray-200 p-5 mb-4">
        <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-4">Pembayaran</h3>
        <div class="space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Metode Pembayaran</span>
                <span class="font-bold uppercase">{{ $order->payment_method ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Harga Produk</span>
                <span>Rp {{ number_format($order->price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Ongkos Kirim</span>
                <span>Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm font-bold pt-3 border-t border-gray-100">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format(($order->price ?? 0) + ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Shipping Address --}}
    @if ($order->address)
    <div class="border border-gray-200 p-5 mb-4">
        <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-4">Alamat Pengiriman</h3>
        <div class="space-y-2 text-sm">
            <p class="font-bold">{{ $order->username }}</p>
            <p class="text-gray-600">{{ $order->phone }}</p>
            <p class="text-gray-600">{{ $order->address }}</p>
            <p class="text-gray-600">
                {{ $order->district ? $order->district . ', ' : '' }}{{ $order->city ? $order->city . ', ' : '' }}{{ $order->province ?? '' }}
                {{ $order->postal_code ? ' ' . $order->postal_code : '' }}
            </p>
        </div>
    </div>
    @endif

    <a href="{{ route('user.orders.index') }}" class="block w-full border border-black text-black py-4 text-[11px] font-bold tracking-[0.2em] uppercase text-center hover:bg-black hover:text-white transition-all duration-200">
        &larr; Kembali ke Pesanan Saya
    </a>
</div>
@endsection
