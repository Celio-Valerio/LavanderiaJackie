<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialCliente extends Controller
{
    public function historialCliente($id)
    {
        $cliente = Cliente::findOrFail($id);
        $clienteServicios = $cliente->servicios()
            ->selectRaw('DATE_FORMAT(fecha, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        $clienteDia = $cliente->servicios()
            ->selectRaw('DATE(fecha) as fecha, COUNT(*) as cantidad')
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        $meses = $cliente->servicios()
            ->selectRaw('DISTINCT MONTH(fecha) as mes') // Selecciona el número del mes
            ->orderBy('mes', 'asc') // Ordena los meses de manera ascendente
            ->pluck('mes');

        $anios = $cliente->servicios()
            ->selectRaw('DISTINCT YEAR(fecha) as anio')
            ->orderBy('anio', 'asc')
            ->pluck('anio');
        $usuario = Auth::user();
        return view('primary.clientes.cliente_historial', compact('cliente', 'clienteServicios', 'clienteDia', 'anios', 'meses', 'usuario'));
    }
}
