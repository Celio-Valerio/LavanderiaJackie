<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los compras de la base de datos
        $compras = Compra::all();
        $presupuestos = Presupuesto::all();
        $usuario = Auth::user();

        session()->flash('clearLocalStorage', true);

        // Retornar una vista con los compras
        return view('primary.compras.compra_index', compact('compras', 'presupuestos', 'usuario'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los proveedores para el select
        $proveedores = Proveedor::all();

        // Obtener todos los productos para el select
        $productos = Producto::all();
        $presupuestos = Presupuesto::all();
        $id = $presupuestos->last()->id;
        $presupuesto = Presupuesto::findOrFail($id);
        $usuario = Auth::user();

        // Retornar la vista del formulario de creación con los datos necesarios
        return view('primary.compras.compra_create', compact('proveedores', 'productos', 'presupuesto', 'usuario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'proveedor_id' => 'required|exists:proveedors,id',
            'numero_factura' => 'required|string|size:16',
            'fecha_compra' => 'required|date|before_or_equal:today',
            'descripcion' => 'required|string',
        ], [
            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',
            'producto_id.required' => 'El producto es obligatorio.',
            'producto_id.exists' => 'El producto seleccionado no es válido.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser menor que 0.',
            'precio.max' => 'El precio no puede ser mayor que 10000.',
            'numero_factura.required' => 'El número de factura es obligatorio.',
            'numero_factura.size' => 'El número de factura es inválido.',
            'fecha_compra.required' => 'La fecha de compra es obligatoria.',
            'fecha_compra.before_or_equal' => 'La fecha de compra no es válida.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'detalles.required' => 'Los detalles son obligatorios.',
            'detalles.array' => 'Los detalles deben ser un arreglo.',
        ]);

        $presupuestos = Presupuesto::all();
        $dato = $presupuestos->last()->id;
        $presupuesto = Presupuesto::findOrFail($dato);
        $gasto = $presupuesto->gastado;


        // Crear una nueva compra
        $compra = new Compra();
        $compra->numero_factura = $request->input('numero_factura');
        $compra->descripcion = $request->input('descripcion');
        $compra->fecha_compra = $request->input('fecha_compra');
        $compra->presupuesto_id = $presupuesto->id;

        $detallesRecibidos = $request->input('detallesMandar');
        $detalles = json_decode($detallesRecibidos, true);

        if ($compra->save()){
            foreach ($detalles as $detalle) {
                $descuento = 0;
                $compra_detalle = new DetalleCompra();
                $compra_detalle->compra_id = $compra->id;
                $compra_detalle->producto_id = $detalle['producto_id'];
                $compra_detalle->cantidad = $detalle['cantidad'];
                $compra_detalle->precio = $detalle['precio'];
                $compra_detalle->descuento = $detalle['descuento'];
                $descuento = $compra_detalle->cantidad * $compra_detalle->precio * ($compra_detalle->descuento / 100);
                $gasto = $gasto + ($compra_detalle->cantidad * $compra_detalle->precio -$descuento);
                $compra_detalle->save();

                $producto = Producto::find($detalle['producto_id']);

                if ($producto) {
                    $producto->stock += $detalle['cantidad'];
                    $producto->save();
                }
            }
            $presupuesto->gastado = $gasto;
            $presupuesto->save();
            return redirect()->route('compras.index')->with('success', 'Compra guardada exitosamente.')->with('clearLocalStorage', true);
        } else {
            return redirect()->route('compras.index')->with('success', 'Error. La compra no pudo ser guardada');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $compra = Compra::findOrFail($id);
        $usuario = Auth::user();
        // Retorna la vista 'compras.show' y le pasa los datos de la compra
        return view('primary.compras.compra_show', compact('compra', 'usuario'));
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
}
