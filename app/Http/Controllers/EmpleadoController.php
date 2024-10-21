<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use Illuminate\Http\Request;

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
            
            'identity' =>[
                    'required',
                    'max:13',
                    'regex:/^0[1-9]\d{11}$/',
                    'unique:empleados,identity',
                ],
            'email' => [
                'nullable',
                'email',
                'unique:empleados,email', // Cambié 'clientes' a 'empleados'
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
                'before_or_equal:today', // Asegura que la fecha no sea mayor al día actual
            ],
            'salary' => [
                'required',
                'numeric',
                'between:1500,99999', // Cambié el límite superior a 99999
            ],
            'puesto_id' => [ // Nueva validación para puesto
                'required',
                'exists:puestos,id', // Verifica que el puesto exista

            ],
            'emergency_number' => [      // Validación para número de emergencia
            'required',
            'digits:8',
            'regex:/^[2389][0-9]{7}$/',
            'unique:empleados,emergency_number',

            ],
            'emergency_contact_name' => [     // Validación para nombre de contacto de emergencia
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/',

            ],
            
        ], [
            // Mensajes de error personalizados
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


            'emergency_number.required' => 'El número de teléfono es obligatorio.',
            'emergency_number.unique' => 'El número de teléfono ya está en uso.',
            'emergency_number.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'emergency_number.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',

            'address.string' => 'La dirección debe ser una cadena de texto válida.',
            'address.min' => 'La dirección debe tener al menos 5 caracteres.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',
            'address.required' => 'La dirección es obligatoria.',

            'hire_date.required' => 'La fecha de ingreso es obligatoria.',
            'hire_date.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'hire_date.before_or_equal' => 'La fecha de ingreso es invalida.', // Mensaje de error personalizado

            'salary.required' => 'El salario es obligatorio.',
            'salary.numeric' => 'El salario debe ser un número.',
            'salary.between' => 'El salario debe estar entre 1500 y 99999.',

            'puesto_id.required' => 'El puesto es obligatorio.',
            'puesto_id.exists' => 'El puesto seleccionado no es válido.',

            'identity.max' => 'La identidad debe tener un máximo de 13 caracteres.',
            'identity.regex' => 'La identidad no es valida',
            'identity.required' => 'La identidad es obligatoria.',
            'identity.unique' => 'La identidad ya está registrada.',

            'emergency_contact_name.required' => 'El nombre es obligatorio.',
            'emergency_contact_name.string' => 'El nombre debe ser una cadena de texto válida.',
            'emergency_contact_name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'emergency_contact_name.max' => 'El nombre no puede exceder los 50 caracteres.',
            'emergency_contact_name.regex' => 'El nombre solo puede contener letras, un espacio opcional entre palabras, y no debe tener símbolos ni números.',


        


        ]);

        // Guardar empleado en la base de datos
        $empleado = new Empleado();
        $empleado->first_name = $request->first_name;
        $empleado->last_name = $request->last_name;
        $empleado->email = $request->email;
        $empleado->phone = $request->phone;
        $empleado->address = $request->address;
        $empleado->hire_date = $request->hire_date;
        $empleado->salary = $request->salary;
        $empleado->puesto_id = $request->puesto_id; // Asignar el puesto relacionado
        $empleado->identity = $request->inpdentity; // Agregar identidad
        $empleado->emergency_number = $request->emergency_number; // Agregar número de emergencia
        $empleado->emergency_contact_name = $request->emergency_contact_name; // Agregar nombre de contacto de emergencia
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

        // Validación de los datos
        $request->validate([
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
            'identity' =>[
                    'required',
                    'max:13',
                    'regex:/^0[1-9]\d{11}$/',
                    'unique:empleados,identity,'. $empleado->id,
            ],
            'email' => [
                'nullable',
                'email',
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:empleados,email,' . $empleado->id,   // Permite el mismo correo del empleado que se está editando
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
                'before_or_equal:today', // Asegura que la fecha no sea mayor al día actual
            ],
            'salary' => [
                'required',
                'numeric',
                'between:1500,99999', // Cambié el límite superior a 99999
                
            ],
            'emergency_number' => [
            'required',
            'digits:8',
            'regex:/^[2389][0-9]{7}$/',
            'unique:empleados,emergency_number,' . $empleado->id, 

            ],
            'emergency_contact_name' => [     // Validación para nombre de contacto de emergencia
            'required',
            'string',
            'min:3',
            'max:50',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/',

        ],
        

        ], [
            // Mensajes de error personalizados
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
            
            'emergency_number.required' => 'El número de teléfono es obligatorio.',
            'emergency_number.unique' => 'El número de teléfono ya está en uso.',
            'emergency_number.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'emergency_number.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',

            'address.string' => 'La dirección debe ser una cadena de texto válida.',
            'address.min' => 'La dirección debe tener al menos 5 caracteres.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',
            'address.required' => 'La dirección es obligatoria.',

            'hire_date.required' => 'La fecha de ingreso es obligatoria.',
            'hire_date.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'hire_date.before_or_equal' => 'La fecha de ingreso es invalida.', // Mensaje de error personalizado

            'salary.required' => 'El salario es obligatorio.',
            'salary.numeric' => 'El salario debe ser un número.',
            'salary.between' => 'El salario debe estar entre 1500 y 99999.',

            'puesto_id.required' => 'El puesto es obligatorio.',
            'puesto_id.exists' => 'El puesto seleccionado no es válido.',

            'identity.max' => 'La identidad debe tener un máximo de 13 caracteres.',
            'identity.required' => 'La identidad es obligatoria.',
            'identity.regex' => 'La identidad no es valida',
            'identity.unique' => 'La identidad ya está registrada.',


            'emergency_contact_name.required' => 'El nombre es obligatorio.',
            'emergency_contact_name.string' => 'El nombre debe ser una cadena de texto válida.',
            'emergency_contact_name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'emergency_contact_name.max' => 'El nombre no puede exceder los 50 caracteres.',
            'emergency_contact_name.regex' => 'El nombre solo puede contener letras, un espacio opcional entre palabras, y no debe tener símbolos ni números.',
        
        ]);

        // Actualizar empleado
        $empleado->first_name = $request->first_name;
        $empleado->last_name = $request->last_name;
        $empleado->email = $request->email;
        $empleado->phone = $request->phone;
        $empleado->address = $request->address;
        $empleado->puesto_id = $request->puesto_id; // Actualiza el ID del puesto relacionado
        $empleado->hire_date = $request->hire_date;
        $empleado->salary = $request->salary;
        $empleado->identity = $request->identity; // Agregar identidad
        $empleado->emergency_number = $request->emergency_number; // Agregar número de emergencia
        $empleado->emergency_contact_name = $request->emergency_contact_name; // Agregar nombre de contacto de emergencia
        $empleado->save();

        return redirect()->route('empleados.index')->with('success', 'El empleado ' . $empleado->first_name . ' ' . $empleado->last_name . ' ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
