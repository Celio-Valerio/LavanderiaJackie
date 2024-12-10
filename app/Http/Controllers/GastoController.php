<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Detalles_gasto;
use App\Models\Gasto;
use App\Models\Producto;
use Illuminate\Http\Request;

class GastoController extends Controller
{

    public function index()
    {
        $gastos = Gasto::all();
        $ultimoGasto = $gastos->last();
        return view('primary.gastos.gasto_index', compact('gastos', 'ultimoGasto'));
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

        return view('primary.gastos.gasto_create', compact('productos', 'compras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'luz' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto de energía eléctrica debe ser de al menos L.100.00.");
                }
            }
            ],
            'descripcion' => ['required', 'regex:/^[\pLáéíóúüñ]+(?:\s[\pLáéíóúüñ]+)*$/u'],
            'agua' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto de agua debe ser de al menos L.100.00.");
                }
            }
            ],
            'renta' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto por la renta debe ser de al menos L.100.00.");
                }
            }
            ],
            'nomina' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto por la nómina debe ser de al menos L.100.00.");
                }
            }
            ],
            'internet' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto por el internet debe ser de al menos L.100.00.");
                }
            }
            ],
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.regex' => 'La descripción contiene caracteres no válidos.',
            'luz.required' => 'El gasto de energía eléctrica es obligatorio.',
            'agua.required' => 'El gasto de agua es obligatorio.',
            'renta.required' => 'El gasto por la renta es obligatorio.',
            'nomina.required' => 'El gasto por la nomina es obligatorio.',
            'internet.required' => 'El gasto por el internet es obligatorio.',

        ]);

        $gasto = new Gasto();
        $gasto->fecha = date('Y-m-d');
        $gasto->descripcion = $request->input('descripcion');
        $gasto->energia = $request->input('luz');
        $gasto->agua  = $request->input('agua');
        $gasto->renta = $request->input('renta');
        $gasto->nomina = $request->input('nomina');
        $gasto->internet  = $request->input('internet');
        $gasto->totalG = $request->input('total');
        $suma = $request->input('suma');

        $detallesRecibidos = $request->input('detalles');
        $detalles = json_decode($detallesRecibidos, true); // decodificamos el arreglo enviado desde la vista de planillas
        if ($gasto->save()){
            if ($suma > 0){
                foreach ($detalles as $detalle) {
                    $detalleGasto = new Detalles_gasto();
                    $detalleGasto->fecha = $detalle['fecha'];
                    $detalleGasto->producto = $detalle['producto'];
                    $detalleGasto->numFactura = $detalle['numero'];
                    $detalleGasto->cantidad = $detalle['cantidad'];
                    $detalleGasto->precio = $detalle['precio'];
                    $detalleGasto->descuento = $detalle['descuento'];
                    $detalleGasto->gasto_id = $gasto->id;
                    $detalleGasto->save();
                }
            }
            return redirect()->route('gastos.index')->with('success', 'Gastos registrados exitosamente.');
        } else {
            return redirect()->route('gastos.index')->with('success', 'Error. La compra no pudo ser guardada');
        }

        //return redirect()->route( 'gastos.index')->with('success', 'Gasto registrado exitosamente.');
    }

    public function show(string $id)
    {
        $gasto = Gasto::findOrFail($id);
        $gastosFijos = Gasto::all();
        $detallesCompras = Detalles_gasto::where('gasto_id', $id)->get();
        return view('primary.gastos.gasto_show', compact('gasto', 'gastosFijos', 'detallesCompras'));

    }

    public function edit(string $id)
    {
        $gasto = Gasto::findOrFail($id);
        $productos = Producto::all();
        $compras = Compra::all();
        return view('primary.gastos.gasto_create', compact('gasto', 'productos', 'compras'));
    }

    public function update(Request $request, string $id)
    {

        $gasto = Gasto::findOrFail($id);
        $request->validate([
            'luz' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto de energía eléctrica debe ser de al menos L.100.00.");
                }
            }
            ],
            'descripcion' => ['required', 'regex:/^[\pLáéíóúüñ]+(?:\s[\pLáéíóúüñ]+)*$/u'],
            'agua' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto de agua debe ser de al menos L.100.00.");
                }
            }
            ],
            'renta' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto por la renta debe ser de al menos L.100.00.");
                }
            }
            ],
            'nomina' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto por la nómina debe ser de al menos L.100.00.");
                }
            }
            ],
            'internet' => ['required', function ($attribute, $value, $fail) use ($request){
                $validar = str_replace(',', '', $value);
                if ($validar < 100) {
                    $fail("El gasto por el internet debe ser de al menos L.100.00.");
                }
            }
            ],
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.regex' => 'La descripción contiene caracteres no válidos.',
            'luz.required' => 'El gasto de energía eléctrica es obligatorio.',
            'agua.required' => 'El gasto de agua es obligatorio.',
            'renta.required' => 'El gasto por la renta es obligatorio.',
            'nomina.required' => 'El gasto por la nomina es obligatorio.',
            'internet.required' => 'El gasto por el internet es obligatorio.',

        ]);
        $gasto->fecha = date('Y-m-d');
        $gasto->descripcion = $request->input('descripcion');
        $gasto->energia = $request->input('luz');
        $gasto->agua  = $request->input('agua');
        $gasto->renta = $request->input('renta');
        $gasto->nomina = $request->input('nomina');
        $gasto->internet  = $request->input('internet');
        $gasto->totalG = $request->input('total');
        $suma = $request->input('suma');
        $gasto->detalles()->delete();

        $detallesRecibidos = $request->input('detalles');
        $detalles = json_decode($detallesRecibidos, true); // decodificamos el arreglo enviado desde la vista de planillas
        if ($gasto->save()){
            if ($suma > 0){
                foreach ($detalles as $detalle) {
                    $detalleGasto = new Detalles_gasto();
                    $detalleGasto->fecha = $detalle['fecha'];
                    $detalleGasto->producto = $detalle['producto'];
                    $detalleGasto->numFactura = $detalle['numero'];
                    $detalleGasto->cantidad = $detalle['cantidad'];
                    $detalleGasto->precio = $detalle['precio'];
                    $detalleGasto->descuento = $detalle['descuento'];
                    $detalleGasto->gasto_id = $gasto->id;
                    $detalleGasto->save();
                }
            }
            return redirect()->route('gastos.index')->with('success', 'Gastos actualizados exitosamente.');
        } else {
            return redirect()->route('gastos.index')->with('success', 'Error. La compra no pudo ser guardada');
        }

        //return redirect()->route('gastos.index')->with('success', 'Gasto actualizado exitosamente.');

    }
}
