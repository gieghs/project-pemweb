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
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Username </label>
                    <input type="text" name="username" value="{{ $user->username ?? $user->name ?? '' }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]" required>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]" required>
                </div>

                <div>
                    <label class="block text-[10px] font-bold tracking-[0.2em] uppercase mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ $user->phone ?? '' }}" class="w-full border border-gray-300 p-3 text-sm focus:border-black focus:ring-0 bg-[#f8f9fa]">
                </div>
                
                <button type="submit" class="w-full bg-black text-white py-4 mt-4 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </main>
</div>
@endsection