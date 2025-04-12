<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de edición del perfil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'usuario' => $request->user(),   // antes 'user'
        ]);
    }

    /**
     * Actualizar la información del perfil del usuario autenticado.
     */
    public function update(Request $request): RedirectResponse
    {
        $usuario = $request->user();

        $request->validate([
            'name'                  => ['required','string','min:3','max:100','regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){1,4}$/'],
            'email'                 => [
                'required','string','email','max:100',
                Rule::unique('users','email')->ignore($usuario->id),
                'regex:/^(.+)@(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com)$/i'
            ],
            'telefono'              => ['nullable','digits:8','regex:/^[2389][0-9]{7}$/'],
            'direccion'             => ['nullable','string','min:5','max:500'],
            'current_password'      => [
                'nullable',
                Rule::requiredIf(fn() => $request->filled('new_password')),
                function($attribute, $value, $fail) use ($usuario) {
                    if (! Hash::check($value, $usuario->password)) {
                        $fail('La contraseña actual es incorrecta.');
                    }
                },
            ],
            'new_password'          => ['nullable','confirmed','min:8','max:30','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'image'                 => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
        ], [
            'name.required'             => 'El nombre es obligatorio.',
            'name.regex'                => 'El nombre puede contener hasta 5 palabras y solo letras.',
            'email.required'            => 'El correo es obligatorio.',
            'email.email'               => 'El formato de correo no es válido.',
            'email.unique'              => 'Este correo ya está en uso.',
            'email.regex'               => 'Solo dominios gmail, yahoo, hotmail u outlook.',
            'telefono.digits'           => 'El teléfono debe tener 8 dígitos.',
            'telefono.regex'            => 'Debe empezar con 2,3,8 o 9.',
            'direccion.min'             => 'La dirección debe tener al menos 5 caracteres.',
            'current_password.required' => 'La contraseña actual es requerida para cambiarla.',
            'new_password.confirmed'    => 'Las nuevas contraseñas no coinciden.',
            'new_password.regex'        => 'La nueva contraseña debe incluir mayúscula, minúscula, número y símbolo.',
            'image.image'               => 'Debe ser un archivo de imagen válido.',
            'image.mimes'               => 'Formatos permitidos: jpeg, png, jpg, gif.',
            'image.max'                 => 'La imagen no puede superar 2MB.',
        ]);

        // Asignar campos básicos
        $usuario->name      = $request->name;
        $usuario->email     = $request->email;
        $usuario->telefono  = $request->telefono;
        $usuario->direccion = $request->direccion;

        // Cambiar contraseña si se proporcionó nueva
        if ($request->filled('new_password')) {
            $usuario->password = Hash::make($request->new_password);
        }

        // Procesar imagen de perfil
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($usuario->image && file_exists(public_path("assets/img/perfiles/{$usuario->image}"))) {
                unlink(public_path("assets/img/perfiles/{$usuario->image}"));
            }
            $file      = $request->file('image');
            $ext       = $file->getClientOriginalExtension();
            $filename  = 'perfil_' . now()->format('Ymd_His') . '_' . uniqid() . ".{$ext}";
            $file->move(public_path('assets/img/perfiles'), $filename);
            $usuario->image = $filename;
        }

        $usuario->save();

        // Si el usuario está relacionado con un empleado, sincronizar datos básicos
        if ($usuario->empleado) {
            $usuario->empleado->update([
                'email'   => $usuario->email,
                'phone'   => $usuario->telefono,
                'address' => $usuario->direccion,
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Eliminar la cuenta del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
