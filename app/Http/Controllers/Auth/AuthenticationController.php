<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|string|email', 'password' => 'required|string']);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/manufacturing')->with('success', 'Inicio de sesión exitoso.');
        }

        if ($credentials['email'] === '' || $credentials['password'] === '') {
            return redirect('/auth/login')->with('error', 'Por favor, complete todos los campos.');
        }

        return redirect('/auth/login')->with('error', 'Las credenciales proporcionadas no corresponden a nuestros registros.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'Sesión cerrada correctamente.');
    }
}
