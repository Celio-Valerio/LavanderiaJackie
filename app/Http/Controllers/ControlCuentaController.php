<?php

namespace App\Http\Controllers;

use App\Models\ControlCuenta;
use App\Models\CuentaBanco;
use Illuminate\Http\Request;

class ControlCuentaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todas las transacciones ordenadas por fecha (de la más reciente a la más antigua)
        $transacciones = ControlCuenta::with('cuentaBanco')
            ->orderBy('fecha', 'desc') // Ordenar las transacciones por fecha, de mayor a menor
            ->get();

        // Pasar las transacciones a la vista
        return view('primary.control_cuentas.control_cuentas_index', [
            'transacciones' => $transacciones,
        ]);
    }

    public function create()
    {
        $cuentasBancos = CuentaBanco::all();
        return view('primary.control_cuentas.control_cuentas_create', compact('cuentasBancos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cuenta_banco_id' => 'required|exists:cuenta_bancos,id',
            'fecha' => 'required|date',
            'transaccion' => 'required|in:Retiro,Deposito',
            'monto' => 'required|numeric|min:0.01',
        ]);

        $cuenta = CuentaBanco::find($request->cuenta_banco_id);

        if (!$cuenta->actualizarSaldo($request->monto, $request->transaccion)) {
            return redirect()->back()->with('error', 'Saldo insuficiente para realizar el retiro, tu saldo actual es de ' . number_format($cuenta->saldo, 2) . '.');
        }

        ControlCuenta::create([
            'cuenta_banco_id' => $request->cuenta_banco_id,
            'fecha' => $request->fecha,
            'transaccion' => $request->transaccion,
            'monto' => $request->monto,
            'notas' => $request->notas,
        ]);

        return redirect()->route('control_cuentas.index')->with('success', 'Transacción registrada correctamente');
    }

    public function show($id)
    {
        $transaccion = ControlCuenta::with('cuentaBanco')->findOrFail($id);

        return view('primary.control_cuentas.control_cuentas_show', compact('transaccion'));
    }


}
