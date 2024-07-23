<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'login_type' => ['required']
        ]);

        if ($credentials['login_type'] == 'student') {
            if (Auth::guard('student')->attempt(['no_absen' => $credentials['username'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();
                return redirect()->route('siswa.dashboard');
            }
        } else {
            if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();
                $user = Auth::user();
                switch ($user->role) {
                    case 'admin_sekolah':
                        return redirect()->route('admin_sekolah.dashboard');
                    case 'admin_tu':
                        return redirect()->route('admin_tu.dashboard');
                    case 'siswa':
                        return redirect()->route('siswa.dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput()->with('error', 'Login gagal, silakan periksa username dan password Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
