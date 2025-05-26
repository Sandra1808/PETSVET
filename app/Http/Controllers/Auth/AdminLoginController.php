<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Acceso solo para administradores.']);
            }
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }
} 