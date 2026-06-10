@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold uppercase tracking-widest mb-2">Admin Dashboard</h1>
<p class="text-[11px] font-bold tracking-[0.2em] uppercase text-gray-500 mb-10">Welcome to the control room, Giga.</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-500 mb-2">Total Revenue</h3>
        <p class="text-4xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-500 mb-2">Total Sales</h3>
        <p class="text-4xl font-black">{{ $totalSales }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-500 mb-2">Avg Sale Price</h3>
        <p class="text-4xl font-black">Rp {{ number_format($avgSalePrice, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
    <h3 class="text-sm font-bold uppercase tracking-[0.2em] mb-4">Revenue Over Time</h3>
    <p class="text-gray-400 text-sm text-center py-10">Belum ada data penjualan</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <h3 class="text-sm font-bold uppercase tracking-[0.2em] mb-4">Recent Sales</h3>
    <p class="text-gray-400 text-sm text-center py-10">Belum ada data penjualan</p>
</div>
@endsection