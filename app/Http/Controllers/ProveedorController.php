<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los clientes de la base de datos
        $proveedores = Proveedor::all();

        // Retornar una vista con los clientes
        return view('primary.proveedores.proveedor_index', compact('proveedores'));
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
        return view('primary.proveedores.proveedor_create'); // Asegúrate de tener la vista en 'resources/views/clientes/create.blade.php'
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
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,5}$/', // Permite hasta 6 palabras
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
        ], [
            'full_name.required' => 'El nombre completo del proveedor es obligatorio.',
            'full_name.regex' => 'El nombre completo puede contener hasta 4 palabras y no debe tener símbolos ni números.',

            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',

            'phone.required' => 'El teléfono del proveedor es obligatorio.',
            'phone.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',
            'phone.unique' => 'El número de teléfono ya está en uso.',

            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'company_name.regex' => 'El nombre de la empresa puede contener hasta 6 palabras y no debe tener símbolos ni números.',

            'company_phone.required' => 'El teléfono de la empresa es obligatorio.',
            'company_phone.digits' => 'El número de teléfono de la empresa debe tener exactamente 8 dígitos.',
            'company_phone.regex' => 'El número de teléfono de la empresa debe empezar con 2, 3, 8 o 9.',
            'company_phone.unique' => 'El número de teléfono de la empresa ya está en uso.',

            'company_address.required' => 'La dirección de la empresa es obligatoria.',
        ]);

        // Guardar proveedor en la base de datos
        $proveedor = new Proveedor();
        $proveedor->full_name = $request->full_name;
        $proveedor->email = $request->email;
        $proveedor->phone = $request->phone;
        $proveedor->company_name = $request->company_name;
        $proveedor->company_phone = $request->company_phone;
        $proveedor->company_address = $request->company_address;
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

        return view('primary.proveedores.proveedor_show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id); // Obtiene el cliente por ID
        return view('primary.proveedores.proveedor_update', compact('proveedor')); // Retorna la vista de edición
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
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,5}$/',
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
        ], [
            'full_name.required' => 'El nombre completo del proveedor es obligatorio.',
            'full_name.regex' => 'El nombre completo puede contener hasta 4 palabras y no debe tener símbolos ni números.',

            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',

            'phone.required' => 'El teléfono del proveedor es obligatorio.',
            'phone.digits' => 'El número de teléfono debe tener exactamente 8 dígitos.',
            'phone.regex' => 'El número de teléfono debe empezar con 2, 3, 8 o 9.',
            'phone.unique' => 'El número de teléfono ya está en uso.',

            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'company_name.regex' => 'El nombre de la empresa puede contener hasta 6 palabras y no debe tener símbolos ni números.',

            'company_phone.required' => 'El teléfono de la empresa es obligatorio.',
            'company_phone.digits' => 'El número de teléfono de la empresa debe tener exactamente 8 dígitos.',
            'company_phone.regex' => 'El número de teléfono de la empresa debe empezar con 2, 3, 8 o 9.',
            'company_phone.unique' => 'El número de teléfono de la empresa ya está en uso.',

            'company_address.required' => 'La dirección de la empresa es obligatoria.',
        ]);

        // Actualizar proveedor en la base de datos
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->full_name = $request->full_name;
        $proveedor->email = $request->email;
        $proveedor->phone = $request->phone;
        $proveedor->company_name = $request->company_name;
        $proveedor->company_phone = $request->company_phone;
        $proveedor->company_address = $request->company_address;
        $proveedor->save();

        $nombreProveedor = $request-> full_name;
        $nombreEmpresa = $request-> company_name;

        return redirect()->route('proveedores.index')->with('success', 'El proveedor ' .$nombreProveedor . ' de la empresa ' . $nombreEmpresa . ' ha sido actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
