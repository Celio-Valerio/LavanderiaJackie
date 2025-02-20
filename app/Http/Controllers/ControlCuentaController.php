<?php

namespace App\Http\Controllers;

use App\Models\ControlCuenta;
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

    public function show()
    {
        // Función show si es necesario
    }
}
