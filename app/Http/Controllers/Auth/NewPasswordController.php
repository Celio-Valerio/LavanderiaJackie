<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'token.required'         => 'El token de restablecimiento es obligatorio.',
            'email.required'         => 'El correo electrónico es obligatorio.',
            'email.email'            => 'Debes ingresar un correo electrónico válido.',
            'password.required'      => 'La contraseña es obligatoria.',
            'password.confirmed'     => 'La confirmación de la contraseña no coincide.',
            'password.password'      => 'La contraseña debe tener al menos 8 caracteres e incluir mayúsculas, minúsculas, números y símbolos.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('status', 'Tu contraseña ha sido restablecida correctamente.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => $status === Password::INVALID_USER
                    ? 'No encontramos un usuario con ese correo electrónico.'
                    : ($status === Password::INVALID_TOKEN
                        ? 'El token de restablecimiento es inválido o ha expirado.'
                        : 'No se pudo restablecer la contraseña. Por favor, inténtalo de nuevo más tarde.'
                    ),
            ]);
    }

}
