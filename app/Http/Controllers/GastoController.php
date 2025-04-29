<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleGastos;
use App\Models\Detalles_gasto;
use App\Models\Gasto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Webmozart\Assert\Tests\StaticAnalysis\length;
use Barryvdh\DomPDF\Facade\Pdf;

class GastoController extends Controller
{

    public function index()
    {
        $gastos = Gasto::with('detalles.producto')->get();
        foreach ($gastos as $gasto) {
            $totalProductos = 0;
            foreach ($gasto->detalles as $detalle) {
                $totalProductos += $detalle->cantidad * $detalle->producto->precio;
            }
            $gasto->totalP = $totalProductos;
        }
        $ultimoGasto = $gastos->last();
        $usuario = Auth::user();
        return view('primary.gastos.gasto_index', compact('gastos', 'ultimoGasto', 'usuario'));
    }

    public function exportPDF(Request $request)
    {
        \Log::debug('exportPDF params', $request->all());

        $query = Gasto::with('detalles.producto');

        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');

        if ($fechaDesde && $fechaHasta) {
            $query->whereBetween('fecha', [$fechaDesde, $fechaHasta]);
        }

        $searchTerm = null; // 👈 Inicializado

        $search = $request->query('search');
        if (!empty($search)) {
            $searchTerm = $search; // 👈 Guardamos el término para mostrarlo en la vista

            $query->where(function($query) use ($search) {
                $query->where('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('fecha', 'LIKE', "%{$search}%")
                    ->orWhere('totalG', 'LIKE', "%{$search}%");
            });
        }

        $gastos = $query->get()->map(function($gasto) {
            $gasto->totalP = $gasto->detalles
                ->sum(fn($d) => $d->cantidad * $d->producto->precio);
            return $gasto;
        });

        $totalGastosFijos     = $gastos->sum('totalG');
        $totalGastosProductos = $gastos->sum('totalP');

        $pdf = PDF::loadView(
            'primary.gastos.gastos_reporte',
            compact(
                'gastos',
                'totalGastosFijos',
                'totalGastosProductos',
                'fechaDesde',
                'fechaHasta',
                'searchTerm' // 👈 Asegúrate de incluirlo aquí
            )
        )
            ->setPaper('A4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
            ]);

        return $pdf->download('gastos-' . now()->format('YmdHis') . '.pdf');
    }

    public function print($id)
    {
        // Cargar el gasto con sus detalles
        $gasto = Gasto::with('detalles.producto')->findOrFail($id);

        // Asegúrate de pasar la variable correctamente a la vista
        return view('primary.gastos.gastos_print', [
            'gasto' => $gasto,
            'detallesGastos' => $gasto->detalles
        ]);
    }

