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
            ],

            'categoria' => [
                'required',
                'string',
                'max:255',
            ],

            'monto' => [
                'required',
                'numeric',
                'max:9999',
            ],
            'descripcion' => [  
                'nullable',
                'string',
            ],
            
        ], [

            'fecha.date' => 'La fecha no es correcta.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.before_or_equal' => 'La fecha no es correcta.',
            'categoria.required' => 'La categoría es obligatoria.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.max' => 'El monto no es correcto.',
            'categoria.max' => 'La categoría no puede exceder 255 caracteres.',
            'monto.numeric' => 'El monto debe ser un número.',
            'descripcion.string' => 'La descripción debe ser un texto.',
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

   
}
