<?php
namespace App\Http\Controllers;

use App\Models\ControlCuenta;
use App\Models\CuentaBanco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentaBancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los nombres únicos de los bancos
        $bancos = CuentaBanco::select('banco')->distinct()->get();

        // Obtener todas las cuentas bancarias
        $cuentaBanco = CuentaBanco::all();

        // Pasar los bancos y las cuentas a la vista
        return view('primary.cuentas_bancos.cuentas_bancos_index', compact('bancos', 'cuentaBanco'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'banco' => 'required|string|max:100',
            'cuenta' => 'required|string|max:50|unique:cuenta_bancos,cuenta',
            'saldo' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction(); // Inicia una transacción

        try {
            // Crear la cuenta de banco
            $cuenta = CuentaBanco::create($request->all());

            // Crear la transacción de depósito
            ControlCuenta::create([
                'cuenta_banco_id' => $cuenta->id,
                'fecha' => now(),
                'transaccion' => 'Saldo inicial',
                'monto' => $cuenta->saldo,
                'notas' => 'Depósito inicial al crear la cuenta'
            ]);

            DB::commit(); // Confirma la transacción
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte si hay error

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cuenta y registrar la transacción: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'cuenta' => $cuenta
        ]);
    }


    public function show($id)
    {

        $cuenta = CuentaBanco::findOrFail($id);

        // Retorna la vista 'compras.show' y le pasa los datos de la compra
        return view('primary.cuentas_bancos.cuenta_bancos_show', compact('cuenta'));
    }


}