    public function generatePDF($id)
    {
        // Cargar el gasto con sus detalles
        $gasto = Gasto::with('detalles.producto')->findOrFail($id);

        // Cargar la vista y generar el PDF
        $pdf = PDF::loadView('primary.gastos.gastos_print', [
            'gasto' => $gasto,
            'detallesGastos' => $gasto->detalles
        ])
            ->setPaper('A4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Descargar el PDF
        return $pdf->download('gasto_'.$gasto->id.'.pdf');
    }

    public function reload($id)
    {
        $gasto = Gasto::findOrFail($id);
        return response()->json($gasto);
    }

    public function create()
    {
        // Obtener los productos registrados
        $productos = Producto::all(); // Asegúrate de que 'Producto' sea el modelo correcto
        $compras = Compra::all();
        $gastos = Gasto::all();
        $usuario = Auth::user();

        return view('primary.gastos.gasto_create', compact('productos', 'compras', 'gastos', 'usuario'));
    }

    public function store(Request $request)
    {

        $gasto = new Gasto();
        $gasto->fecha = date('Y-m-d');
        $gasto->descripcion = $request->input('descripcion');
        $detallesRecibidos2 = $request->input('detallesMandar2');
        $detalles2 = json_decode($detallesRecibidos2, true);// decodificamos el arreglo enviado desde la vista de planillas
        $suma2 = count($detalles2);
        if($suma2 > 0){
            $gasto->agua = 0;
            $gasto->nomina = 0;
            $gasto->renta = 0;
            $gasto->internet = 0;
            $gasto->energia = 0;

            foreach ($detalles2 as $detalle) {
                if ($detalle['valor'] === 'agua') {
                    $gasto->agua = $detalle['monto'] ?? 0;
                }
                if ($detalle['valor'] === 'nomina') {
                    $gasto->nomina = $detalle['monto'] ?? 0;
                }
                if ($detalle['valor'] === 'renta') {
                    $gasto->renta = $detalle['monto'] ?? 0;
                }
                if ($detalle['valor'] === 'internet') {
                    $gasto->internet = $detalle['monto'] ?? 0;
                }
                if ($detalle['valor'] === 'luz') {
                    $gasto->energia = $detalle['monto'] ?? 0;
                }
            }
            $gasto->totalG = $request->input('totalFij');
        } else {
            $gasto->agua = 0;
            $gasto->nomina = 0;
            $gasto->renta = 0;
            $gasto->internet = 0;
            $gasto->energia = 0;
            $gasto->totalG = 0;
        }


        $detallesRecibidos = $request->input('detallesMandar');
        $detalles = json_decode($detallesRecibidos, true);// decodificamos el arreglo enviado desde la vista de planillas
        $suma = count($detalles);
        if ($gasto->save()){
            if ($suma > 0){
                foreach ($detalles as $detalle) {
                    $detalleGasto = new DetalleGastos();
                    $detalleGasto->producto_id = $detalle['producto_id'];
                    $detalleGasto->cantidad = $detalle['cantidad'];
                    $detalleGasto->gasto_id = $gasto->id;
                    $detalleGasto->save();
                    $producto = Producto::find($detalle['producto_id']);
                    $cantidad = $detalle['cantidad'];

                    if ($producto) {
                        $producto->stock -= $cantidad;
                    }
                    $producto->save();
                }
            }
            return redirect()->route('gastos.index')->with('success', 'Gastos registrados exitosamente.');
        } else {
            return redirect()->route('gastos.index')->with('success', 'Error. La compra no pudo ser guardada');
        }
    }

    public function show(string $id)
    {
        $gasto = Gasto::findOrFail($id);
        $gastosFijos = Gasto::all();
        $detallesGastos = DetalleGastos::where('gasto_id', $id)->get();
        $usuario = Auth::user();
        return view('primary.gastos.gasto_show', compact('gasto', 'gastosFijos', 'detallesGastos', 'usuario'));

    }

    public function edit(string $id)
    {
        $gasto = Gasto::findOrFail($id);
        $productos = Producto::all();
        $detalles = $gasto->detalles;
        $usuario = Auth::user();
        return view('primary.gastos.gasto_update', compact('gasto', 'productos', 'detalles', 'usuario'));
    }

    public function update(Request $request, string $id)
    {
        $gasto = Gasto::findOrFail($id);
        $gasto->energia = $request->input('luz') ?? 0;
        $gasto->agua = $request->input('agua') ?? 0;
        $gasto->renta = $request->input('renta') ?? 0;
        $gasto->nomina = $request->input('nomina') ?? 0;
        $gasto->internet = $request->input('internet') ?? 0;
        $gasto->totalG = $request->input('totalG') ?? 0;

        $detallesRecibidos = $request->input('detallesMandar');
        $detalles = json_decode($detallesRecibidos, true); // decodificamos el arreglo enviado desde la vista de planillas
        $detalleGastos = $gasto->detalles;
        $suma = count($detalles);
        if($suma > 0){
            foreach ($detalleGastos as $detalleGasto) {
                foreach ($detalles as $detallerec){
                    if($detalleGasto->producto_id == $detallerec['producto_id']){
                        $detalleGasto->cantidad = $detalleGasto->cantidad + $detallerec['cantidad'] ;
                        if($detalleGasto->save()){
                            $producto = Producto::find($detallerec['producto_id']);
                            $cantidad = $detallerec['cantidad'];

                            if ($producto) {
                                $producto->stock -= $cantidad;
                            }
                            $producto->save();
                        }
                    }
                }

            }
        }
        if($gasto->save()){
            return redirect()->route('gastos.index')->with('success', 'Gastos actualizados exitosamente.');
        }
        else{

            return redirect()->route('gastos.index')->with('success', 'Error, no se actualizaron gastos.');
        }
    }
}
