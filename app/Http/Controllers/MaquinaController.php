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
        return view('primary.maquinarias.maquinas_create', ['maquina' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|regex:/^[a-zA-Z0-9]{1,15}$/', // Modelo: letras y números, máximo 15 caracteres
            'capacidad' => 'required|integer',
            'marca' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'fecha_adquisicion' => 'required|date',
            'estado' => 'required|string|max:255',
            'serie' => 'required|digits_between:1,10|integer|unique:maquinas,serie', // Serie: solo números, máximo 10 dígitos
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.regex' => 'El modelo debe contener solo letras y números, y tener un máximo de 15 caracteres.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'marca.required' => 'La marca es obligatoria.',
            'proveedor.required' => 'El proveedor es obligatorio.',
            'fecha_adquisicion.required' => 'La fecha de adquisición es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
            'serie.required' => 'La serie es obligatoria.',
            'serie.digits_between' => 'La serie debe contener solo números y tener un máximo de 10 dígitos.',
            'serie.unique' => 'La serie ya está registrada.',
        ]);

        // Guardar máquina en la base de datos
        $maquina = new Maquina();
        $maquina->nombre = $request->nombre;
        $maquina->modelo = $request->modelo;
        $maquina->capacidad = $request->capacidad;
        $maquina->anio_fabricacion = $request->anio_fabricacion;
        $maquina->marca = $request->marca;
        $maquina->proveedor = $request->proveedor;
        $maquina->fecha_adquisicion = $request->fecha_adquisicion;
        $maquina->estado = $request->estado;
        $maquina->serie = $request->serie; // Guardar serie
        $maquina->save();

        return redirect()->route('maquinas.index')->with('success', 'La máquina ' . $maquina->nombre . ' ha sido registrada exitosamente.');
    }

    public function edit(Maquina $maquina)
    {
        return view('primary.maquinarias.maquinas_update', compact('maquina'));
    }



    public function update(Request $request, Maquina $maquina) 
    {
        $maquina = Maquina::findOrFail($maquina->id);
    
        $request->validate([
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|regex:/^[a-zA-Z0-9]{1,15}$/', // Modelo: letras y números, máximo 15 caracteres
            'capacidad' => 'required|integer|max:100|min:1',
            'serie' => 'required|digits_between:1,10|integer|unique:maquinas,serie,' . $maquina->id, // Serie: solo números, máximo 10 dígitos
            'marca' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'fecha_adquisicion' => 'required|date|before_or_equal:today',
            'estado' => 'required|string|max:255',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.regex' => 'El modelo debe contener solo letras y números, y tener un máximo de 15 caracteres.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'serie.required' => 'La serie es obligatoria.',
            'serie.digits_between' => 'La serie debe contener solo números y tener un máximo de 10 dígitos.',
            'serie.unique' => 'La serie ya está registrada.',
            'marca.required' => 'La marca es obligatoria.',
            'proveedor.required' => 'El proveedor es obligatorio.',
            'fecha_adquisicion.required' => 'La fecha de adquisición es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        $maquina->nombre = $request->nombre;
        $maquina->modelo = $request->modelo;
        $maquina->capacidad = $request->capacidad;
        $maquina->anio_fabricacion = $request->anio_fabricacion;
        $maquina->marca = $request->marca;
        $maquina->proveedor = $request->proveedor;
        $maquina->fecha_adquisicion = $request->fecha_adquisicion;
        $maquina->estado = $request->estado;
        $maquina->serie = $request->serie; // Guardar serie
        $maquina->save();
      
        return redirect()->route('maquinas.index')->with('success', 'La máquina ' . $maquina->nombre . ' ha sido actualizada exitosamente.');
    }

    public function show($id)
    {
        // Obtener la máquina por su ID
        $maquina = Maquina::findOrFail($id);

        // Retornar la vista con la información de la máquina
        return view('primary.maquinarias.maquinas_show', compact('maquina'));
    }
}
