<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return redirect()->route(auth()->user()->level . '.dashboard');
        }
        return view('auth.login');
    }

    // Proses login user
    public function login(Request $request)
    {
        $request->validate([
            'nis_nip'  => 'required',
            'password' => 'required',
        ]);

        // Cek kecocokan nis_nip & password
        if (Auth::attempt(['nis_nip' => $request->nis_nip, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Arahkan ke dashboard masing-masing level
            if ($user->level === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Kembali ke login jika gagal
        return back()->withErrors([
            'nis_nip' => 'NIS/NIP atau Password salah.',
        ])->withInput();
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
