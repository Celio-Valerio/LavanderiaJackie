<?php
namespace App\Http\Controllers;

use App\Models\DetalleGastoDiario;
use App\Models\GastoDiario;
use App\Models\Producto;
use Illuminate\Http\Request;

class GastoDiarioController extends Controller
{
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

        return redirect()->route('gastos_diarios.create')->with('success', 'Gasto diario actualizado y finalizado.');
    }
}
