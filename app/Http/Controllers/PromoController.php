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
        // Obtener el término de búsqueda
        $search = $request->get('search');

        // Filtrar las promociones si hay un término de búsqueda
        $promociones = Promo::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(3); // Número de promociones por página

        return view('primary.promociones.promo_vista', compact('promociones', 'search'));
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
            'discount' => [
                'required',
                'numeric',
                'between:5,70',
            ],
            'promo' => [
                'required',
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
            'notes' => [
                'nullable',
                'string',
                'min:5',
                'max:500',
            ],
        ], [
            'name.required' => 'El nombre de la promoción es obligatorio.',
            'name.string' => 'El nombre de la promoción debe ser una cadena de texto válida.',
            'name.max' => 'El nombre de la promoción no puede exceder los 255 caracteres.',

            'promo.required' => 'Debes seleccionar una promoción o servicio.',

            'discount.required' => 'El descuento es obligatorio.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.between' => 'El descuento debe estar entre 5% y 70%.',

            'image.required' => 'Debes cargar una imagen.',
            'image.image' => 'Debes seleccionar una imagen en un formato válido.',
            'image.mimes' => 'La imagen debe estar en formato jpeg, png, jpg o gif.',
            'image.max' => 'La imagen no puede exceder los 2048 KB.',

            'days.required' => 'Debes seleccionar al menos 1 día de la semana.',
            'days.array' => 'Los días deben ser un arreglo válido.',

            'notes.string' => 'Las notas deben ser una cadena de texto válida.',
            'notes.min' => 'Las notas deben tener al menos 5 caracteres.',
            'notes.max' => 'Las notas no pueden exceder los 500 caracteres.',
        ]);

        // Guardar promoción en la base de datos
        $promo = new Promo();
        $promo->name = $request->name;
        $promo->discount = $request->discount;
        $promo->promo = $request->promo;
        $promo->notes = $request->notes;

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
    public function show($id)
    {
        // Buscar la promoción por ID o lanzar un error 404 si no existe
        $promocion = Promo::findOrFail($id);

        // Pasar la promoción a la vista para mostrarla
        return view('primary.promociones.promo_show', compact('promocion'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id); // Encuentra la promoción por ID o lanza un error 404 si no existe
        return view('primary.promociones.promo_update', compact('promo')); // Pasa la promoción a la vista
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
            'discount' => [
                'required',
                'numeric',
                'between:5,70',
            ],
            'promo' => [
                'required',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],
            'days' => [
                'required',
                'array',
            ],
            'notes' => [
                'nullable',
                'string',
                'min:5',
                'max:500',
            ],
        ], [
            'name.required' => 'El nombre de la promoción es obligatorio.',
            'name.string' => 'El nombre de la promoción debe ser una cadena de texto válida.',
            'name.max' => 'El nombre de la promoción no puede exceder los 255 caracteres.',

            'promo.required' => 'Debes seleccionar una promoción o servicio.',

            'discount.required' => 'El descuento es obligatorio.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.between' => 'El descuento debe estar entre 5% y 70%.',

            'image.required' => 'Debes cargar una imagen.',
            'image.image' => 'Debes seleccionar una imagen en un formato válido.',
            'image.mimes' => 'La imagen debe estar en formato jpeg, png, jpg o gif.',
            'image.max' => 'La imagen no puede exceder los 2048 KB.',

            'days.required' => 'Debes seleccionar al menos 1 día de la semana.',
            'days.array' => 'Los días deben ser un arreglo válido.',

            'notes.string' => 'Las notas deben ser una cadena de texto válida.',
            'notes.min' => 'Las notas deben tener al menos 5 caracteres.',
            'notes.max' => 'Las notas no pueden exceder los 500 caracteres.',
        ]);
        if (!$promo) {
            return response()->json(['error' => 'Promoción no encontrada'], 404);
        }

        // Actualizar los datos de la promoción
        $promo->name = $request->name;
        $promo->discount = $request->discount;
        $promo->promo = $request->promo;
        $promo->notes = $request->notes;

        // Verificar si se ha cargado una nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($promo->image && file_exists(public_path('assets/img/promociones/' . $promo->image))) {
                unlink(public_path('assets/img/promociones/' . $promo->image));
            }

            // Subir la nueva imagen
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();

            // Generar el nuevo nombre de la imagen
            $timestamp = now()->format('d-m-Y_H-i-s');
            $randomNumber = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $imageName = "promos_{$timestamp}_{$randomNumber}.{$extension}";

            // Mover la imagen a la carpeta correspondiente
            $image->move(public_path('assets/img/promociones'), $imageName);

            // Actualizar el nombre de la imagen en la base de datos
            $promo->image = $imageName;
        }

        // Actualizar los días de la promoción
        $promo->days = json_encode($request->days);

        // Guardar los cambios
        $promo->save();

        return redirect()->route('promociones.index')->with('success', 'La promoción ' . $promo->name . ' ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
