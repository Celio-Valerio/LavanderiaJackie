<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\Compra;

class DashboardController extends Controller
{
    public function index()
    {
        // Métricas clave
        $totalClientes = Cliente::count();
        $empleadosActivos = Empleado::where('estado', 'Activo')->count();
        $productosBajoStock = Producto::where('stock', '<', 10)->count(); // Alerta de stock bajo
        $totalProductos = Producto::count(); // <- Nueva variable

        $ultimasCompras = Compra::with(['detalle_compras', 'proveedor'])
            ->latest()
            ->take(5)
            ->get();

        // Gráfico: Productos más comprados (ejemplo)
        $topProductos = Producto::orderBy('stock', 'desc')->take(5)->get();

        return view('pagina_principal', compact(
            'totalClientes',
            'empleadosActivos',
            'productosBajoStock',
            'ultimasCompras',
            'topProductos',
            'totalProductos'
        ));
    }
}
