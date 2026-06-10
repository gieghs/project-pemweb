@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-10 flex flex-col md:flex-row gap-8 max-w-6xl">

    <main class="flex-1">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">
            <h2 class="text-2xl font-bold mb-6 uppercase tracking-widest border-b border-gray-200 pb-4">Informasi Akun</h2>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-6 text-[11px] uppercase tracking-widest">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-6 text-[11px] uppercase tracking-widest">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.settings.update') }}" method="POST" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username ?? $user->name ?? '') }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]" required>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]" required>
                </div>

                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="08xxxxxxxxxx" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                </div>

                {{-- Ubah Password --}}
                <div class="border-t border-gray-200 pt-6 mt-2">
                    <h3 class="text-[10px] font-bold tracking-[0.2em] uppercase mb-1">Ubah Password</h3>
                    <p class="text-[11px] text-gray-400 mb-5">Kosongkan jika tidak ingin mengubah password.</p>

                    <div class="flex flex-col gap-5">
                        <div>
                            <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Current Password</label>
                            <div class="relative">
                                <input id="current_password" type="password" name="current_password" placeholder="••••••••" class="w-full border border-gray-300 p-3 pr-12 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                                <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors" tabindex="-1">
                                    <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-[10px] mt-1 tracking-wider">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">New Password</label>
                            <div class="relative">
                                <input id="new_password" type="password" name="new_password" placeholder="Min. 8 karakter" class="w-full border border-gray-300 p-3 pr-12 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                                <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors" tabindex="-1">
                                    <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('new_password')
                                <p class="text-red-500 text-[10px] mt-1 tracking-wider">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Confirm New Password</label>
                            <div class="relative">
                                <input id="new_password_confirmation" type="password" name="new_password_confirmation" placeholder="Ulangi password baru" class="w-full border border-gray-300 p-3 pr-12 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                                <button type="button" onclick="togglePassword('new_password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors" tabindex="-1">
                                    <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-black text-white py-4 mt-4 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </main>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');

        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>
@endsection