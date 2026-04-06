<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {

        if (Auth::check()) {
            return redirect()->route(auth::user()->level . '.dashboard');
        }
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'nis_nip'  => 'required',
            'password' => 'required',
        ]);


        if (Auth::attempt(['nis_nip' => $request->nis_nip, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->level === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }


        return back()->withErrors([
            'nis_nip' => 'NIS/NIP atau Password salah.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
