<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los compras de la base de datos
        $compras = Compra::all();

        // Retornar una vista con los compras
        return view('primary.compras.compra_index', compact('compras'));
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
    public function show($id)
    {
        // Busca la compra por su ID, incluyendo las relaciones con el proveedor y detalles de compra
        $compra = Compra::with(['proveedor', 'detalles.producto'])->findOrFail($id);

        // Retorna la vista 'compras.show' y le pasa los datos de la compra
        return view('primary.compras.compra_show4', compact('compra'));
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
