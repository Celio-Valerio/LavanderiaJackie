<?php

namespace App\Http\Controllers;

use App\Models\ControlCuenta;
use App\Models\CuentaBanco;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function exportPDF(Request $request)
    {
        $query = ControlCuenta::with('cuentaBanco');

        // Filtros de fecha
        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');
        if ($fechaDesde && $fechaHasta) {
            $query->whereBetween('fecha', [$fechaDesde, $fechaHasta]);
        }

        // Filtro por tipo de transacción
        $tipoTransaccion = $request->query('tipo_transaccion');
        if ($tipoTransaccion) {
            $query->where('transaccion', $tipoTransaccion);
        }

        // Búsqueda general
        $searchTerm = null;
        $search = $request->query('search');
        if (!empty($search)) {
            $searchTerm = $search;
            $query->where(function($q) use ($search) {
                $q->where('fecha', 'LIKE', "%{$search}%")
                    ->orWhere('monto', 'LIKE', "%{$search}%")
                    ->orWhere('notas', 'LIKE', "%{$search}%")
                    ->orWhereHas('cuentaBanco', function($q) use ($search) {
                        $q->where('banco', 'LIKE', "%{$search}%")
                            ->orWhere('cuenta', 'LIKE', "%{$search}%");
                    });
            });
        }

        $transacciones = $query->orderBy('fecha', 'desc')->get();

        // Cálculo de totales
        $totalRetiros = 0;
        $totalDepositos = 0;
        $totalSaldoInicial = 0;

        foreach ($transacciones as $trans) {
            switch ($trans->transaccion) {
                case 'Retiro':
                    $totalRetiros += $trans->monto;
                    break;
                case 'Deposito':
                    $totalDepositos += $trans->monto;
                    break;
                case 'Saldo inicial':
                    $totalSaldoInicial += $trans->monto;
                    break;
            }
        }

        $neto = ($totalDepositos + $totalSaldoInicial) - $totalRetiros;

        $pdf = PDF::loadView('primary.control_cuentas.control_cuentas_reporte', compact(
            'transacciones',
            'totalRetiros',
            'totalDepositos',
            'totalSaldoInicial',
            'neto',
            'fechaDesde',
            'fechaHasta',
            'tipoTransaccion',
            'searchTerm'
        ))
            ->setPaper('A4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download('control-cuentas-'.now()->format('YmdHis').'.pdf');
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
            return redirect()->back()
                ->withInput() // <-- Asegura que los valores del formulario sean preservados
                ->with('error', 'Saldo insuficiente para realizar el retiro, tu saldo actual es de ' . number_format($cuenta->saldo, 2) . '.');
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
