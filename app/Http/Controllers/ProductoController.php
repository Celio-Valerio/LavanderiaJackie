<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::with('categoria', 'proveedor')->get();

        // Retornar la vista con los productos
        return view('primary.productos.producto_index', compact('productos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Obtiene todas las categorías disponibles
        $proveedores = Proveedor::all(); // Obtiene todos los proveedores disponibles
        return view('primary.productos.producto_create', compact('categorias', 'proveedores')); // Pasa las categorías y proveedores a la vista
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
            'precio' => [
                'required',
                'numeric',
                'min:0', // Precio no puede ser negativo
            ],
            'categoria_id' => [
                'required',
                'exists:categorias,id', // Verifica que la categoría exista
            ],
            'proveedor_id' => [
                'required',
                'exists:proveedors,id', // Verifica que el proveedor exista
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.regex' => 'El nombre del producto solo puede contener letras, números y puntos.',

            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',

            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',

            'proveedor_id.required' => 'Debes seleccionar un proveedor.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',

            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
        ]);

        // Guardar producto en la base de datos
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = 0; // Asegúrate de añadir este campo en la migración
        $producto->categoria_id = 2; // Asignar la categoría relacionada
        $producto->proveedor_id = $request->proveedor_id; // Asignar el proveedor relacionado
        $producto->save();

        $nombreProducto = $request->nombre;
        return redirect()->route('productos.index')->with('success', 'El producto ' . $nombreProducto . ' ha sido registrado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
