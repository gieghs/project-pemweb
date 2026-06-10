@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold uppercase tracking-widest mb-2">Admin Dashboard</h1>
<p class="text-[11px] font-bold tracking-[0.2em] uppercase text-gray-500 mb-10">Welcome to the control room.</p>

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
    @if ($revenueOverTime->isEmpty())
        <p class="text-gray-400 text-sm text-center py-10">Belum ada data penjualan</p>
    @else
        <div class="relative h-64 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    @endif
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <h3 class="text-sm font-bold uppercase tracking-[0.2em] mb-4">Recent Sales</h3>
    @if ($recentSales->isEmpty())
        <p class="text-gray-400 text-sm text-center py-10">Belum ada data penjualan</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-[10px] font-bold tracking-[0.2em] uppercase text-gray-500">
                        <th class="py-3 px-4">Order ID</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Product</th>
                        <th class="py-3 px-4 text-right">Total</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($recentSales as $sale)
                        <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 font-bold">#{{ $sale->id }}</td>
                            <td class="py-4 px-4">{{ $sale->username }}</td>
                            <td class="py-4 px-4">{{ $sale->product_name }}</td>
                            <td class="py-4 px-4 text-right font-bold">Rp {{ number_format($sale->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-4 text-center">
                                @php
                                    $statusColors = [
                                        'Pending Payment' => 'bg-yellow-100 text-yellow-700',
                                        'Paid' => 'bg-blue-100 text-blue-700',
                                        'Processing' => 'bg-indigo-100 text-indigo-700',
                                        'Shipped' => 'bg-purple-100 text-purple-700',
                                        'Completed' => 'bg-green-100 text-green-700',
                                        'Cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $color = $statusColors[$sale->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 text-[9px] font-bold uppercase tracking-wider {{ $color }}">{{ $sale->status }}</span>
                            </td>
                            <td class="py-4 px-4 text-right text-gray-500 text-xs">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@if ($revenueOverTime->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const data = @json($revenueOverTime);
        
        const labels = data.map(item => item.date);
        const values = data.map(item => item.revenue);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: values,
                    borderColor: '#000000',
                    backgroundColor: 'rgba(0, 0, 0, 0.05)',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#000000',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000) + 'K';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endsection