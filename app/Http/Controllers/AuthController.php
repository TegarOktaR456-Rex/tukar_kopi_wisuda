<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // Validasi input form (menggunakan name/username sesuai request Anda)
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Coba melakukan login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Cek role user dan arahkan ke halaman yang sesuai
            $role = Auth::user()->role;
            
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'pelayan') {
                return redirect()->route('pelayan.beranda');
            }

            // Default jika role tidak dikenali
            return redirect('/');
        }

        // Jika password atau username salah, kembalikan ke form dengan pesan error
        return back()->withErrors([
            'name' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('name');
    }
}