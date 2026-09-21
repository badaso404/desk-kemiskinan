<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login (hanya diketahui admin, tidak ada tautan publik).
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [], [
            'email' => 'alamat email',
            'password' => 'kata sandi',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi tidak sesuai.',
            ]);
        }

        $request->session()->regenerate();

        AuditTrail::log(
            'login',
            'auth',
            'Admin "' . Auth::user()->name . '" login ke panel admin.',
            null,
            null,
            ['ip' => $request->ip()],
            Auth::user()->name
        );

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Keluar dari panel admin.
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()?->name ?? 'Admin';

        Auth::logout();

        AuditTrail::log(
            'logout',
            'auth',
            'Admin "' . $userName . '" logout dari panel admin.',
            null,
            null,
            ['ip' => $request->ip()],
            $userName
        );

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
