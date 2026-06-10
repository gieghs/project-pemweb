<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()->user()->reviews()->get();

        return view('user.reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $existing = auth()->user()->reviews()->exists();

        if ($existing) {
            return back()->with('info', 'Anda sudah memberikan ulasan');
        }

        auth()->user()->reviews()->create([
            'username' => auth()->user()->username,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}