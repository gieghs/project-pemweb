@extends('layouts.guest')
@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Kiri: Branding -->
    <div class="hidden md:flex flex-col justify-between w-1/2 bg-black text-white p-12 lg:p-20">
        <div class="text-sm font-bold tracking-[0.2em] uppercase">WHITE NORTH STORE</div>
        <div>
            <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-4">Thrift Hat Premium</p>
            <h1 class="text-5xl font-extrabold mb-4 leading-tight">Topi Thrift.<br><span class="text-gray-400">Pilihan Terbaik.</span></h1>
            <p class="text-gray-400 text-sm max-w-sm leading-relaxed">Koleksi topi thrift berkualitas premium. Temukan gaya unikmu bersama kami.</p>
        </div>
        <div class="text-xs text-gray-600 italic border-t border-gray-800 pt-6">"Style is a way to say who you are without having to speak."</div>
    </div>
    
    <!-- Kanan: Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 bg-white min-h-screen">
        <div class="w-full max-w-md py-12">
            
            <!-- Tampilkan Error -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="text-3xl font-extrabold mb-1">Buat Akun</h2>
            <p class="text-gray-500 text-sm mb-8">Bergabunglah dan temukan topi impianmu</p>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-2">Nama / Username <span class="text-red-500">*</span></label>
                    <input type="text" name="name" placeholder="nama lengkap atau username" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" placeholder="nama@email.com" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" placeholder="08xxxxxxxxxx" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" placeholder="Min. 8 karakter" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black" required>
                </div>
                
                <button type="submit" class="w-full bg-black text-white rounded-lg py-3 text-sm font-bold hover:bg-gray-800 transition-colors">Buat Akun</button>
            </form>
            
            <div class="text-center mt-6 text-sm">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold hover:underline">Masuk di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection
