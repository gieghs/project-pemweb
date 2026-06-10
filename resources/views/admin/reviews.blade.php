@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold uppercase tracking-widest mb-8">Reviews</h1>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 mb-8">
    <div class="grid md:grid-cols-2 gap-8">
        <div class="text-center">
            <div class="text-6xl font-bold mb-3">{{ $averageRating ?? '0' }}</div>
            <div class="flex items-center justify-center gap-1 mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $i <= (float)($averageRating ?? 0) ? 'black' : 'none' }}" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                @endfor
            </div>
            <p class="text-gray-500 text-sm">Based on {{ $totalReviews ?? 0 }} reviews</p>
        </div>

        <div>
            <h3 class="font-bold mb-4 uppercase tracking-[0.2em] text-xs text-gray-500">Rating Distribution</h3>
            @foreach ($ratingCounts ?? [] as $ratingData)
                @php
                    $rating = is_object($ratingData) ? $ratingData->rating : $ratingData['rating'];
                    $count = is_object($ratingData) ? $ratingData->count : $ratingData['count'];
                    $pct = ($totalReviews ?? 0) > 0 ? ($count / $totalReviews) * 100 : 0;
                @endphp
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-12 text-sm font-medium">{{ $rating }} &#11088;</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-black h-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="w-12 text-right text-sm text-gray-600">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="space-y-4">
    @php
        $sortedReviews = collect($reviews ?? [])->sortByDesc(function ($r) {
            return is_object($r) ? $r->created_at : $r['created_at'];
        });
    @endphp
    @forelse ($sortedReviews as $review)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="font-bold text-lg">{{ is_object($review) ? $review->username : $review['username'] }}</p>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse(is_object($review) ? $review->created_at : $review['created_at'])->locale('id')->translatedFormat('j F Y') }}</p>
                </div>
                <div class="flex items-center gap-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="{{ $i <= (is_object($review) ? $review->rating : $review['rating']) ? 'black' : 'none' }}" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>
            </div>

            <p class="text-gray-700 mb-4">{{ is_object($review) ? $review->comment : $review['comment'] }}</p>

            @if (is_object($review) ? $review->admin_reply : ($review['admin_reply'] ?? null))
                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-black">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <p class="text-sm font-semibold text-gray-700">Admin Response</p>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse(is_object($review) ? ($review->admin_reply_date ?? 0) : ($review['admin_reply_date'] ?? 0))->locale('id')->translatedFormat('j F Y') }}</span>
                    </div>
                    <p class="text-sm text-gray-700">{{ is_object($review) ? $review->admin_reply : $review['admin_reply'] }}</p>
                </div>
            @else
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="text-sm text-gray-600 hover:text-black flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Reply to this review
                    </button>
                    <div x-show="open" class="bg-gray-50 p-4 rounded-lg mt-3">
                        <form method="POST" action="{{ url('/admin/reviews/' . (is_object($review) ? $review->id : $review['id']) . '/reply') }}">
                            @csrf
                            <textarea name="reply" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black outline-none mb-3" rows="3" placeholder="Write your response..." required></textarea>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 text-sm">Send Reply</button>
                                <button type="button" @click="open = false" class="bg-gray-200 text-black px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
            <p class="text-gray-400 text-sm">No reviews yet</p>
        </div>
    @endforelse
</div>
@endsection