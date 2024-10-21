<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquina;

class MaquinaController extends Controller
{
    public function index()
    {
        $maquinas = Maquina::all();

        return view('primary.maquinarias.maquinas_index', compact('maquinas'));
    }

    public function create()
    {
        $maquinas = Maquina::all();
        return view('primary.maquinarias.maquinas_create', compact('maquinas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|regex:/^[a-zA-Z0-9]{1,15}$/', // Modelo: letras y números, máximo 15 caracteres
            'capacidad' => 'required|integer|max:100', // Capacidad: máximo 100 kg
            'marca' => 'required|string|max:50',
            'proveedor' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
            'serie' => 'required|digits_between:1,10|integer|unique:maquinas,serie', // Serie: solo números, máximo 10 dígitos
            'descripcion' => 'nullable|string',
            'anio_compra' => 'required|integer|min:1900|max:' . date('Y'), // Asegurarse de que no sea mayor que el año actual
            'tipo' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.max' => 'La capacidad no puede ser mayor que 100 kg.',
            'anio_compra.required' => 'El año de compra es obligatorio.',
            'anio_compra.integer' => 'El año de compra debe ser un número entero.',
            'anio_compra.min' => 'El año de compra debe ser al menos 1900.',
            'anio_compra.max' => 'El año de compra no puede ser mayor que el año actual.',
            'tipo.string' => 'El tipo debe ser una cadena de texto.',
            'serie.required' => 'La serie es obligatoria.',
            'serie.digits_between' => 'La serie debe contener solo números y tener un máximo de 10 dígitos.',
            'serie.unique' => 'La serie ya está registrada.',
            'marca.required' => 'La marca es obligatoria.',
            'proveedor.required' => 'El proveedor es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.regex' => 'El modelo debe contener solo letras y números, y tener un máximo de 15 caracteres.',
        ]);

        // Guardar máquina en la base de datos
        $maquina = new Maquina();
        $maquina->nombre = $request->nombre;
        $maquina->modelo = $request->modelo;
        $maquina->capacidad = $request->capacidad;
        $maquina->marca = $request->marca;
        $maquina->proveedor = $request->proveedor;
        $maquina->anio_compra = $request->anio_compra;
        $maquina->tipo = $request->tipo;
        $maquina->descripcion = $request->descripcion;
        $maquina->estado = $request->estado;
        $maquina->serie = $request->serie; // Guardar serie
        $maquina->save();

        // Retornar a la vista con un mensaje de éxito
        return redirect()->route('maquinarias.index')->with('success', 'La máquina ' . $maquina->nombre . ' ha sido registrada exitosamente.');
    }

    public function show($maquina)
    {
        // Obtener la máquina por su ID
        $maquina = Maquina::findOrFail($maquina);

        // Retornar la vista con la información de la máquina
        return view('primary.maquinarias.maquinas_show', compact('maquina'));
    }

    public function edit($id)
    {

        $maquina = Maquina::findOrFail($id);
     
        return view('primary.maquinarias.maquinas_update', compact('maquina'));
    }

    public function update(Request $request, string $id)
    {
       
        $request->validate([
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|regex:/^[a-zA-Z0-9]{1,15}$/',// Modelo: letras y números, máximo 15 caracteres
            'capacidad' => 'required|integer|max:100', // Capacidad: máximo 100 kg
            'marca' => 'required|string|max:50',
            'proveedor' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
            'serie' => 'required|digits_between:1,10|integer|unique:maquinas,serie,' . $id, // Serie: solo números, máximo 10 dígitos
            'descripcion' => 'nullable|string',
            'anio_compra' => 'required|integer|min:1900|max:' . date('Y'), // Asegurarse de que no sea mayor que el año actual
            'tipo' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.max' => 'La capacidad no puede ser mayor que 100 kg.',
            'anio_compra.required' => 'El año de compra es obligatorio.',
            'anio_compra.integer' => 'El año de compra debe ser un número entero.',
            'anio_compra.min' => 'El año de compra debe ser al menos 1900.',
            'anio_compra.max' => 'El año de compra no puede ser mayor que el año actual.',
            'tipo.string' => 'El tipo debe ser una cadena de texto.',
            'serie.required' => 'La serie es obligatoria.',
            'serie.digits_between' => 'La serie debe contener solo números y tener un máximo de 10 dígitos.',
            'serie.unique' => 'La serie ya está registrada.',
            'marca.required' => 'La marca es obligatoria.',
            'proveedor.required' => 'El proveedor es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.regex' => 'El modelo debe contener solo letras y números, y tener un máximo de 15 caracteres.',
        ]);

        // Actualizar máquina
      
        $maquina->nombre = $request->nombre;
        $maquina->modelo = $request->modelo;
        $maquina->capacidad = $request->capacidad;
        $maquina->marca = $request->marca;
        $maquina->proveedor = $request->proveedor;
        $maquina->anio_compra = $request->anio_compra;
        $maquina->tipo = $request->tipo;
        $maquina->descripcion = $request->descripcion;
        $maquina->estado = $request->estado;
        $maquina->serie = $request->serie; // Guardar serie
        $maquina->save();

        // Retornar a la vista con un mensaje de éxito
        return redirect()->route('maquinarias.index')->with('success', 'La máquina ' . $maquina->nombre . ' ha sido actualizada exitosamente.');
    }
}
