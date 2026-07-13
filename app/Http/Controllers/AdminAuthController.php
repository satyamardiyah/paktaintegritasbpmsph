<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        $adminEmail = env('ADMIN_EMAIL');
        if ($adminEmail && $user->email !== $adminEmail) {
            return back()->withErrors(['email' => 'Akses admin ditolak untuk akun ini'])->withInput();
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    // Tampilkan halaman konfirmasi logout
    public function showLogout()
    {
        return view('admin.logout');
    }

    // Proses logout yang sebenarnya (dipanggil dari form POST)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}