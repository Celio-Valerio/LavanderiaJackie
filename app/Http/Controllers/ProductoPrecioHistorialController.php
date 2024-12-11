<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoPrecioHistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        // Guardar el precio anterior
        $precioAnterior = $producto->precio;

        // Actualizar el producto
        $producto->update([
            'precio' => $request->precio,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'presentacion' => $request->presentacion,
        ]);

        // Crear un historial de precios
        ProductoPrecioHistorial::create([
            'producto_id' => $producto->id,
            'precio_anterior' => $precioAnterior,
            'precio_nuevo' => $producto->precio,
            'fecha_cambio' => now(),
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
