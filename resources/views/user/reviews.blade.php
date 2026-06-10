@extends('layouts.user')

@section('content')
@php
    $user = auth()->user();
    $userReview = $reviews->first();
@endphp
<div class="max-w-2xl mx-auto px-6 py-8">
    <h1 class="text-2xl md:text-3xl font-bold text-black uppercase tracking-wider mb-8">Rating & Ulasan</h1>

    @if ($userReview)
        <div class="space-y-6">
            <div class="border border-green-200 bg-green-50 p-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-700 flex-shrink-0"><polyline points="20 6 9 17 4 12"/></svg>
                    <p class="text-sm font-semibold text-green-800">Terima kasih! Ulasan Anda telah kami terima.</p>
                </div>
            </div>

            <div class="border border-gray-200 p-6">
                <h3 class="text-xs font-bold uppercase tracking-[0.2em] mb-4">Ulasan Anda</h3>

                <div class="flex items-center gap-1.5 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $i <= ($userReview->rating ?? 0) ? 'black' : 'none' }}" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>

                <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ $userReview->comment }}</p>
                <p class="text-[11px] text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($userReview->created_at)->locale('id')->translatedFormat('j F Y') }}</p>

                @if ($userReview->admin_reply)
                    <div class="mt-5 bg-gray-50 p-4 border-l-4 border-black">
                        <div class="flex items-center gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            <span class="text-[11px] font-bold uppercase tracking-widest text-gray-600">Balasan Admin</span>
                            <span class="text-[10px] text-gray-400">— {{ \Carbon\Carbon::parse($userReview->admin_reply_date)->locale('id')->translatedFormat('j F Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $userReview->admin_reply }}</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="border border-gray-200 p-6">
            <form method="POST" action="{{ route('user.reviews.store') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-[0.2em] text-gray-700 mb-3">Rating</label>
                    <div class="flex gap-1.5" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" onmouseenter="hoverRating({{ $i }})" onmouseleave="resetRating()"
                                class="transition-transform hover:scale-110 p-0.5">
                                <svg id="star-{{ $i }}" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="0" />
                    <p id="rating-text" class="text-xs text-gray-500 mt-2 uppercase tracking-widest"></p>
                    @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-[0.2em] text-gray-700 mb-3">Komentar</label>
                    <textarea name="comment"
                        class="w-full px-4 py-3 border border-gray-300 outline-none text-sm focus:border-black transition-colors"
                        rows="5" placeholder="Ceritakan pengalaman Anda..." required>{{ old('comment') }}</textarea>
                    @error('comment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                    class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-[0.2em] hover:bg-gray-800 transition-colors">
                    Kirim Ulasan
                </button>
            </form>
        </div>

        <script>
        let selectedRating = 0;
        let currentHover = 0;

        function setRating(val) {
            selectedRating = val;
            document.getElementById('rating-value').value = val;
            updateStars();
        }

        function hoverRating(val) {
            currentHover = val;
            updateStars();
        }

        function resetRating() {
            currentHover = 0;
            updateStars();
        }

        function updateStars() {
            const active = currentHover || selectedRating;
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                star.setAttribute('fill', i <= active ? 'black' : 'none');
            }
            const text = document.getElementById('rating-text');
            if (selectedRating > 0) {
                text.textContent = selectedRating + ' dari 5 bintang';
            } else {
                text.textContent = '';
            }
        }
        </script>
    @endif
</div>
@endsection
