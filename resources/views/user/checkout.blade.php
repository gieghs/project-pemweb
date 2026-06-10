@extends('layouts.user')

@section('content')


<div class="max-w-7xl mx-auto px-8 pt-32 pb-24 flex flex-col lg:flex-row gap-12 bg-white text-black">

    @if (session('error'))
        <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-6 text-[11px] uppercase tracking-widest">
            {{ session('error') }}
        </div>
    @endif

    <!-- Left Column - Contact & Shipping -->
    <div class="w-full lg:w-2/3">
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout_form">
            @csrf
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-6 text-[11px] uppercase tracking-widest">
            <strong>Gagal memproses pesanan:</strong>
            <ul class="list-disc pl-5 mt-2 font-normal">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-xs font-bold tracking-[0.2em] uppercase">CONTACT INFORMATION</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Username</label>
                    <input type="text" name="name" value="{{ auth()->user()->username ?? auth()->user()->name ?? '' }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                </div>
            </div>

            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-xs font-bold tracking-[0.2em] uppercase">SHIPPING ADDRESS</h2>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-[10px] font-bold tracking-[0.1em] uppercase block mb-1.5">Country</label>
                    <select class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black focus:ring-0 rounded-none bg-[#f8f9fa]">
                        <option>Indonesia</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Province</label>
                    <select id="province_select" name="province" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">City</label>
                    <select id="city_select" name="city" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">District</label>
                    <select id="district_select" name="district" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="province_name" id="province_name">
            <input type="hidden" name="city_name" id="city_name">
            <input type="hidden" name="subdistrict_name" id="subdistrict_name">

            <div class="mb-4">
                <label class="text-[10px] font-bold tracking-[0.1em] uppercase block mb-1.5">Full Address</label>
                <textarea name="address" required class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa] h-24" placeholder="Detail jalan, nomor rumah, RT/RW..."></textarea>
            </div>

            <div class="mb-8">
                <label class="text-[10px] font-bold tracking-[0.2em] uppercase block mb-1.5">Postal Code</label>
                <input type="text" id="postal_code_input" name="postal_code" required class="w-full md:w-1/2 border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
            </div>

            <div id="shipping_method_section" class="hidden mt-8">
                <h2 class="text-[10px] font-bold tracking-[0.2em] uppercase border-b border-gray-200 pb-2 mb-4">SHIPPING METHOD</h2>
                <div id="shipping_options_container" class="flex flex-col gap-4">
                </div>
            </div>
    </div>

    <!-- Right Column - Order Summary & Payment -->
    <div class="w-full lg:w-1/3">
        <div class="border border-black p-6 sticky top-24">
            <h2 class="text-[10px] font-bold tracking-[0.2em] uppercase border-b border-gray-200 pb-2 mb-4">ORDER SUMMARY</h2>
            
            <div class="border-b border-gray-200 pb-4 mb-4 flex flex-col gap-4">
                @php $subtotal = 0; @endphp
                @forelse($cartItems as $item)
                    @php 
                        $itemPrice = $item->product->price ?? $item->product->harga ?? 0;
                        $itemQty = $item->quantity ?? $item->qty ?? 1;
                        
                        $itemTotal = $itemPrice * $itemQty;
                        $subtotal += $itemTotal; 
                    @endphp
                    <div class="flex justify-between text-[11px] font-bold uppercase mb-2">
                        <span>{{ $item->product->name ?? $item->product->nama_produk ?? 'Produk' }} <br><span class="text-gray-500 font-normal">QTY: {{ $itemQty }}</span></span>
                        <span>Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-[11px] text-gray-500 uppercase tracking-widest">Keranjang belanja kosong.</p>
                @endforelse
            </div>

            <div class="flex justify-between text-[11px] mb-2 text-gray-500">
                <span>Subtotal</span>
                <span id="subtotal_display" data-value="{{ $subtotal }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-[11px] mb-4 text-gray-500 border-b border-gray-200 pb-4">
                <span>Shipping</span>
                <span id="shipping_display">Rp 0</span>
            </div>
            <div class="flex justify-between text-sm font-bold uppercase mb-8">
                <span>Total</span>
                <span id="total_display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            <h2 class="text-xs font-bold tracking-[0.2em] uppercase mb-4 border-b border-gray-200 pb-4">PAYMENT METHOD</h2>

            <div class="space-y-3 mb-6">
                <label class="flex items-center gap-4 border border-gray-300 p-4 mb-2 cursor-pointer hover:border-black transition-colors">
                    <input type="radio" name="payment_method" value="bca" required class="w-4 h-4 text-black focus:ring-black">
                    <span class="text-[11px] font-bold tracking-[0.1em] uppercase">BCA BANK TRANSFER</span>
                </label>
                <label class="flex items-center gap-4 border border-gray-300 p-4 mb-4 cursor-pointer hover:border-black transition-colors">
                    <input type="radio" name="payment_method" value="qris" required class="w-4 h-4 text-black focus:ring-black">
                    <span class="text-[11px] font-bold tracking-[0.1em] uppercase">QRIS</span>
                </label>
            </div>

