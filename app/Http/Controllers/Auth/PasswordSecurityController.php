<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordSecurityController extends Controller
{
    /**
     * Paso 1: Muestra formulario para ingresar email.
     */
    public function showEmailForm()
    {
        return view('auth.passwords.email_security');
    }

    /**
     * Paso 2: Procesa email y redirige a la pregunta de seguridad.
     */
    public function handleEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'El correo electrónico debe tener un formato válido.',
            'email.exists'   => 'No existe ningún usuario con ese correo electrónico.',
        ]);

        $user = User::where('email', $request->email)->first();

        return redirect()->route('password.security.question', ['email' => $user->email]);
    }

    /**
     * Paso 2.1: Muestra formulario de pregunta de seguridad.
     */
    public function showQuestionForm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'El correo electrónico debe tener un formato válido.',
            'email.exists'   => 'No existe ningún usuario con ese correo electrónico.',
        ]);

        $user = User::where('email', $request->email)->first();

        return view('auth.passwords.question', [
            'email'             => $user->email,
            'security_question' => $user->security_question,
        ]);
    }

    /**
     * Paso 3: Verifica respuesta y redirige al formulario de nueva contraseña.
     */
    public function handleQuestion(Request $request)
    {
        $request->validate([
            'email'  => ['required', 'email', 'exists:users,email'],
            'answer' => ['required', 'string'],
        ], [
            'email.required'  => 'El correo electrónico es obligatorio.',
            'email.email'     => 'El correo electrónico debe tener un formato válido.',
            'email.exists'    => 'No existe ningún usuario con ese correo electrónico.',
            'answer.required' => 'La respuesta a la pregunta de seguridad es obligatoria.',
            'answer.string'   => 'La respuesta debe ser un texto válido.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! Hash::check($request->answer, $user->security_answer)) {
            return redirect()->route('password.security.question', ['email' => $request->email])
                ->withErrors(['answer' => 'Respuesta incorrecta.'])
                ->withInput();
        }

        return redirect()->route('password.security.reset', ['email' => $user->email]);
    }

    /**
     * Paso 3.1: Muestra formulario para nueva contraseña.
     */
    public function showResetForm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'El correo electrónico debe tener un formato válido.',
            'email.exists'   => 'No existe ningún usuario con ese correo electrónico.',
        ]);

        return view('auth.passwords.reset_security', [
            'email' => $request->email,
        ]);
    }

    /**
     * Paso 4: Guarda la nueva contraseña.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => ['required', 'email', 'exists:users,email'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required'        => 'El correo electrónico es obligatorio.',
            'email.email'           => 'El correo electrónico debe tener un formato válido.',
            'email.exists'          => 'No existe ningún usuario con ese correo electrónico.',
            'password.required'     => 'La contraseña es obligatoria.',
            'password.confirmed'    => 'La confirmación de la contraseña no coincide.',
            'password.min'          => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')
            ->with('status', 'Contraseña cambiada exitosamente, ya puedes iniciar sesión.');
    }
}
