<?php

namespace App\Http\Controllers;

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
            'active'   => 1,
        ];


        // cek pada database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // return error
        return back()->withErrors([
            'username' => 'Username atau password yang anda masukan salah.',
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
