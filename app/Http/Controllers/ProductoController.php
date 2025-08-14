<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ProductoPrecioHistorial;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::with('categoria')->get();
        $usuario = Auth::user();

        // Retornar la vista con los productos
        return view('primary.productos.producto_index', compact('productos', 'usuario'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Obtiene todas las categorías disponibles
        $proveedores = Proveedor::all(); // Obtiene todos los proveedores disponibles
        $usuario = Auth::user();
        return view('primary.productos.producto_create', compact('categorias', 'proveedores', 'usuario')); // Pasa los datos a la vista
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
            'proveedor_id' => [
                'required',
                'exists:proveedors,id', // Verifica que el proveedor exista
            ],
            'descripcion' => [
                'required',
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

            'proveedor_id.required' => 'Debes seleccionar un proveedor.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',

            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
            'descripcion.required' => 'Method… del producto es obligatoria.',

            'presentacion.required' => 'Debes seleccionar la presentación del producto.',
        ]);

        // Guardar producto en la base de datos
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->presentacion = $request->presentacion;
        $producto->stock = 0; // Asegúrate de añadir este campo en la migración
        $producto->categoria_id = $request->categoria_id;
        $producto->proveedor_id = $request->proveedor_id; // Asignar el proveedor
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'El producto ' . $producto->nombre . ' ha sido registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
// En el controlador ProductoController
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        $usuario  = Auth::user();

        // Traer historial en orden ascendente para identificar el primero (más antiguo)
        $historial = $producto->historialPrecios()
            ->orderBy('fecha_cambio', 'asc')
            ->get();

        // Construir colección que incluya el precio inicial
        $historialConInicial = collect();

        if ($historial->isNotEmpty()) {
            // Si existe precio_anterior en el historial, úsalo; si no, usa el precio del producto al crearse
            $primerRegistro = $historial->first();
            $precioInicial  = $primerRegistro->precio_anterior ?? $producto->precio;
            $fechaInicial   = $producto->created_at;

            // Agregar fila "inicial"
            $historialConInicial->push((object) [
                'fecha_cambio'  => $fechaInicial,
                'precio_mostrar'=> $precioInicial,
                'es_inicial'    => true,
            ]);

            // Agregar el resto de cambios del historial usando precio_nuevo
            foreach ($historial as $h) {
                $historialConInicial->push((object) [
                    'fecha_cambio'  => $h->fecha_cambio,
                    'precio_mostrar'=> $h->precio_nuevo, // ajusta si tu campo se llama distinto
                    'es_inicial'    => false,
                ]);
            }
        } else {
            // No hay historial: mostrar solo el precio inicial del producto
            $historialConInicial->push((object) [
                'fecha_cambio'  => $producto->created_at,
                'precio_mostrar'=> $producto->precio,
                'es_inicial'    => true,
            ]);
        }

        // Orden para mostrar: más reciente primero
        $historialParaVista = $historialConInicial->sortByDesc('fecha_cambio')->values();

        return view('primary.productos.producto_show', [
            'producto'           => $producto,
            'historialPrecios'   => $historialParaVista,
            'usuario'            => $usuario,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id); // Busca el producto o lanza un error si no existe
        $categorias = Categoria::all(); // Obtiene todas las categorías disponibles
        $proveedores = Proveedor::all(); // Obtiene todos los proveedores disponibles
        $usuario = Auth::user();
        return view('primary.productos.producto_update', compact('producto', 'categorias', 'proveedores', 'usuario'));
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
            'proveedor_id' => [
                'required',
                'exists:proveedors,id', // Verifica que el proveedor exista
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
            'proveedor_id.required' => 'Debes seleccionar un proveedor.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
            'descripcion.required' => 'Method… del producto es obligatoria.',
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
        $producto->proveedor_id = $request->proveedor_id; // Usar el proveedor seleccionado por el usuario
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'El producto ' . $producto->nombre . ' ha sido actualizado exitosamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
