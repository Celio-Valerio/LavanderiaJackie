<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los clientes de la base de datos
        $clientes = Cliente::all();

        // Retornar una vista con los clientes
        return view('primary.clientes.cliente_index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('primary.clientes.cliente_create'); // Asegúrate de tener la vista en 'resources/views/clientes/create.blade.php'
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
            'email' => [
                'nullable',
                'email',
                'unique:clientes,email',
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:clientes,phone',
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],

            'type' => [
                'required',
                'in:Contado,Credito', // Solo permite estos dos valores
            ],
        ], [
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
            'phone.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',
            'phone.unique' => 'El número de teléfono ya está en uso.',

            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto válida.',
            'address.min' => 'La dirección debe tener al menos 5 caracteres.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',

            'type.required' => 'El tipo de cliente es obligatorio.',
            'type.in' => 'El tipo de cliente debe ser Contado o Crédito.',
        ]);

        // Guardar cliente en la base de datos
        $cliente = new Cliente();
        $cliente->first_name = $request->first_name;
        $cliente->last_name = $request->last_name;
        $cliente->email = $request->email;
        $cliente->phone = $request->phone;
        $cliente->address = $request->address;
        $cliente->type = $request->type;  // Asignar el tipo de cliente
        $cliente->save();

        $nombresCliente = $request-> first_name;
        $apellidosCliente = $request-> first_name;
        return redirect()->route('clientes.index')->with('success', 'El cliente ' .$nombresCliente . ' ' . $apellidosCliente . ' ha sido registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca al cliente por su ID
        $cliente = Cliente::findOrFail($id);

        // Retorna la vista 'clientes.show' y le pasa los datos del cliente

        return view('primary.clientes.cliente_show', compact('cliente'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::findOrFail($id); // Obtiene el cliente por ID
        return view('primary.clientes.cliente_update', compact('cliente')); // Retorna la vista de edición
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cliente = Cliente::findOrFail($id); // Obtiene el cliente por ID

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
            'email' => [
                'nullable',
                'email',
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:clientes,email,' . $cliente->id, // Permite el mismo correo del cliente que se está editando
            ],
            'phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:clientes,phone,' . $cliente->id,
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],

            'type' => [
                'required',
                'in:Contado,Credito', // Solo permite estos dos valores
            ],
        ], [
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
            'phone.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',
            'phone.unique' => 'El número de teléfono ya está en uso.',

            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto válida.',
            'address.min' => 'La dirección debe tener al menos 5 caracteres.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',

            'type.required' => 'El tipo de cliente es obligatorio.',
            'type.in' => 'El tipo de cliente debe ser Contado o Crédito.',
        ]);

        // Actualizar cliente en la base de datos
        $cliente->first_name = $request->first_name;
        $cliente->last_name = $request->last_name;
        $cliente->email = $request->email;
        $cliente->phone = $request->phone;
        $cliente->address = $request->address;
        $cliente->type = $request->type;
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'El cliente ' . $cliente->first_name . ' ' . $cliente->last_name . ' ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
