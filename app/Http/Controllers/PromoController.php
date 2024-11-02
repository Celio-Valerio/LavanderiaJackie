<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // PromocionesController.php
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 3); // Valor por defecto es 15
        $promociones = Promo::paginate($perPage);

        return view('primary.promociones.promo_index', compact('promociones'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('primary.promos.promo_create'); // Vista para crear una nueva promoción
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255', // Suponiendo un límite de 255 caracteres
            ],
            'price' => [
                'required',
                'numeric',
                'min:0', // El precio no puede ser negativo
            ],
            'discount' => [
                'required',
                'numeric',
                'between:0,100', // Descuento entre 0 y 100
            ],
            'image' => [
                'nullable',
                'string',
                'max:255', // Suponiendo un límite de 255 caracteres para la URL de la imagen
            ],
            'days' => [
                'nullable',
                'json', // Se espera un JSON válido
            ],
        ], [
            // Mensajes de error personalizados
            'name.required' => 'El nombre de la promoción es obligatorio.',
            'name.string' => 'El nombre de la promoción debe ser una cadena de texto válida.',
            'name.max' => 'El nombre de la promoción no puede exceder los 255 caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser negativo.',

            'discount.required' => 'El descuento es obligatorio.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.between' => 'El descuento debe estar entre 0 y 100.',

            'image.string' => 'Debes ingresar una imagen correcta.',
            'image.max' => 'La URL de la imagen no puede exceder los 255 caracteres.',

            'days.json' => 'Los días deben ser un formato JSON válido.',
        ]);

        // Guardar promoción en la base de datos
        $promo = new Promo();
        $promo->name = $request->name;
        $promo->price = $request->price;
        $promo->discount = $request->discount;
        $promo->image = $request->image;
        $promo->days = $request->days; // Se asume que se puede guardar en formato JSON
        $promo->save();

        return redirect()->route('promos.index')->with('success', 'La promoción ' . $promo->name . ' ha sido registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id); // Encuentra la promoción por ID o lanza un error 404 si no existe
        return view('primary.promos.promo_edit', compact('promo')); // Pasa la promoción a la vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id); // Encuentra la promoción por ID o lanza un error 404 si no existe

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'discount' => [
                'required',
                'numeric',
                'between:0,100',
            ],
            'image' => [
                'nullable',
                'string',
                'max:255',
            ],
            'days' => [
                'nullable',
                'json',
            ],
        ], [
            'name.required' => 'El nombre de la promoción es obligatorio.',
            'name.string' => 'El nombre de la promoción debe ser una cadena de texto válida.',
            'name.max' => 'El nombre de la promoción no puede exceder los 255 caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser negativo.',

            'discount.required' => 'El descuento es obligatorio.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.between' => 'El descuento debe estar entre 0 y 100.',

            'image.string' => 'La imagen debe ser una cadena de texto válida.',
            'image.max' => 'La URL de la imagen no puede exceder los 255 caracteres.',

            'days.json' => 'Los días deben ser un formato JSON válido.',
        ]);

        // Actualizar la promoción en la base de datos
        $promo->name = $request->name;
        $promo->price = $request->price;
        $promo->discount = $request->discount;
        $promo->image = $request->image;
        $promo->days = $request->days;
        $promo->save();

        return redirect()->route('promos.index')->with('success', 'La promoción ' . $promo->name . ' ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
