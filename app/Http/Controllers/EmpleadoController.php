<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los empleados de la base de datos
        $empleados = Empleado::all();

        // Retornar una vista con los empleados
        return view('primary.empleados.empleado_index', compact('empleados'));
    }

    public function reload($id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $puestos = Puesto::all(); // Obtiene todos los puestos disponibles
        return view('primary.empleados.empleado_create', compact('puestos')); // Pasa los puestos a la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identity_number' => [
                'required',
                'string',
                'size:13',
                'unique:empleados,identity_number',
                'regex:/^[0-9]{13}$/',
            ],
            'first_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/',
            ],
            'last_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/',
            ],
            'email' => [
                'nullable',
                'email',
                'unique:empleados,email',
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:empleados,phone',
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
            'hire_date' => [
                'required',
                'date',
            ],
            'fecha_salida' => [
                'required',
                'date',
                'after:hire_date', // 👈 Esta es la regla clave
            ],
            'salary' => [
                'required',
                'numeric',
                'between:1500,50000',
            ],
            'puesto_id' => [
                'required',
                'exists:puestos,id',
            ],
        ], [
            'identity_number.required' => 'El número de identidad es obligatorio.',
            'identity_number.string' => 'El número de identidad debe ser una cadena de texto.',
            'identity_number.size' => 'El número de identidad debe tener exactamente 13 dígitos.',
            'identity_number.unique' => 'Este número de identidad ya está registrado.',
            'identity_number.regex' => 'El número de identidad solo debe contener números.',

            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser una cadena de texto válida.',
            'first_name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'first_name.max' => 'El nombre no puede exceder los 50 caracteres.',
            'first_name.regex' => 'El nombre solo puede contener letras y un espacio opcional entre nombres.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto válida.',
            'last_name.min' => 'El apellido debe tener al menos 3 caracteres.',
            'last_name.max' => 'El apellido no puede exceder los 50 caracteres.',
            'last_name.regex' => 'El apellido solo puede contener letras y un espacio opcional entre apellidos.',

            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.regex' => 'Debes ingresar una dirección de correo válida.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.unique' => 'El número de teléfono ya está en uso.',
            'phone.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono debe comenzar con 2, 3, 8 o 9.',

            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto válida.',
            'address.min' => 'La dirección debe tener al menos 5 caracteres.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',

            'hire_date.required' => 'La fecha de ingreso es obligatoria.',
            'hire_date.date' => 'La fecha de ingreso debe ser una fecha válida.',

            'fecha_salida.required' => 'La fecha de salida es obligatoria.',
            'fecha_salida.date' => 'La fecha de salida debe ser una fecha válida.',
            'fecha_salida.after' => 'La fecha de salida debe ser posterior a la fecha de ingreso.',

            'salary.required' => 'El salario es obligatorio.',
            'salary.numeric' => 'El salario debe ser un número.',
            'salary.between' => 'El salario debe estar entre 1500 y 50000.',

            'puesto_id.required' => 'El puesto es obligatorio.',
            'puesto_id.exists' => 'El puesto seleccionado no es válido.',
        ]);

        // Guardar empleado en la base de datos
        $empleado = new Empleado();
        $empleado->identity_number = $request->identity_number;
        $empleado->first_name = $request->first_name;
        $empleado->last_name = $request->last_name;
        $empleado->email = $request->email;
        $empleado->phone = $request->phone;
        $empleado->address = $request->address;
        $empleado->hire_date = $request->hire_date;
        $empleado->fecha_salida = $request->fecha_salida;
        $empleado->salary = $request->salary;
        $empleado->puesto_id = $request->puesto_id;
        $empleado->save();

        return redirect()->route('empleados.index')->with('success', 'El empleado ' . $empleado->first_name . ' ' . $empleado->last_name . ' ha sido registrado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Busca al empleado por su ID
        $empleado = Empleado::findOrFail($id);

        // Retorna la vista 'empleados.show' y le pasa los datos del empleado
        return view('primary.empleados.empleado_show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id); // Obtiene el empleado por ID
        $puestos = Puesto::all(); // Obtiene todos los puestos disponibles

        return view('primary.empleados.empleado_update', compact('empleado', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id); // Obtiene el empleado por ID

        // 1) Validar los datos del empleado
        $data = $request->validate([
            'identity_number' => [
                'required',
                'string',
                'size:13',
                'unique:empleados,identity_number,' . $empleado->id,
                'regex:/^[0-9]{13}$/',
            ],
            'first_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/',
            ],
            'last_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/',
            ],
            'email' => [
                'nullable',
                'email',
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:empleados,email,' . $empleado->id, // Permite el mismo correo del empleado que se está editando
            ],
            'phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:empleados,phone,' . $empleado->id, // Permite el mismo teléfono del empleado que se está editando
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
            'puesto_id' => [ // Cambia 'position' por 'puesto_id'
                'required',
                'exists:puestos,id', // Asegura que el puesto existe en la tabla 'puestos'
            ],
            'hire_date' => [
                'required',
                'date',
            ],
            'fecha_salida' => [
                'date',
                'after:hire_date', // 👈 Esta es la regla clave
            ],
            'salary' => [
                'required',
                'numeric',
                'between:1500,50000',
            ],
            'estado' => 'required',
        ], [
            // Mensajes de error personalizados
            'identity_number.required' => 'El número de identidad es obligatorio.',
            'identity_number.string' => 'El número de identidad debe ser una cadena de texto.',
            'identity_number.size' => 'El número de identidad debe tener exactamente 13 dígitos.',
            'identity_number.unique' => 'Este número de identidad ya está registrado.',
            'identity_number.regex' => 'El número de identidad solo debe contener números.',

            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser una cadena de texto válida.',
            'first_name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'first_name.max' => 'El nombre no puede exceder los 50 caracteres.',
            'first_name.regex' => 'El nombre solo puede contener letras, un espacio opcional entre palabras, y no debe tener símbolos ni números.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto válida.',
            'last_name.min' => 'El apellido debe tener al menos 3 caracteres.',
            'last_name.max' => 'El apellido no puede exceder los 50 caracteres.',
            'last_name.regex' => 'El apellido solo puede contener letras, un espacio opcional entre palabras, y no debe tener símbolos ni números.',

            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.regex' => 'Debes ingresar una dirección de correo electrónico correcta.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.unique' => 'El número de teléfono ya está en uso.',
            'phone.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',

            'address.string' => 'La dirección debe ser una cadena de texto válida.',
            'address.min' => 'La dirección debe tener al menos 5 caracteres.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',
            'address.required' => 'La dirección es obligatoria.',

            'hire_date.required' => 'La fecha de ingreso es obligatoria.',
            'hire_date.date' => 'La fecha de ingreso debe ser una fecha válida.',

            'fecha_salida.date' => 'La fecha de salida debe ser una fecha válida.',
            'fecha_salida.after' => 'La fecha de salida debe ser posterior a la fecha de ingreso.',

            'salary.required' => 'El salario es obligatorio.',
            'salary.numeric' => 'El salario debe ser un número.',
            'salary.between' => 'El salario debe estar entre 1500 y 5000.',

            'puesto_id.required' => 'El puesto es obligatorio.',
            'puesto_id.exists' => 'El puesto seleccionado no es válido.',
            'estado.required' => 'El estado es obligatorio',
        ]);

        // Actualizar empleado
        $empleado->identity_number = $request->identity_number;
        $empleado->first_name = $request->first_name;
        $empleado->last_name = $request->last_name;
        $empleado->email = $request->email;
        $empleado->phone = $request->phone;
        $empleado->address = $request->address;
        $empleado->puesto_id = $request->puesto_id; // Actualiza el ID del puesto relacionado
        $empleado->hire_date = $request->hire_date;
        $empleado->fecha_salida = $request->fecha_salida;
        $empleado->salary = $request->salary;
        $empleado->estado = $request->input('estado');
        $empleado->save();

       try {
            // 2) Actualizar el empleado
            $empleado->update([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['email'],
                'phone'      => $data['phone'],
                'address'    => $data['address'],
            ]);

            // 3) Sincronizar con el usuario relacionado (si existe)
            if ($empleado->user) {
                $empleado->user->update([
                    'email'     => $data['email'],
                    'telefono'  => $data['phone'],
                    'direccion' => $data['address'],
                ]);
            }

            return Redirect::route('empleados.index')
                ->with('success', 'Empleado (y usuario) actualizados correctamente.');

        } catch (\Exception $e) {
            return Redirect::back()
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

    public function generarConstancia($id)
    {
        $empleado = Empleado::findOrFail($id);
        $fechaActual = Carbon::now()->locale('es_ES')->isoFormat('DD/MM/YYYY');

        $data = [
            'empleado' => $empleado,
            'fechaActual' => $fechaActual,
            'gerente' => 'Matilde Jackeline Moncada Zelaya',
            'telefonoEmpresa' => env('COMPANY_PHONE', '9608-5567'),
            'emailEmpresa' => env('COMPANY_EMAIL', 'Jacky.moncada25@gmail.com')
        ];

        // Verifica el estado del empleado para cargar la vista correspondiente
        $view = $empleado->estado === 'Activo'
            ? 'primary.empleados.empleado_constancia'
            : 'primary.empleados.empleado_inactivo_constancia';

        $pdf = Pdf::loadView($view, $data);
        return $pdf->download('constancia_laboral_'.$empleado->first_name.'_'.$empleado->last_name.'.pdf');
    }

}
