<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        if (Auth::guard('peminjam')->check()) {
            return redirect('/peminjam/dashboard');
        }

        return view('auth.login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login sebagai Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/admin/dashboard');
        }

        // Jika bukan Admin, cek sebagai Peminjam
        if (Auth::guard('peminjam')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/peminjam/dashboard');
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('peminjam')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}