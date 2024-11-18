<?php
namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los servicios
        $servicios = Servicio::all();
        return view('primary.servicios.servicio_index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('primary.servicios.servicio_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9. ]+$/', // Permite letras, números y puntos
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:500',
            ],
            'precio' => [
                'required',
                'numeric',
                'min:0.01', // Precio debe ser mayor a 0
            ],
            'duracion_estimada' => [
                'nullable',
                'integer',
                'min:1',
                'max:2881', // Máximo 2 días horas (2881 minutos)
            ],
            'estado' => [
                'required',
                'boolean',
            ],
            'articulos' => [
                'required',
                'array',
            ],
            'extras' => [
                'required',
                'array',
            ],
        ], [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.min' => 'El nombre del servicio debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre del servicio no puede exceder los 100 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras, números y puntos.',

            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',

            'precio.required' => 'El precio del servicio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio debe ser mayor a L. 0.00.',

            'duracion_estimada.integer' => 'La duración debe ser un número entero.',
            'duracion_estimada.requerid' => 'La duración estimada es obligatoria.',
            'duracion_estimada.min' => 'La duración debe ser al menos 1 minuto.',
            'duracion_estimada.max' => 'La duración máxima es de 1440 minutos (24 horas).',

            'estado.required' => 'El estado del servicio es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',

            'articulos.required' => 'Debes seleccionar al menos artículo para el servicio.',
            'extras.required' => 'Debes seleccionar al menos un extra para el servicio.',
        ]);

        // Guardar el servicio en la base de datos
        $servicio = new Servicio();
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
        $servicio->duracion_estimada = $request->duracion_estimada;
        $servicio->estado = $request->estado;
        $servicio->articulos = json_encode($request->articulos);
        $servicio->extras = json_encode($request->extras);
        $servicio->save();

        return redirect()->route('servicios.index')->with('success', 'El servicio ha sido registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener el servicio por ID
        $servicio = Servicio::findOrFail($id);
        return view('primary.servicios.servicio_show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('primary.servicios.servicio_edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|min:3|max:100|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9. ]+$/',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0.01',
            'duracion_estimada' => 'nullable|integer|min:1|max:1440',
            'estado' => 'required|boolean',
            'articulos' => 'nullable|json',
            'extras' => 'nullable|json',
        ]);

        // Actualizar el servicio
        $servicio = Servicio::findOrFail($id);
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
        $servicio->duracion_estimada = $request->duracion_estimada;
        $servicio->estado = $request->estado;
        $servicio->articulos = $request->articulos;
        $servicio->extras = $request->extras;
        $servicio->save();

        return redirect()->route('servicios.index')->with('success', 'El servicio ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'El servicio ha sido eliminado exitosamente.');
    }

    /**
     * Toggle the status of the service.
     */
    public function toggleStatus($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->estado = !$servicio->estado;
        $servicio->save();

        return redirect()->route('servicios.index')->with('success', 'El estado del servicio ha sido cambiado exitosamente.');
    }
}
