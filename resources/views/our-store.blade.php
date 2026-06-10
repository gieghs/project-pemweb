@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="mb-14">
        <h1 class="text-3xl md:text-4xl font-bold text-black uppercase tracking-wider mb-4">Our Store</h1>
    </div>

    <div class="flex flex-col md:flex-row gap-10">
        <div class="w-full md:w-[45%]">
            <div class="border border-gray-200 divide-y divide-gray-100">
                <div class="flex items-start gap-4 p-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-black flex-shrink-0 mt-0.5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-1">Alamat</p>
                        <p class="text-sm text-black">Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota Bandung, Jawa Barat 40123</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-black flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-1">Jam Operasional</p>
                        <p class="text-sm text-black">Senin — Sabtu: 09:00 — 21:00 WIB</p>
                        <p class="text-sm text-black">Minggu & Hari Libur: 10:00 — 18:00 WIB</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-black flex-shrink-0 mt-0.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-1">WhatsApp</p>
                        <a href="https://wa.me/6281285586116" target="_blank" class="text-sm text-black hover:text-gray-600 transition-colors">+62 812-8558-6116</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-[55%]">
            <div id="store-map" class="w-full h-[400px] rounded-lg border border-gray-200 z-0 relative"></div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('store-map').setView([-6.939816588909175, 107.7198329958154], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        L.marker([-6.939816588909175, 107.7198329958154]).addTo(map)
            .openPopup();
    });
</script>
@endsection
