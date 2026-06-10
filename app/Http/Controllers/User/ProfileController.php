<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Base profile validation
        $rules = [
            'username' => 'required|string|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ];

        // Password validation only if any password field is filled
        if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('new_password_confirmation')) {
            $rules['current_password'] = 'required|string';
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Verify current password if changing password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
        }

        // Update profile data
        $data = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
        ];

        // Update password if provided
        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($validated['new_password']);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}