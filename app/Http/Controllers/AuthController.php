<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('finnex_user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'El correo electrónico es requerido.',
            'email.email'       => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es requerida.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas.'])
                ->withInput($request->only('email'));
        }

        // Guardamos solo el ID en sesión (los datos siempre se leen de BD)
        session(['finnex_user_id' => $user->id]);
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->forget('finnex_user_id');
        return redirect()->route('login');
    }
}
