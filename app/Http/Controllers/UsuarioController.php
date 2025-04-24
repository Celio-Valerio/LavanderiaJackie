<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los usuarios de la base de datos
        $usuarios = User::all();

        // Retornar una vista con los clientes
        return view('primary.usuarios.usuario_index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener los empleados que NO tienen un usuario asociado, junto con el puesto
        $empleados = Empleado::select('id', 'first_name', 'last_name', 'address', 'email', 'phone', 'puesto_id')
            ->whereNotIn('id', function ($query) {
                $query->select('empleado_id')->from('users'); // Asegura que 'usuarios' es el nombre correcto de la tabla
            })
            ->with('puesto') // Cargar la relación con el puesto
            ->get();

        return view('primary.usuarios.usuario_create', compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048',],
            'name' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){1,4}$/',],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email', 'regex:/^(.+)@(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com)$/i',],
            'password' => ['required', 'confirmed', 'min:8', 'max:30', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',],
            'telefono' => ['required', 'digits:8', 'regex:/^[2389][0-9]{7}$/', 'unique:users,telefono'],
            'direccion' => ['required', 'string', 'min:5', 'max:500'],
            'empleado_id' => ['required', 'exists:empleados,id'],
            'security_question' => ['required', 'string', 'max:255'],
            'security_answer' => ['required', 'string', 'min:3', 'max:100'],
        ],[
            'name.required' => 'El nombre de usuario es obligatorio.',
            'name.regex' => 'El nombre de usuario puede contener hasta 5 palabras y no debe contener símbolos ni números.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.max' => 'El correo electrónico no debe tener más de 100 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'email.regex' => 'El correo electrónico debe pertenecer a un dominio de Google, Yahoo o Microsoft.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits' => 'El número de teléfono debe tener 8 números.',
            'telefono.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',
            'telefono.unique' => 'El número de teléfono ya está en uso.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe tener al menos una letra mayúscula, una letra minúscula, un número y un símbolo.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto válida.',
            'direccion.min' => 'La dirección debe tener al menos 5 caracteres.',
            'direccion.max' => 'La dirección no puede exceder los 500 caracteres.',

            'image.required' => 'Debes cargar una imagen.',
            'image.image' => 'Debes seleccionar una imagen en un formato válido.',
            'image.mimes' => 'La imagen debe estar en formato jpeg, png, jpg o gif.',
            'image.max' => 'La imagen no puede exceder los 2048 KB.',

            'empleado_id.required' => 'El empleado es obligatorio.',
            'empleado_id.exists' => 'El empleado seleccionado no es válido.',

            'security_question.required' => 'La pregunta de seguridad es obligatoria.',
            'security_answer.required' => 'La respuesta de seguridad es obligatoria.',
            'security_answer.min' => 'La respuesta debe tener al menos 3 caracteres.',
            'security_answer.max' => 'La respuesta no puede exceder los 100 caracteres.',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->direccion = $request->direccion;
            $user->telefono = $request->telefono;
            $user->empleado_id = $request->empleado_id;

            // Guardar imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();

                // Generar el nombre en el formato deseado
                $timestamp = now()->format('d-m-Y_H-i-s');
                $randomNumber = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $imageName = "perfiles_{$timestamp}_{$randomNumber}.{$extension}";

                // Guardar la imagen directamente en la carpeta public/assets/img/promociones
                $image->move(public_path('assets/img/perfiles'), $imageName);

                // Almacenar el nombre en la base de datos
                $user->image = $imageName;
            }

            $user->security_question = $request->security_question;
            $user->security_answer = $request->security_answer; // Sin Hash::make
            $user->save();
            return redirect()->route('usuarios.index')
                ->with('success', 'El usuario ' . $user->name . ' ha sido registrado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Cargamos el usuario con la relación del empleado
            $usuario = User::with('empleado')->findOrFail($id);
            return view('primary.usuarios.usuario_show', compact('usuario'));
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')
                           ->with('error', 'Usuario no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        // Obtener empleados sin usuario o el empleado actual del usuario
        $empleados = Empleado::select('id', 'first_name', 'last_name', 'address', 'email', 'phone', 'puesto_id')
            ->where(function($query) use ($usuario) {
                $query->whereNotIn('id', function($subquery) {
                    $subquery->select('empleado_id')->from('users');
                })
                    ->orWhere('id', $usuario->empleado_id); // Incluir empleado actual
            })
            ->with('puesto')
            ->get();

        return view('primary.usuarios.usuario_edit', compact('usuario', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'name' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){1,4}$/'],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                'unique:users,email,'.$usuario->id,
                'unique:empleados,email,'.$request->empleado_id,
                'regex:/^(.+)@(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com)$/i'
            ],
            'password' => ['nullable', 'confirmed', 'min:8', 'max:30', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'current_password' => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    return $request->filled('new_password');
                }),
                function ($attribute, $value, $fail) use ($usuario) {
                    if (!Hash::check($value, $usuario->password)) {
                        $fail('La contraseña actual es incorrecta.');
                    }
                }
            ],
            'new_password' => [
                'nullable',
                'confirmed',
                'min:8',
                'max:30',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            'telefono' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:users,telefono,'.$usuario->id,
                'unique:empleados,phone,'.$request->empleado_id
            ],
            'direccion' => ['required', 'string', 'min:5', 'max:500'],
            'empleado_id' => ['required', 'exists:empleados,id'],
        ],[
            'name.required' => 'El nombre de usuario es obligatorio.',
            'name.regex' => 'El nombre de usuario puede contener hasta 5 palabras y no debe contener símbolos ni números.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado en usuarios o empleados.',
            'email.regex' => 'El correo debe ser de Google, Yahoo, Hotmail u Outlook.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits' => 'El teléfono debe contener 8 dígitos.',
            'telefono.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'El número ya está registrado en usuarios o empleados.',

            'password.regex' => 'La contraseña debe contener mayúscula, minúscula, número y símbolo.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede exceder 30 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.min' => 'La dirección debe tener al menos 5 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 500 caracteres.',

            'empleado_id.required' => 'Debe seleccionar un empleado.',
            'empleado_id.exists' => 'El empleado seleccionado no existe.',

            'image.image' => 'Debe ser una imagen válida.',
            'image.mimes' => 'Formatos permitidos: jpeg, png, jpg, gif.',
            'image.max' => 'La imagen no puede superar 2MB.',

            'current_password.required' => 'La contraseña actual es requerida para cambiar la contraseña.',
            'current_password.current_password' => 'La contraseña actual es incorrecta.',

            'new_password.regex' => 'La nueva contraseña debe contener mayúscula, minúscula, número y símbolo.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.max' => 'La nueva contraseña no puede exceder 30 caracteres.',
        ]);
        try {
            // Actualizar usuario
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->telefono = $request->telefono;
            $usuario->direccion = $request->direccion;
            $usuario->empleado_id = $request->empleado_id;

            if ($request->filled('new_password')) {
                $usuario->password = Hash::make($request->new_password);
            }

            // Gestión de imagen
            if ($request->hasFile('image')) {
                if ($usuario->image && file_exists(public_path('assets/img/perfiles/'.$usuario->image))) {
                    unlink(public_path('assets/img/perfiles/'.$usuario->image));
                }

                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $timestamp = now()->format('d-m-Y_H-i-s');
                $randomNumber = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $imageName = "perfiles_{$timestamp}_{$randomNumber}.{$extension}";
                $image->move(public_path('assets/img/perfiles'), $imageName);
                $usuario->image = $imageName;
            }

            $usuario->save();

            // Actualizar datos del empleado relacionado
            $empleado = Empleado::findOrFail($request->empleado_id);
            $empleado->update([
                'email' => $request->email,
                'phone' => $request->telefono,
                'address' => $request->direccion
            ]);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario y empleado actualizados exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
