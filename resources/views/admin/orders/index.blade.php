@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold uppercase tracking-widest mb-8">Orders</h1>

@if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b text-xs uppercase text-gray-500 font-bold">
                    <th class="p-4 text-left">Order ID</th>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Shipping Details</th>
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4 text-left">Price</th>
                    <th class="p-4 text-left">Date</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr class="border-b border-gray-100 last:border-0">
                    <td class="p-4 text-sm font-medium">#{{ $order->id }}</td>
                    <td class="p-4 text-sm">{{ $order->username }}</td>
                    <td class="p-4 text-sm">{{ $order->phone ?? '-' }}</td>
                    <td class="p-4 align-top">
                        <div class="text-sm font-medium text-black">{{ $order->address ?? '-' }}</div>
                        @if ($order->city || $order->province)
                        <div class="text-xs text-gray-500 mt-1">
                            @if ($order->district)Kec. {{ $order->district }}, @endif{{ $order->city ?? '' }}<br>
                            {{ $order->province ?? '' }}@if ($order->postal_code) - {{ $order->postal_code }}@endif
                        </div>
                        @endif
                    </td>
                    <td class="p-4 text-sm">{{ $order->product_name }}</td>
                    <td class="p-4 text-sm">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                    <td class="p-4 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="p-4">
                        @if ($order->status === 'Paid')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">{{ $order->status }}</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if ($order->status !== 'Paid')
                            <form action="{{ route('admin.orders.markPaid', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-black font-bold text-sm hover:underline" onclick="return confirm('Tandai pesanan ini sudah dibayar?')">
                                    Mark as Paid
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="p-10 text-center">
                        <p class="text-gray-400 text-sm">Belum ada data penjualan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection