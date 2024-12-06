<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Producto;
use Illuminate\Http\Request;

class GastoController extends Controller
{

    public function index()
    {
        $gastos = Gasto::all();
        return view('primary.gastos.gasto_index', compact('gastos'));
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

        return view('primary.gastos.gasto_create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:' . now()->subYears(10)->toDateString(),
            ],

            
            'monto' => [
                'required',
                'numeric',
                'max:9999999',
                'min:0.01',
            ],
            'descripcion' => [  
                'required',
                'string',
            ],

        
            
        ], [

            'fecha.date' => 'La fecha no es correcta.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.before_or_equal' => 'La fecha no es valida.',
            'fecha.after_or_equal' => 'La fecha no es valida.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.max' => 'El monto no es correcto.',
            'monto.min' => 'El monto no es correcto.',
            'descripcion.string' => 'La descripción debe ser un texto.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);

        // Guardar gasto en la base de datos
        $gasto = new Gasto();
        $gasto->fecha = $request->fecha;
        $gasto->categoria = $request->categoria;
        $gasto->monto = $request->monto;
        $gasto->descripcion = $request->descripcion;
        $gasto->save();

        return redirect()->route( 'gastos.index')->with('success', 'Gasto registrado exitosamente.');
    }

    public function show(string $id)
    {
        $gasto = Gasto::findOrFail($id);
        return view('primary.gastos.gasto_show', compact('gasto'));
    }

    public function edit(string $id)
    {
        $gasto = Gasto::findOrFail($id);
        $productos = Producto::all();
        return view('primary.gastos.gasto_update', compact('gasto', 'productos'));
    }
    
    public function update(Request $request, string $id)
    {
        $request->validate([    
            'fecha' => [
                'required',
            'date',
            'before_or_equal:today',
            'after_or_equal:' . now()->subYears(10)->toDateString(),
        ],

        
        'monto' => [
            'required',
            'numeric',
            'max:9999999999',
            'min:0.01',
        ],
        'descripcion' => [  
            'required',
            'string',
        ],
        
    ], [

        'fecha.date' => 'La fecha no es correcta.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.before_or_equal' => 'La fecha no es valida.',
        'fecha.after_or_equal' => 'La fecha no es valida.',
        'monto.required' => 'El monto es obligatorio.',
        'monto.max' => 'El monto no es correcto.',
        'monto.min' => 'El monto no es correcto.',
        'descripcion.string' => 'La descripción debe ser un texto.',
        'descripcion.required' => 'La descripción es obligatoria.',
    ]);

    // Guardar gasto en la base de datos
    $gasto = Gasto::findOrFail($id);
    $gasto->fecha = $request->fecha;
    $gasto->categoria = $request->categoria;
    $gasto->monto = $request->monto;
    $gasto->descripcion = $request->descripcion;
    $gasto->save();

    return redirect()->route('gastos.index')->with('success', 'Gasto actualizado exitosamente.');

    }
}
    