<button type="submit" class="w-full bg-black text-white font-bold text-[11px] tracking-[0.2em] uppercase py-4 hover:bg-gray-800 transition-colors">
    PLACE ORDER
</button>
</form>
</div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province_select');
    const citySelect = document.getElementById('city_select');
    const districtSelect = document.getElementById('district_select');
    const shippingSection = document.getElementById('shipping_method_section');
    const shippingContainer = document.getElementById('shipping_options_container');
    const postalCodeInput = document.getElementById('postal_code_input');
    const baseSubtotal = parseInt(document.getElementById('subtotal_display').getAttribute('data-value')) || 0;
    const shippingDisplay = document.getElementById('shipping_display');
    const totalDisplay = document.getElementById('total_display');

    const provinceNameInput = document.getElementById('province_name');
    const cityNameInput = document.getElementById('city_name');
    const subdistrictNameInput = document.getElementById('subdistrict_name');
    let globalCities = [];

    // 1. Ambil data Provinsi
    fetch('/api/location/provinces')
        .then(res => res.json())
        .then(data => {
            let provinces = data.data || data; 
            if(provinces && Array.isArray(provinces)) {
                provinces.sort((a, b) => a.name.localeCompare(b.name));
                provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                provinces.forEach(prov => {
                    provinceSelect.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
                });
            }
        })
        .catch(err => console.error("Error Provinces:", err));

    // 2. Ambil Kota saat Provinsi dipilih
    provinceSelect.addEventListener('change', function() {
        citySelect.innerHTML = '<option value="">Loading...</option>';
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        shippingSection.classList.add('hidden');
        provinceNameInput.value = this.options[this.selectedIndex]?.text || '';
        cityNameInput.value = '';
        subdistrictNameInput.value = '';
        
        if(!this.value) return;

        fetch(`/api/location/cities/${this.value}`)
            .then(res => res.json())
            .then(data => {
                globalCities = data.data || data;
                citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                if(globalCities && Array.isArray(globalCities)) {
                    globalCities.sort((a, b) => a.name.localeCompare(b.name));
                    globalCities.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                }
            });
    });

    // 3. Ambil Kecamatan saat Kota dipilih
    citySelect.addEventListener('change', function() {
        districtSelect.innerHTML = '<option value="">Loading...</option>';
        shippingSection.classList.add('hidden');
        cityNameInput.value = this.options[this.selectedIndex]?.text || '';
        subdistrictNameInput.value = '';
        
        let selectedCity = globalCities.find(c => c.id == this.value);

        if(selectedCity && postalCodeInput) {
            let postal = selectedCity.postal_code || selectedCity.postal || selectedCity.zip_code || "";
            postalCodeInput.value = postal;
        }

        if(!this.value) return;

        fetch(`/api/location/districts/${this.value}`)
            .then(res => res.json())
            .then(data => {
                let districts = data.data || data;
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                if(districts && Array.isArray(districts)) {
                    districts.sort((a, b) => a.name.localeCompare(b.name));
                    districts.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                }
            });
    });

    // 4. Hitung Ongkir saat Kecamatan dipilih
    districtSelect.addEventListener('change', function() {
        subdistrictNameInput.value = this.options[this.selectedIndex]?.text || '';
        if(!this.value) {
            shippingSection.classList.add('hidden');
            return;
        }

        shippingSection.classList.remove('hidden');
        shippingContainer.innerHTML = '<p class="text-[11px] animate-pulse uppercase tracking-widest text-gray-500">Menghitung ongkos kirim...</p>';

        fetch(`/api/shipping/cost?destination_id=${this.value}&courier=jne`)
            .then(res => res.json())
            .then(data => {
                shippingContainer.innerHTML = ''; 
                
                let costsArray = data.data || [];
                
                if(Array.isArray(costsArray) && costsArray.length > 0) {
                    costsArray.forEach(layanan => {
                        let namaLayanan = layanan.service || "REG";
                        let kurir = layanan.code ? layanan.code.toUpperCase() : "JNE";
                        
                        // FILTER VIP: Hanya izinkan layanan reguler dan kilat (termasuk versi dalam kota)
                        let layananUpper = namaLayanan.toUpperCase();
                        const allowedServices = ['REG', 'YES', 'CTC', 'CTCYES'];
                        
                        if (!allowedServices.includes(layananUpper)) {
                            return; // Lewati semua layanan selain 4 ini
                        }

                        let harga = 0;
                        if (Array.isArray(layanan.cost) && layanan.cost.length > 0) {
                            harga = layanan.cost[0].value || 0; 
                        } else {
                            harga = layanan.cost || layanan.price || layanan.value || 0; 
                        }

                        let etdMentah = layanan.etd || "-";
                        let etdBersih = etdMentah.toString().replace(/day|hari/gi, '').trim();
                        
                        shippingContainer.innerHTML += `
                            <label class="flex items-center justify-between border border-gray-300 p-4 mb-2 cursor-pointer hover:border-black transition-colors">
                                <div class="flex items-center gap-4">
                                    <input type="radio" name="shipping_cost" value="${harga}" required class="w-4 h-4 text-black focus:ring-black">
                                    <div>
                                        <p class="text-[11px] font-bold tracking-[0.1em] uppercase">${kurir} - ${namaLayanan}</p>
                                        <p class="text-[10px] text-gray-500 mt-1 uppercase">Estimasi ${etdBersih} Hari</p>
                                    </div>
                                </div>
                                <span class="font-bold text-[13px] tracking-wider">Rp ${new Intl.NumberFormat('id-ID').format(harga)}</span>
                            </label>
                        `;
                    });
                } else {
                    shippingContainer.innerHTML = '<p class="text-[11px] text-red-500 tracking-wider uppercase">Layanan tidak tersedia untuk wilayah ini.</p>';
                }
            })
            .catch(err => {
                console.warn("API limit tercapai, menggunakan data simulasi.");
                shippingContainer.innerHTML = '';
                // Mock Data Simulasi
                const mockCosts = [{service: "REG", price: 14000, etd: "2-3"}, {service: "CTC", price: 8000, etd: "1-2"}];
                mockCosts.forEach(layanan => {
                    shippingContainer.innerHTML += `
                        <label class="flex items-center justify-between border border-gray-300 p-4 mb-2 cursor-pointer hover:border-black transition-colors">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="shipping_cost" value="${layanan.price}" required class="w-4 h-4 text-black focus:ring-black">
                                <div>
                                    <p class="text-[11px] font-bold tracking-[0.1em] uppercase">JNE - ${layanan.service}</p>
                                    <p class="text-[10px] text-gray-500 mt-1 uppercase">Estimasi ${layanan.etd} Hari</p>
                                </div>
                            </div>
                            <span class="font-bold text-[13px] tracking-wider">Rp ${new Intl.NumberFormat('id-ID').format(layanan.price)}</span>
                        </label>
                    `;
                });
            });
    });

    // Kalkulasi Total saat ongkir dipilih
    document.addEventListener('change', function(e) {
        if(e.target && e.target.name === 'shipping_cost') {
            let shippingCost = parseInt(e.target.value) || 0;
            let finalTotal = baseSubtotal + shippingCost;
            
            shippingDisplay.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(shippingCost)}`;
            totalDisplay.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(finalTotal)}`;
        }
    });
});
</script>
@endsection
