@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Thank You!</h1>
        <p class="text-gray-500">Your order #{{ $order->id }} has been placed successfully.</p>
    </div>

    <div class="bg-gray-50 p-6 text-center border border-gray-200 mb-6 shadow-sm">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">
            {{ strtoupper($order->payment_method ?? 'bca') == 'QRIS' ? 'PEMBAYARAN QRIS DIPERLUKAN' : 'TRANSFER BANK DIPERLUKAN' }}
        </h2>
        <p class="text-xs text-gray-500 mb-4">Silakan selesaikan pembayaran dengan mentransfer nominal tepat di bawah ini.</p>
        <div class="text-4xl font-bold text-black mb-2">
            Rp {{ number_format($grandTotal, 0, ',', '.') }}
        </div>
    </div>

    <div class="border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
        <h3 class="font-bold text-lg mb-2">Instruksi Pembayaran</h3>
        <p class="text-[11px] text-gray-500 mb-6 border-b border-gray-200 pb-4 leading-relaxed">
            Lakukan pembayaran sesuai nominal tertera. Mohon lakukan pembayaran dalam waktu maksimal 2 jam agar pesanan segera diproses.
        </p>

        <div class="space-y-4 text-sm pb-4 mb-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Bank</span>
                <span class="font-bold uppercase">BCA</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Account Number</span>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-base tracking-wider">1234567890</span>
                    <button onclick="copyToClipboard('1234567890')" class="text-gray-400 hover:text-black transition-colors" title="Salin Rekening">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Account Name</span>
                <span class="font-bold uppercase">WHITE NORTH STORE</span>
            </div>
        </div>

            <div class="space-y-2 text-sm pb-6 mb-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Shipping</span>
                <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pt-2 mt-2">
                <span class="font-bold uppercase text-xs tracking-widest text-black">Total Amount</span>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-base">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    <button onclick="copyToClipboard('{{ $grandTotal }}')" class="text-gray-400 hover:text-black transition-colors" title="Salin Nominal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 text-yellow-800 p-4 text-xs font-semibold rounded">
            PENTING: Sertakan Order ID #{{ $order->id }} ke dalam berita transfer / note pembayaran Anda.
        </div>
    </div>

    <div class="space-y-3">
        <a href="https://wa.me/6281285586116?text=Halo%20Admin%20White%20North%20Store,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20Order%20%23{{ $order->id }}" target="_blank" class="block w-full bg-black text-white text-center py-3.5 font-bold text-sm hover:bg-gray-800 transition-colors">
            Konfirmasi Pembayaran via WhatsApp
        </a>
        <a href="{{ route('home') }}" class="block w-full border border-gray-300 text-black text-center py-3.5 font-bold text-sm hover:bg-gray-50 transition-colors">
            Continue Shopping
        </a>
    </div>
    </div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Berhasil disalin: ' + text);
        }).catch(err => {
            console.error('Gagal menyalin teks: ', err);
        });
    }
</script>
@endsection