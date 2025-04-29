<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::with('categoria', 'proveedor')->get();
        $usuario = Auth::user();

        // Retornar la vista con los productos
        return view('primary.inventarios.inventarios_index', compact('productos', 'usuario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->input('idProducto');
        $producto = Producto::find($id);
        $cantidad = $request->input('consumo');

        if ($producto) {
            $producto->stock -= $cantidad;

        }
        if ($producto->save()){
            return redirect()->route('inventarios.index')->with('success', 'Consumo registrado exitosamente.');

        }
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


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
