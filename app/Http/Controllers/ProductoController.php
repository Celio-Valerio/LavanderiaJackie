<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ProductoPrecioHistorial;
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
        $productos = Producto::with('categoria')->get();

        // Retornar la vista con los productos
        return view('primary.productos.producto_index', compact('productos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Obtiene todas las categorías disponibles
        return view('primary.productos.producto_create', compact('categorias')); // Pasa las categorías y proveedores a la vista
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
                'min:1', // Precio no puede ser negativo
            ],
            'categoria_id' => [
                'required',
                'exists:categorias,id', // Verifica que la categoría exista
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:500',
            ],
            'presentacion' => [
                'required',
            ],
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.regex' => 'El nombre del producto solo puede contener letras y números.',

            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio del producto debe ser mayor a L. 0.00.',

            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',

            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',

            'presentacion.required' => 'Debes seleccionar la presentación del producto.',
        ]);

        // Guardar producto en la base de datos
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->presentacion = $request->presentacion;
        $producto->stock = 0; // Asegúrate de añadir este campo en la migración
        $producto->categoria_id = 2; // Asignar la categoría relacionada
        $producto->save();

        $nombreProducto = $request->nombre;
        return redirect()->route('productos.index')->with('success', 'El producto ' . $nombreProducto . ' ha sido registrado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
// En el controlador ProductoController
    public function show($id)
    {
        // Obtener el producto por ID
        $producto = Producto::findOrFail($id);

        // Obtener el historial de precios usando la relación definida en el modelo Producto
        // Asegúrate de que el nombre de la columna sea 'fecha_cambio' en la base de datos
        $historialPrecios = $producto->historialPrecios()->orderBy('fecha_cambio', 'desc')->get();  // Asegúrate de tener la columna 'fecha_cambio' en tu tabla

        // Pasar los datos a la vista
        return view('primary.productos.producto_show', compact('producto', 'historialPrecios'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id); // Busca el producto o lanza un error si no existe
        $categorias = Categoria::all(); // Obtiene todas las categorías disponibles
        return view('primary.productos.producto_update', compact('producto', 'categorias'));
    }

    /**
     * Actualiza el producto y su precio en la base de datos
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
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9. ]+$/', // Permite letras, números y puntos
            ],
            'precio' => [
                'required',
                'numeric',
                'min:1', // Precio no puede ser negativo
            ],
            'categoria_id' => [
                'required',
                'exists:categorias,id', // Verifica que la categoría exista
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:500',
            ],
            'presentacion' => [
                'required',
            ],
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.regex' => 'El nombre del producto solo puede contener letras y números.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio del producto debe ser mayor a L. 0.00.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
            'presentacion.required' => 'Debes seleccionar la presentación del producto.',
        ]);

        // Obtener el producto
        $producto = Producto::findOrFail($id);

        // Verificar si el precio ha cambiado
        if ($producto->precio != $request->precio) {
            // Crear historial del cambio de precio
            ProductoPrecioHistorial::create([
                'producto_id' => $producto->id,
                'precio_anterior' => $producto->precio,
                'precio_nuevo' => $request->precio,
                'fecha_cambio' => now(), // Fecha actual
            ]);
        }

        // Actualizar producto en la base de datos
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio; // Actualizamos el precio
        $producto->presentacion = $request->presentacion;
        $producto->categoria_id = $request->categoria_id; // Usar la categoría seleccionada por el usuario
        $producto->save();

        $nombreProducto = $request->nombre;
        return redirect()->route('productos.index')->with('success', 'El producto ' . $nombreProducto . ' ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
