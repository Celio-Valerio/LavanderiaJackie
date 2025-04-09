<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Rules\Password::defaults(), 'confirmed'],
        ], [
            'current_password.required'         => 'La contraseña actual es obligatoria.',
            'current_password.current_password' => 'La contraseña actual no coincide con nuestros registros.',
            'password.required'                 => 'La nueva contraseña es obligatoria.',
            'password.confirmed'                => 'La confirmación de la contraseña no coincide.',
            'password.password'                 => 'La nueva contraseña debe tener al menos 8 caracteres e incluir mayúsculas, minúsculas, números y símbolos.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Tu contraseña ha sido actualizada correctamente.');
    }
}
