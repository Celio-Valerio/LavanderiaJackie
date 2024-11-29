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
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]+$/', // Permite letras, números y puntos
            ],
            'descripcion' => [
                'required',
                'string',
                'max:500',
            ],
            'precio' => [
                'required',
                'numeric',
                'min:0.01', // Precio debe ser mayor a 0
                'max:99.99',
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
            'nombre.regex' => 'El nombre solo puede contener letras ó números.',

            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',

            'precio.required' => 'El precio en libras es obligatorio.',
            'precio.numeric' => 'El precio en libras debe ser expresado en números.',
            'precio.min' => 'El precio en libras debe ser mayor a L. 0.00.',
            'precio.max' => 'El precio en libras debe ser menor o igual a L. 99.99.',

            'articulos.required' => 'Debes seleccionar al menos artículo para el servicio.',
            'extras.required' => 'Debes seleccionar al menos un extra para el servicio.',
        ]);

        // Guardar el servicio en la base de datos
        $servicio = new Servicio();
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
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
        return view('primary.servicios.servicio_update', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]+$/', // Permite letras, números y puntos
            ],
            'descripcion' => [
                'required',
                'string',
                'max:500',
            ],
            'precio' => [
                'required',
                'numeric',
                'min:0.01', // Precio debe ser mayor a 0
                'max:99.99',
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
            'nombre.regex' => 'El nombre solo puede contener letras ó números.',

            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',

            'precio.required' => 'El precio en libras es obligatorio.',
            'precio.numeric' => 'El precio en libras debe ser expresado en números.',
            'precio.min' => 'El precio en libras debe ser mayor a L. 0.00.',
            'precio.max' => 'El precio en libras debe ser menor o igual a L. 99.99.',

            'articulos.required' => 'Debes seleccionar al menos artículo para el servicio.',
            'extras.required' => 'Debes seleccionar al menos un extra para el servicio.',
        ]);

        // Actualizar el servicio
        $servicio = Servicio::findOrFail($id);
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
        $servicio->articulos = json_encode($request->articulos);
        $servicio->extras = json_encode($request->extras);
        $servicio->save();

        return redirect()->route('servicios.index')->with('success', 'El servicio ha sido actualizado exitosamente.');
    }
}
