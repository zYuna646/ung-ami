<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthenticateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function authenticate(LoginAuthenticateRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect()
                ->route('dashboard.index')
                ->withSuccess('Selamat datang!');
        }

        return redirect()
            ->back()
            ->withErrors(['Login gagal.', 'Ups! Username atau password salah.']);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()
            ->route('auth.login');
    }
}
