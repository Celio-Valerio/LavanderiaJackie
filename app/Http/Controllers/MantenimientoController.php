<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Maquinaria;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los mantenimientos de la base de datos
        $mantenimientos = Mantenimiento::all();

        // Retornar una vista con los mantenimientos
        return view('primary.mantenimientos.mantenimiento_index', compact('mantenimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maquinarias = Maquinaria::all(); // Obtener todas las máquinas para el select
        return view('primary.mantenimientos.mantenimiento_create', compact('maquinarias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'date' => [
                'required',
                'date', // Verifica que el formato sea una fecha válida
            ],
            'maquinaria_id' => [
                'required',
                'exists:maquinarias,id', // Asegura que el id de la máquina exista en la tabla maquinarias
            ],
            'maintenance_type' => [
                'required',
                'in:Preventivo,Correctivo,Predictivo,Emergencia', // Solo permite estos tipos de mantenimiento
            ],
            'description' => [
                'nullable',
                'string', // Permite que sea una cadena
                'max:500', // Limita la longitud máxima
            ],
            'price' => [
                'required',
                'numeric', // Verifica que sea un número
                'min:0', // Asegura que el precio no sea negativo
            ],
        ], [
            'date.required' => 'La fecha del mantenimiento es obligatoria.',
            'date.date' => 'La fecha debe ser una fecha válida.',

            'maquinaria_id.required' => 'Debes seleccionar una máquina.',
            'maquinaria_id.exists' => 'La máquina seleccionada no es válida.',

            'maintenance_type.required' => 'Debes seleccionar un tipo de mantenimiento.',

            'description.string' => 'La descripción debe ser una cadena de texto válida.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio no puede ser negativo.',
        ]);

        // Guardar mantenimiento en la base de datos
        $mantenimiento = new Mantenimiento();
        $mantenimiento->date = $request->date;
        $mantenimiento->maquinaria_id = $request->maquinaria_id;
        $mantenimiento->maintenance_type = $request->maintenance_type; // Asignar el tipo de mantenimiento
        $mantenimiento->description = $request->description; // Asignar la descripción
        $mantenimiento->price = $request->price; // Asignar el precio
        $mantenimiento->save();

        return redirect()->route('mantenimientos.index')->with('success', 'El mantenimiento ha sido registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Encontrar el mantenimiento por su ID
        $mantenimiento = Mantenimiento::findOrFail($id);

        // Retornar una vista con los detalles del mantenimiento
        return view('primary.mantenimientos.mantenimiento_show', compact('mantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Encontrar el mantenimiento por su ID
        $mantenimiento = Mantenimiento::findOrFail($id);

        // Obtener todas las máquinas para el select
        $maquinarias = Maquinaria::all();

        // Retornar una vista con el formulario de edición
        return view('primary.mantenimientos.mantenimiento_update', compact('mantenimiento', 'maquinarias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            'date' => [
                'required',
                'date',
            ],
            'maquinaria_id' => [
                'required',
                'exists:maquinarias,id', // Asegúrate de que la máquina existe en la tabla maquinarias
            ],
            'maintenance_type' => [
                'required',
                'in:Preventivo,Correctivo,Predictivo,Emergencia', // Opciones en español
            ],
            'description' => [
                'nullable',
                'string',
                'max:500', // Puedes ajustar el tamaño máximo según lo necesites
            ],
            'price' => [
                'required',
                'numeric',
                'min:0', // El precio debe ser un número positivo
            ],
        ], [
            'date.required' => 'La fecha del mantenimiento es obligatoria.',
            'date.date' => 'La fecha debe ser una fecha válida.',

            'maquinaria_id.required' => 'Debes seleccionar una máquina.',
            'maquinaria_id.exists' => 'La máquina seleccionada no es válida.',

            'maintenance_type.required' => 'Debes seleccionar un tipo de mantenimiento.',

            'description.string' => 'La descripción debe ser una cadena de texto válida.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio no puede ser negativo.',
        ]);

        // Buscar el mantenimiento en la base de datos
        $mantenimiento = Mantenimiento::findOrFail($id);

        // Actualizar los campos del mantenimiento
        $mantenimiento->date = $request->date;
        $mantenimiento->maquinaria_id = $request->maquinaria_id;
        $mantenimiento->maintenance_type = $request->maintenance_type;
        $mantenimiento->description = $request->description;
        $mantenimiento->price = $request->price;
        $mantenimiento->save();

        return redirect()->route('mantenimientos.index')->with('success', 'El mantenimiento ha sido actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
