<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * View halaman login
     *
     * @return view
     */
    public function index()
    {
        $is_login = false;

        return view('pages.auth.login', compact('is_login'));
    }



    /**
     * Login user
     *
     * @param Request $request
     *
     * @return redirect
     */
    public function login(Request $request)
    {
        // validasi form input
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // simpan hasil form input
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // cek pada database
        if (Auth::attempt($credentials)) {

            // cek apakah akun aktif atau tidak
            if (Auth::user()->active != 1) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'error' => 'Akun anda tidak aktif.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // return error
        return back()->withErrors([
            'error' => 'Username atau password salah.',
        ]);
    }



    /**
     * Logout user
     *
     * @param Request $request
     *
     * @return redirect
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }
}