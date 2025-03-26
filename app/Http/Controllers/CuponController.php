<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cupon;
use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Obtener todas las visitas con la información del cliente
        $visitas = Visita::join('clientes', 'visitas.cliente_id', '=', 'clientes.id')
            ->select(
                'clientes.id',
                'clientes.first_name',
                'clientes.last_name',
                'visitas.id',
                'visitas.fecha_visita',
                'visitas.visitas_totales',
                'visitas.visitas_disponibles'
            )
            ->orderBy('visitas.fecha_visita', 'desc') // Ordenar por la fecha de visita
            ->get();

        return view('primary.cupones.cupon_create', compact('visitas'));
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
                'required',
                'numeric',
                'min:0',
                // Máximo según el tipo
                function ($attribute, $value, $fail) use ($request) {
                    $tipo = $request->tipo;
                    if ($tipo === 'Descuento' && $value > 100) {
                        $fail('El descuento no puede ser mayor a 100%.');
                    } elseif ($tipo === 'Valor' && $value > 999999.99) {
                        $fail('El valor no puede exceder L 999,999.99.');
                    } elseif ($tipo === 'Cantidad' && $value > 99999) {
                        $fail('La cantidad no puede exceder 99,999.');
                    }
                },
            ],
            'clientes' => [
                'required',
                'array',
                'min:1',
            ],
            'clientes.*' => [
                'exists:clientes,id', // Corregir tabla a clientes
            ],
            'fecha_desde' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'fecha_hasta' => [
                'required',
                'date',
                'after:fecha_desde',
            ],
        ], [
            'nombre.required' => 'El nombre del cupón es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
            'tipo.required' => 'El tipo de cupón es obligatorio.',
            'tipo.in' => 'El tipo de cupón debe ser Valor, Descuento o Cantidad.',
            'valor.required_if' => 'Llene los datos con relación a tipo de cupón.',
            'valor.required' => 'Llene los datos con relación a tipo de cupón.',
            'valor.numeric' => 'El valor del cupón debe ser un número válido.',
            'valor.min' => 'El valor del cupón no puede ser menor a 0.',
            'valor.max' => 'El valor del cupón no puede exceder 999,999.99.',
            'fecha_desde.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a hoy.',
            'fecha_desde.required' => 'La fecha de inicio es obligatoria.',
            'fecha_hasta.required' => 'La fecha de fin es obligatoria.',
            'fecha_hasta.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'clientes.*.exists' => 'Uno o más clientes seleccionados no son válidos.',
            'clientes.required' => 'Debes seleccionar al menos un cliente.',
        ]);

        DB::beginTransaction();
        try {
            // Crear el cupón
            $cupon = Cupon::create($request->only(
                    'nombre', 'descripcion', 'tipo', 'valor', 'fecha_desde', 'fecha_hasta'
                ) + ['estado' => 'Activo']);

            // Asociar los clientes al cupón sin crear duplicados
            $cupon->clientes()->syncWithoutDetaching($request->clientes);

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('cupones.index')
                ->with('success', 'Cupón creado exitosamente!');

        } catch (\Exception $e) {
            // Rollback en caso de error
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error: '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cupon $cupon)
    {
        // Carga la relación con los clientes
        $cupon->load('clientes');

        return view('primary.cupones.cupon_show', compact('cupon'));
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

    public function toggleEstado(Cupon $cupon)
    {
        $cupon->estado = $cupon->estado == 'Activo' ? 'Utilizado' : 'Activo';
        $cupon->save();

        return redirect()->route('cupones.index', $cupon->id)
            ->with('success', 'Estado del cupón actualizado correctamente');
    }
}
