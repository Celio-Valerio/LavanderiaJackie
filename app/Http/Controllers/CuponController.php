<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cupon;
use App\Models\Visita;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los servicios efectuados
        $cupones = Cupon::all();
        return view('primary.cupones.cupon_index', compact('cupones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener solo los clientes con 1 o más visitas disponibles
        $clientes = Visita::where('visitas_disponibles', '>=', 1)
            ->join('clientes', 'visitas.cliente_id', '=', 'clientes.id')
            ->select('clientes.id', 'clientes.first_name', 'clientes.last_name', 'visitas.visitas_disponibles')
            ->get();

        return view('primary.cupones.cupon_create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:500',
            ],
            'tipo' => [
                'required',
                'in:Valor,Descuento,Cantidad',
            ],
            'valor' => [
                'required_if:tipo,Valor,Descuento',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'cantidad' => [
                'required_if:tipo,Cantidad',
                'integer',
                'min:1',
            ],
            'cliente_id' => [
                'required',
                'exists:visitas,cliente_id',
            ],
        ], [
            'nombre.required' => 'El nombre del cupón es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',

            'tipo.required' => 'El tipo de cupón es obligatorio.',
            'tipo.in' => 'El tipo de cupón debe ser Valor, Descuento o Cantidad.',

            'valor.required_if' => 'El valor es obligatorio si el tipo de cupón es Valor o Descuento.',
            'valor.numeric' => 'El valor del cupón debe ser un número válido.',
            'valor.min' => 'El valor del cupón no puede ser menor a 0.',
            'valor.max' => 'El valor del cupón no puede exceder 999,999.99.',

            'cantidad.required_if' => 'La cantidad es obligatoria si el tipo de cupón es Cantidad.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',

            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no tiene visitas registradas.',
        ]);

        // Obtener la visita del cliente seleccionado
        $visita = Visita::where('cliente_id', $request->cliente_id)->first();

        if ($visita && $request->has('cantidad')) {
            // Validar que la cantidad no sea mayor que las visitas disponibles
            if ($request->cantidad > $visita->visitas_disponibles) {
                return redirect()->back()->withInput()->withErrors([
                    'cantidad' => 'La cantidad no puede ser mayor que las visitas disponibles.'
                ]);
            }

            // Restar la cantidad de visitas disponibles y dejarlas en 0 si es necesario
            $visita->visitas_disponibles = max(0, $visita->visitas_disponibles - $request->cantidad);
            $visita->save();
        }

        // Crear el cupón con el estado "Activo" por defecto
        $cupon = Cupon::create(array_merge($validated, ['estado' => 'Activo']));

        // Mensaje de éxito
        $successMessage = 'El cupón "' . $cupon->nombre . '" ha sido registrado exitosamente.';

        return redirect()->route('cupones.index')->with('success', $successMessage);
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
