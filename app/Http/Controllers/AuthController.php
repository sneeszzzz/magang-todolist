<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // View halaman login
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Ambil email dan password
        $credentials = $request->only('email', 'password');

        // Cek autentikasi user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'revieweeA':
                case 'revieweeB':
                    return redirect()->route('dashboard')->with('success', 'Login successful as Reviewee!');
                case 'reviewerA':
                case 'reviewerB':
                    return redirect()->route('todos.index')->with('success', 'Login successful as Reviewer!');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role is not defined for this account.']);
            }
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
