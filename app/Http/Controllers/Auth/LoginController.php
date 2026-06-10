<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'emailOrUsername' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($credentials['emailOrUsername'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (!auth()->attempt([
            $field => $credentials['emailOrUsername'],
            'password' => $credentials['password'],
        ])) {
            return back()->withErrors([
                'emailOrUsername' => 'Email/username atau password salah',
            ]);
        }

        $request->session()->regenerate();

        if (auth()->user()->isAdmin()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/');
    }
}