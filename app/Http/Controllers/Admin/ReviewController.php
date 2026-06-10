<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();

        $averageRating = $reviews->avg('rating') ?? 0;
        $totalReviews = $reviews->count();

        $ratingCounts = collect([5, 4, 3, 2, 1])->map(fn ($r) => [
            'rating' => $r,
            'count' => $reviews->where('rating', $r)->count(),
        ]);

        return view('admin.reviews', [
            'reviews' => $reviews,
            'averageRating' => number_format($averageRating, 1),
            'ratingCounts' => $ratingCounts,
            'totalReviews' => $totalReviews,
        ]);
    }

    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply' => $validated['reply'],
            'admin_reply_date' => now(),
        ]);

        return back()->with('success', 'Balasan berhasil dikirim');
    }
}