<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'no_absen' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('student')->attempt(['no_absen' => $credentials['no_absen'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors([
            'no_absen' => 'The provided credentials do not match our records.',
        ])->withInput()->with('error', 'Login gagal, silakan periksa no absen dan password Anda.');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
