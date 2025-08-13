<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los clientes de la base de datos
        $proveedores = Proveedor::all();
        $usuario = Auth::user();

        // Retornar una vista con los clientes
        return view('primary.proveedores.proveedor_index', compact('proveedores', 'usuario'));
    }

    public function reload($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return response()->json($proveedor);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Obtiene todos los puestos disponibles
        $usuario = Auth::user();
        return view('primary.proveedores.proveedor_create', compact('categorias', 'usuario')); // Pasa los puestos a la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){1,3}$/',
            ],
            'email' => [
                'nullable',
                'email',
                'unique:proveedors,email',
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:proveedors,phone',
            ],
            'company_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9.]+( [A-Za-zÁÉÍÓÚáéíóúÑñ0-9.]+){0,5}$/', // Permite hasta 6 palabras con letras y números
            ],
            'company_phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:proveedors,company_phone',
            ],
            'company_address' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
            'categoria_id' => [ // Nueva validación para categoria
                'required',
                'exists:categorias,id', // Verifica que el puesto exista
            ],
            'city' => [
                'required',
                'string',
                'max:50',
            ],
        ], [
        // full_name
        'full_name.required' => 'El nombre completo del proveedor es obligatorio.',
        'full_name.string' => 'El nombre completo debe ser texto.',
        'full_name.min' => 'El nombre completo debe tener al menos 3 caracteres.',
        'full_name.max' => 'El nombre completo no puede superar los 100 caracteres.',
        'full_name.regex' => 'El nombre completo puede contener hasta 4 palabras y no debe tener símbolos ni números.',

        // email
        'email.email' => 'El correo electrónico debe ser una dirección válida.',
        'email.max' => 'El correo electrónico no puede superar los 50 caracteres.',
        'email.unique' => 'El correo electrónico ya está en uso.',
        'email.regex' => 'El correo electrónico solo puede contener letras, números, arroba, punto, guion medio y guion bajo.',

        // phone
        'phone.required' => 'El teléfono del proveedor es obligatorio.',
        'phone.digits' => 'El número de teléfono del proveedor debe tener exactamente 8 dígitos.',
        'phone.regex' => 'El número de teléfono del proveedor debe empezar con 2, 3, 8 o 9.',
        'phone.unique' => 'El número de teléfono del proveedor ya está en uso.',

        // company_name
        'company_name.required' => 'El nombre de la empresa es obligatorio.',
        'company_name.string' => 'El nombre de la empresa debe ser texto.',
        'company_name.min' => 'El nombre de la empresa debe tener al menos 3 caracteres.',
        'company_name.max' => 'El nombre de la empresa no puede superar los 100 caracteres.',
        'company_name.regex' => 'El nombre de la empresa puede contener hasta 6 palabras con letras, números y puntos.',

        // company_phone
        'company_phone.required' => 'El teléfono de la empresa es obligatorio.',
        'company_phone.digits' => 'El número de teléfono de la empresa debe tener exactamente 8 dígitos.',
        'company_phone.regex' => 'El número de teléfono de la empresa debe empezar con 2, 3, 8 o 9.',
        'company_phone.unique' => 'El número de teléfono de la empresa ya está en uso.',

        // company_address
        'company_address.required' => 'La dirección de la empresa es obligatoria.',
        'company_address.string' => 'La dirección de la empresa debe ser texto.',
        'company_address.min' => 'La dirección de la empresa debe tener al menos 5 caracteres.',
        'company_address.max' => 'La dirección de la empresa no puede superar los 500 caracteres.',

        // categoria_id
        'categoria_id.required' => 'Debes seleccionar una categoría.',
        'categoria_id.exists' => 'La categoría seleccionada no es válida.',

        // city
        'city.required' => 'Debes ingresar un departamento.',
        'city.string' => 'El departamento debe ser texto.',
        'city.max' => 'El departamento no puede superar los 50 caracteres.',
    ]);

        // Guardar proveedor en la base de datos
        $proveedor = new Proveedor();
        $proveedor->full_name = $request->full_name;
        $proveedor->email = $request->email;
        $proveedor->phone = $request->phone;
        $proveedor->company_name = $request->company_name;
        $proveedor->company_phone = $request->company_phone;
        $proveedor->company_address = $request->company_address;
        $proveedor->city = $request->city;
        $proveedor->categoria_id = $request->categoria_id; // Asignar la categoria relacionada
        $proveedor->save();

        $nombreProveedor = $request-> full_name;
        $nombreEmpresa = $request-> company_name;
        return redirect()->route('proveedores.index')->with('success', 'El proveedor ' .$nombreProveedor . ' de la empresa ' . $nombreEmpresa . ' ha sido registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca al cliente por su ID
        $proveedor = Proveedor::findOrFail($id);

        // Retorna la vista 'clientes.show' y le pasa los datos del cliente
        $usuario = Auth::user();

        return view('primary.proveedores.proveedor_show', compact('proveedor', 'usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id); // Obtiene el empleado por ID
        $categorias = Categoria::all(); // Obtiene todos los puestos disponibles
        $usuario = Auth::user();

        return view('primary.proveedores.proveedor_update', compact('proveedor', 'categorias', 'usuario'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){1,3}$/',
            ],
            'email' => [
                'nullable',
                'email',
                'max:50',
                'unique:proveedors,email,' . $id,
                'regex:/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:proveedors,phone,' . $id,
            ],
            'company_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9.]+( [A-Za-zÁÉÍÓÚáéíóúÑñ0-9.]+){0,5}$/',
            ],
            'company_phone' => [
                'required',
                'digits:8',
                'regex:/^[2389][0-9]{7}$/',
                'unique:proveedors,company_phone,' . $id,
            ],
            'company_address' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],
            'city' => [
                'required',
                'string',
                'max:50',
            ],
        ], [
            // full_name
            'full_name.required' => 'El nombre completo del proveedor es obligatorio.',
            'full_name.string' => 'El nombre completo debe ser texto.',
            'full_name.min' => 'El nombre completo debe tener al menos 3 caracteres.',
            'full_name.max' => 'El nombre completo no puede superar los 100 caracteres.',
            'full_name.regex' => 'El nombre completo puede contener hasta 4 palabras y no debe tener símbolos ni números.',

            // email
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.max' => 'El correo electrónico no puede superar los 50 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.regex' => 'El correo electrónico solo puede contener letras, números, arroba, punto, guion medio y guion bajo.',

            // phone
            'phone.required' => 'El teléfono del proveedor es obligatorio.',
            'phone.digits' => 'El número de teléfono del proveedor debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono del proveedor debe empezar con 2, 3, 8 o 9.',
            'phone.unique' => 'El número de teléfono del proveedor ya está en uso.',

            // company_name
            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'company_name.string' => 'El nombre de la empresa debe ser texto.',
            'company_name.min' => 'El nombre de la empresa debe tener al menos 3 caracteres.',
            'company_name.max' => 'El nombre de la empresa no puede superar los 100 caracteres.',
            'company_name.regex' => 'El nombre de la empresa puede contener hasta 6 palabras con letras, números y puntos.',

            // company_phone
            'company_phone.required' => 'El teléfono de la empresa es obligatorio.',
            'company_phone.digits' => 'El número de teléfono de la empresa debe tener exactamente 8 dígitos.',
            'company_phone.regex' => 'El número de teléfono de la empresa debe empezar con 2, 3, 8 o 9.',
            'company_phone.unique' => 'El número de teléfono de la empresa ya está en uso.',

            // company_address
            'company_address.required' => 'La dirección de la empresa es obligatoria.',
            'company_address.string' => 'La dirección de la empresa debe ser texto.',
            'company_address.min' => 'La dirección de la empresa debe tener al menos 5 caracteres.',
            'company_address.max' => 'La dirección de la empresa no puede superar los 500 caracteres.',

            // categoria_id
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',

            // city
            'city.required' => 'Debes ingresar un departamento.',
            'city.string' => 'El departamento debe ser texto.',
            'city.max' => 'El departamento no puede superar los 50 caracteres.',
        ]);

        // Actualizar proveedor
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->full_name = $request->full_name;
        $proveedor->email = $request->email;
        $proveedor->phone = $request->phone;
        $proveedor->company_name = $request->company_name;
        $proveedor->company_phone = $request->company_phone;
        $proveedor->company_address = $request->company_address;
        $proveedor->city = $request->city;
        $proveedor->categoria_id = $request->categoria_id;

        $proveedor->save();

        return redirect()->route('proveedores.index')
            ->with('success', 'El proveedor ' . $request->full_name . ' de la empresa ' . $request->company_name . ' ha sido actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
