<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'Debes ingresar un correo electrónico válido.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', 'Se ha enviado el enlace de restablecimiento de contraseña a tu correo electrónico.')
            : back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => $status === Password::INVALID_USER
                        ? 'No encontramos un usuario con ese correo electrónico.'
                        : 'Por favor, espera unos minutos e inténtalo de nuevo.',
                ]);
    }
}
