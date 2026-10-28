<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = app('view')->getShared()['authUser'];
        return view('profile.index', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'bio'   => 'nullable|string|max:300',
        ], [
            'name.required'  => 'El nombre es requerido.',
            'email.required' => 'El correo es requerido.',
            'email.email'    => 'Ingresa un correo válido.',
        ]);

        /** @var User $user */
        $user = app('view')->getShared()['authUser'];
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? '',
            'bio'   => $request->bio ?? '',
        ]);

        return back()->with('success_info', '¡Información actualizada correctamente!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password'     => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es requerida.',
            'new_password.required'     => 'La nueva contraseña es requerida.',
            'new_password.min'          => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'new_password.confirmed'    => 'Las contraseñas no coinciden.',
        ]);

        /** @var User $user */
        $user = app('view')->getShared()['authUser'];

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success_password', '¡Contraseña actualizada correctamente!');
    }
}
