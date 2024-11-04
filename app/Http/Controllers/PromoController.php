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
    public function index()
    {
        $promociones = Promo::all(); // O cualquier lógica de paginación o filtrado que necesites
        return view('primary.promociones.promo_index', compact('promociones'));
    }

    public function view(Request $request)
    {
        // Obtener las promociones paginadas
        $perPage = 3; // Número de promociones por página
        $promociones = Promo::paginate($perPage);
        return view('primary.promociones.promo_vista', compact('promociones'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('primary.promociones.promo_create'); // Vista para crear una nueva promoción
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
                'between:5,45',
            ],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],
            'days' => [
                'required',
                'array',
            ],
        ], [
            'name.required' => 'El nombre de la promoción es obligatorio.',
            'name.string' => 'El nombre de la promoción debe ser una cadena de texto válida.',
            'name.max' => 'El nombre de la promoción no puede exceder los 255 caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser mayor a L. 10,000.00.',
            'price.max' => 'El precio debe ser menor a L. 1.00.',

            'discount.required' => 'El descuento es obligatorio.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.between' => 'El descuento debe estar entre 5 y 45.',

            'image.required' => 'Debes cargar una imagen.',
            'image.image' => 'Debes seleccionar una imagen en un formato válido.',
            'image.mimes' => 'La imagen debe estar en formato jpeg, png, jpg o gif.',
            'image.max' => 'La imagen no puede exceder los 2048 KB.',

            'days.required' => 'Debes seleccionar al menos 1 día de la semana.',
            'days.array' => 'Los días deben ser un arreglo válido.',
        ]);

        // Guardar promoción en la base de datos
        $promo = new Promo();
        $promo->name = $request->name;
        $promo->price = $request->price;
        $promo->discount = $request->discount;

        // Guardar imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();

            // Generar el nombre en el formato deseado
            $timestamp = now()->format('d-m-Y_H-i-s');
            $randomNumber = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $imageName = "promos_{$timestamp}_{$randomNumber}.{$extension}";

            // Guardar la imagen directamente en la carpeta public/assets/img/promociones
            $image->move(public_path('assets/img/promociones'), $imageName);

            // Almacenar el nombre en la base de datos
            $promo->image = $imageName;
        }


        $promo->days = json_encode($request->days);
        $promo->save();

        return redirect()->route('promociones.index')->with('success', 'La promoción ' . $promo->name . ' ha sido registrada exitosamente.');
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
        return view('primary.promociones.promo_edit', compact('promo')); // Pasa la promoción a la vista
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

        return redirect()->route('primary.promociones.promo_index')->with('success', 'La promoción ' . $promo->name . ' ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
