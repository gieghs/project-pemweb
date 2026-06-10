@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-16">
    <div class="mb-16 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-black uppercase tracking-wider mb-4">How To Order</h1>
        <p class="text-sm text-gray-500 max-w-lg mx-auto">Ikuti langkah-langkah berikut untuk berbelanja di White North Store.</p>
    </div>

    @php
        $phases = [
            [
                'title' => 'Pilih & Pesan',
                'number' => '01',
                'steps' => [
                    ['icon' => 'user', 'title' => 'Login atau Daftar Akun', 'desc' => 'Masuk ke akun Anda atau daftar jika belum memiliki akun. Klik tombol PROFILE di pojok kiri atas navbar.'],
                    ['icon' => 'bag', 'title' => 'Pilih Produk', 'desc' => 'Jelajahi katalog produk di halaman Shop. Klik produk untuk melihat detail lengkap, foto, dan harga.'],
                    ['icon' => 'cart', 'title' => 'Tambahkan ke Keranjang', 'desc' => 'Klik tombol "ADD TO CART" pada halaman produk. Produk akan tersimpan di keranjang belanja Anda.'],
                    ['icon' => 'checkout', 'title' => 'Checkout', 'desc' => 'Buka halaman keranjang, periksa kembali produk yang dipilih, lalu klik "Checkout via WhatsApp" untuk melanjutkan.'],
                ],
            ],
            [
                'title' => 'Pembayaran',
                'number' => '02',
                'steps' => [
                    ['icon' => 'edit', 'title' => 'Isi Data Pengiriman', 'desc' => 'Lengkapi alamat pengiriman Anda di halaman Profile. Pastikan alamat, nomor telepon, dan data lain sudah benar.'],
                    ['icon' => 'check', 'title' => 'Konfirmasi Pesanan', 'desc' => 'Periksa kembali pesanan Anda. Pastikan produk, jumlah, dan alamat pengiriman sudah sesuai sebelum melanjutkan.'],
                    ['icon' => 'wa', 'title' => 'Hubungi Admin via WhatsApp', 'desc' => 'Setelah checkout, Anda akan diarahkan ke WhatsApp untuk menghubungi admin White North Store secara langsung.'],
                    ['icon' => 'tag', 'title' => 'Admin Memberikan Total', 'desc' => 'Admin akan membalas pesan WhatsApp Anda dengan rincian pesanan dan total pembayaran yang harus dibayarkan.'],
                ],
            ],
            [
                'title' => 'Proses & Kirim',
                'number' => '03',
                'steps' => [
                    ['icon' => 'card', 'title' => 'Lakukan Pembayaran', 'desc' => 'Transfer sejumlah total yang telah disebutkan admin ke rekening yang tertera pada pesan WhatsApp.'],
                    ['icon' => 'upload', 'title' => 'Kirim Bukti Pembayaran', 'desc' => 'Foto atau screenshot bukti transfer, lalu kirimkan melalui WhatsApp ke admin White North Store.'],
                    ['icon' => 'box', 'title' => 'Admin Memproses Pesanan', 'desc' => 'Setelah bukti pembayaran diverifikasi, admin akan segera memproses dan menyiapkan pesanan Anda.'],
                    ['icon' => 'truck', 'title' => 'Pesanan Dikirim', 'desc' => 'Pesanan akan dikirim ke alamat Anda. Admin akan mengirimkan nomor resi pengiriman melalui WhatsApp.'],
                ],
            ],
        ];

        $svgs = [
            'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
            'bag' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
            'cart' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>',
            'checkout' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="m9 13 2 2 4-4"/></svg>',
            'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
            'check' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
            'wa' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
            'tag' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>',
            'card' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
            'upload' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>',
            'box' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8"/><path d="m3 8 4-4h10l4 4"/><path d="M3 8h18"/><path d="M8 12h8"/></svg>',
            'truck' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12v12H9"/><path d="M16 9h3l3 3v5h-2"/></svg>',
        ];
    @endphp

    <div class="space-y-20">
        @foreach ($phases as $phase)
            <div>
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-4xl md:text-5xl font-bold text-gray-200 tracking-tighter">{{ $phase['number'] }}</span>
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold uppercase tracking-wider text-black">{{ $phase['title'] }}</h2>
                        <div class="w-12 h-0.5 bg-black mt-2"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    @foreach ($phase['steps'] as $step)
                        <div class="flex gap-5 p-5 border border-gray-200 hover:border-black transition-colors duration-300 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-black text-white flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                                {!! $svgs[$step['icon']] !!}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1.5">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Step {{ $loop->parent->iteration * 4 - 4 + $loop->iteration }}</span>
                                </div>
                                <h3 class="font-bold text-sm uppercase tracking-wider mb-1.5">{{ $step['title'] }}</h3>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-20 p-8 bg-black text-white text-center">
        <p class="text-sm font-bold uppercase tracking-[0.2em] mb-3">Siap Berbelanja?</p>
        <p class="text-xs text-gray-400 mb-6">Jelajahi koleksi produk terbaru kami sekarang juga.</p>
        <a href="{{ route('shop') }}" class="inline-block border border-white text-white px-8 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-white hover:text-black transition-colors">
            Mulai Belanja
        </a>
    </div>
</div>
@endsection
