@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-16">
    <div class="mb-14">
        <h1 class="text-3xl md:text-4xl font-bold text-black uppercase tracking-wider mb-4">FAQ</h1>
        <p class="text-sm text-gray-500 max-w-lg">Pertanyaan yang sering diajukan tentang belanja di White North Store.</p>
    </div>

    @php
        $faqs = [
            [
                'q' => 'Bagaimana cara melakukan pemesanan?',
                'a' => 'Pemesanan sangat mudah! Cukup login atau daftar akun, pilih produk yang diinginkan, tambahkan ke keranjang, lalu lakukan checkout melalui WhatsApp. Admin kami akan membantu proses selanjutnya.',
            ],
            [
                'q' => 'Bagaimana cara melakukan pembayaran?',
                'a' => 'Pembayaran dilakukan melalui transfer bank ke rekening yang akan diberikan oleh admin setelah Anda menghubungi kami via WhatsApp. Admin akan menginformasikan total pembayaran beserta nomor rekening tujuan.',
            ],
            [
                'q' => 'Kemana saya mengirim bukti pembayaran?',
                'a' => 'Kirim bukti pembayaran (foto atau screenshot) melalui WhatsApp ke nomor admin White North Store. Pastikan bukti terbaca jelas agar dapat diverifikasi dengan cepat.',
            ],
            [
                'q' => 'Bagaimana cara mengetahui total pembayaran?',
                'a' => 'Setelah Anda melakukan checkout dan menghubungi admin via WhatsApp, admin akan membalas dengan rincian pesanan lengkap beserta total yang harus dibayarkan, termasuk biaya pengiriman jika ada.',
            ],
            [
                'q' => 'Berapa lama pesanan diproses?',
                'a' => 'Pesanan diproses dalam 1×24 jam setelah pembayaran diverifikasi. Proses pengiriman tergantung pada jasa ekspedisi yang digunakan dan lokasi tujuan.',
            ],
            [
                'q' => 'Bagaimana cara mengetahui status pesanan?',
                'a' => 'Setelah pesanan dikirim, admin akan mengirimkan nomor resi pengiriman melalui WhatsApp. Anda dapat melacak status pengiriman menggunakan nomor resi tersebut di website jasa ekspedisi terkait.',
            ],
            [
                'q' => 'Apakah bisa membatalkan pesanan?',
                'a' => 'Pembatalan pesanan dapat dilakukan selama pesanan belum diproses. Silakan hubungi admin via WhatsApp sesegera mungkin jika ingin membatalkan pesanan.',
            ],
            [
                'q' => 'Apakah tersedia pengiriman ke luar kota?',
                'a' => 'Ya, kami melayani pengiriman ke seluruh wilayah Indonesia melalui jasa ekspedisi terpercaya seperti JNE, SiCepat, dan J&T. Biaya pengiriman akan disesuaikan dengan lokasi tujuan.',
            ],
            [
                'q' => 'Apakah bisa melakukan retur atau penukaran barang?',
                'a' => 'Retur atau penukaran barang dapat dilakukan jika produk yang diterima rusak, cacat, atau tidak sesuai dengan pesanan. Hubungi admin via WhatsApp maksimal 2×24 jam setelah barang diterima untuk pengajuan retur.',
            ],
            [
                'q' => 'Bagaimana menghubungi admin?',
                'a' => 'Anda dapat menghubungi admin White North Store melalui WhatsApp di nomor +62 812-8558-6116. Kami siap membantu Anda selama jam operasional toko.',
            ],
        ];
    @endphp

    <div class="border-t border-gray-200 divide-y divide-gray-200">
        @foreach ($faqs as $index => $faq)
            <div class="faq-item border-b border-gray-200">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between text-left py-5 px-0 hover:text-gray-600 transition-colors group">
                    <span class="text-sm font-bold uppercase tracking-wider pr-4">{{ $faq['q'] }}</span>
                    <span class="faq-icon flex-shrink-0 text-lg text-gray-400 group-hover:text-black transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                    </span>
                </button>
                <div class="faq-answer overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                    <div class="pb-5 pr-12">
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-14 p-8 border border-gray-200 text-center">
        <p class="text-sm font-bold uppercase tracking-[0.2em] mb-2">Masih ada pertanyaan?</p>
        <p class="text-xs text-gray-500 mb-6">Jangan ragu untuk menghubungi tim kami.</p>
        <a href="https://wa.me/6281285586116" target="_blank"
            class="inline-block bg-black text-white px-8 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">
            Hubungi Kami
        </a>
    </div>
</div>

<script>
    function toggleFaq(button) {
        const item = button.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('.faq-icon svg');
        const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

        document.querySelectorAll('.faq-answer').forEach(el => {
            el.style.maxHeight = '0px';
        });
        document.querySelectorAll('.faq-icon svg').forEach(el => {
            el.style.transform = 'rotate(0deg)';
        });

        if (!isOpen) {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.style.transform = 'rotate(45deg)';
        }
    }
</script>
@endsection
