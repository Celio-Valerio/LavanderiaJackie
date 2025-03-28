<?php

namespace App\Http\Controllers;

use App\Models\DetalleGastoDiario;
use App\Models\GastoDiario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GastoDiarioController extends Controller
{
    /**
     * Muestra la lista de gastos diarios.
     */
    public function index()
    {
        // Verificar si hay gastos diarios pendientes para hoy
        $pendientesHoy = GastoDiario::whereDate('fecha', now()->toDateString())
            ->where('estado', 'Pendiente')
            ->exists();

        // Si hay pendientes, redirigir directamente al formulario de creación
        if ($pendientesHoy) {
            return redirect()->route('gastos_diarios.create');
        }

        // Si no hay pendientes, mostrar la lista de gastos diarios
        $gastosDiarios = GastoDiario::with('servicioEfectuado.cliente')->get();

        return view('primary.gastos_diarios.gastos_diarios_index', compact('gastosDiarios'));
    }


    /**
     * Muestra el formulario para crear un nuevo gasto diario.
     */
    public function create()
    {
        // Obtener TODOS los gastos diarios pendientes de hoy
        $gastosDiarios = GastoDiario::whereDate('fecha', now()->toDateString())
            ->where('estado', 'Pendiente')
            ->with('servicioEfectuado.cliente')
            ->get();

        // Si no hay gastos pendientes hoy, redirigir al índice
        if ($gastosDiarios->isEmpty()) {
            return redirect()->route('gastos_diarios.index')->with('info', 'No hay gastos diarios pendientes para hoy.');
        }

        // Obtener el primer gasto diario (si existe)
        $gastoDiario = $gastosDiarios->first();

        $productos = Producto::all();

        return view('primary.gastos_diarios.gastos_diarios_create', compact('gastosDiarios', 'productos', 'gastoDiario'));
    }

    /**
     * Actualiza un gasto diario existente.
     */
    public function update(Request $request, $id)
    {
        $gastoDiario = GastoDiario::findOrFail($id);

        // Verificar si el estado del gasto diario ya es 'Terminado'
        if ($gastoDiario->estado === 'Terminado') {
            return redirect()->back()->with('error', 'Este gasto ya fue finalizado.');
        }

        // Validación de los productos enviados
        $validated = $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|between:0.1,999',
            'productos.*.unidad' => 'required|in:Kilogramos,Kilos,Gramos,Gotas,Unidades',
        ]);

        // Procesar los productos y actualizar o crear los registros en DetalleGastoDiario
        foreach ($validated['productos'] as $producto) {
            DetalleGastoDiario::updateOrCreate(
                [
                    'gasto_diario_id' => $gastoDiario->id,
                    'producto_id' => $producto['id']
                ],
                [
                    'cantidad' => $producto['cantidad'],
                    'unidad_medida' => $producto['unidad']
                ]
            );
        }

        // Cambiar el estado del gasto diario actual a 'Terminado'
        $gastoDiario->update(['estado' => 'Terminado']);

        // Verificar si aún hay más gastos pendientes para hoy
        $pendientesHoy = GastoDiario::whereDate('fecha', now()->toDateString())
            ->where('estado', 'Pendiente')
            ->exists();

        // Si hay más pendientes, recargar el formulario
        if ($pendientesHoy) {
            return redirect()->route('gastos_diarios.create')->with('success', 'Productos actualizados y gasto diario finalizado.');
        }

        // Si no hay más pendientes, redirigir al índice
        return redirect()->route('gastos_diarios.index')->with('success', 'Todos los gastos diarios han sido finalizados.');
    }


    public function print(GastoDiario $gastoDiario)
    {
        return view('primary.gastos_diarios.gastos_diarios_print', [
            'gastoDiario' => $gastoDiario->load(['detalleGastoDiarios.producto', 'servicioEfectuado.cliente', 'servicioEfectuado.servicio'])
        ]);
    }

    public function generatePDF(GastoDiario $gastoDiario)
    {
        $data = [
            'gastoDiario' => $gastoDiario->load(['detalleGastoDiarios.producto', 'servicioEfectuado.cliente', 'servicioEfectuado.servicio'])
        ];

        $pdf = PDF::loadView('primary.gastos_diarios.gastos_diarios_print', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->stream('gasto-diario-'.$gastoDiario->id.'.pdf');
    }
}
