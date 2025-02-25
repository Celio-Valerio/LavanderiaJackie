<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presupuestos = Presupuesto::all();
        return view('primary.presupuestos.presupuestoindex', compact('presupuestos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('primary.presupuestos.presupuestocreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'monto' => ['required',
                function ($attribute, $value, $fail) {
                    if ($value < 1000) {
                        $fail("El monto debe ser mayor o igual a L. 1,000.00.");
                    }
                },],
        ], [
            'monto.required' => 'El monto es obligatorio.',
            'monto.regex' => 'El monto solo puede contener números enteros y decimales.',
            'descripcion.required' => 'La descripción es obligatoria.',

        ]);

        $nuevoPresupuesto = new Presupuesto();
        $nuevoPresupuesto->fecha = date('Y-m-d');
        $nuevoPresupuesto->cantidad = $request->input('monto');
        $nuevoPresupuesto->gastado = 0;
        $nuevoPresupuesto->descripcion = $request->input('descripcion');

        if ($nuevoPresupuesto->save()){
            return redirect()->route('presupuestos.index')->with('success', 'Presupuesto registrado exitosamente.');
        } else {
            return redirect()->route('presupuestos.index')->with('success', 'Error. El presupuesto no pudo ser guardado.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $presupuesto = Presupuesto::findOrFail($id);

        // Retorna la vista 'compras.show' y le pasa los datos de la compra
        return view('primary.presupuestos.presupuestoshow', compact('presupuesto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        return view('primary.presupuestos.presupuesto_edit', compact('presupuesto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:200',
            'monto' => ['required',
                function ($attribute, $value, $fail) {
                    if ($value < 1000) {
                        $fail("El monto debe ser mayor o igual a L. 1,000.00.");
                    }
                },],
            'fecha' => 'required|date', // Asegurar que la fecha es obligatoria y válida
        ], [
            'monto.required' => 'El monto es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'fecha.required' => 'La fecha es obligatoria.', // Mensaje de validación para la fecha
        ]);

        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->cantidad = $request->input('monto');
        $presupuesto->descripcion = $request->input('descripcion');
        $presupuesto->fecha = $request->input('fecha'); // Asegurar que la fecha se actualiza

        if ($presupuesto->save()) {
            return redirect()->route('presupuestos.index')->with('success', 'Presupuesto actualizado exitosamente.');
        } else {
            return redirect()->route('presupuestos.index')->with('error', 'Error. El presupuesto no pudo ser actualizado.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
