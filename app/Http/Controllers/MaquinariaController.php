<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquinaria;
use App\Models\Proveedor;

class MaquinariaController extends Controller
{

    public function index()
    {
        // Obtener todos los clientes de la base de datos
        $maquinarias = Maquinaria::all();

        // Retornar una vista con los clientes
        return view('primary.maquinarias.maquinaria_index', compact('maquinarias'));
    }

    /**
     * Reload a maquinaria resource.
     */
    public function reload($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        return response()->json($maquinaria);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::all(); // Obtiene todos los proveedores disponibles
        return view('primary.maquinarias.maquinaria_create', compact('proveedores')); // Pasa los proveedores a la vista
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
                'min:3',
                'max:100',
            ],
            'type' => [
                'required',
                'string',
                'min:3',
                'max:50',
            ],
            'status' => [
                'required',
                'in:Operativa,En mantenimiento,Dada de baja,Pendiente de revisión,En reparación,Fuera de servicio,Requiere repuestos,En espera de piezas,Programada para actualización',
            ],
            'acquisition_date' => [
                'required',
                'date',
            ],
            'brand' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'model' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'proveedor_id' => [
                'required',
                'exists:proveedors,id', // Verifica que el proveedor exista
            ],
        ], [
            // Mensajes de error personalizados
            'name.required' => 'El nombre de la maquinaria es obligatorio.',
            'name.string' => 'El nombre de la maquinaria debe ser una cadena de texto válida.',
            'name.min' => 'El nombre de la maquinaria debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre de la maquinaria no puede exceder los 100 caracteres.',

            'type.required' => 'El tipo de maquinaria es obligatorio.',
            'type.string' => 'El tipo de maquinaria debe ser una cadena de texto válida.',
            'type.min' => 'El tipo de maquinaria debe tener al menos 3 caracteres.',
            'type.max' => 'El tipo de maquinaria no puede exceder los 50 caracteres.',

            'status.required' => 'El estado de la maquinaria es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',

            'acquisition_date.required' => 'La fecha de adquisición es obligatoria.',
            'acquisition_date.date' => 'La fecha de adquisición debe ser una fecha válida.',

            'brand.required' => 'La marca de la maquinaria es obligatoria.',
            'brand.string' => 'La marca de la maquinaria debe ser una cadena de texto válida.',
            'brand.min' => 'La marca de la maquinaria debe tener al menos 2 caracteres.',
            'brand.max' => 'La marca de la maquinaria no puede exceder los 50 caracteres.',

            'model.required' => 'El modelo de la maquinaria es obligatorio.',
            'model.string' => 'El modelo de la maquinaria debe ser una cadena de texto válida.',
            'model.min' => 'El modelo de la maquinaria debe tener al menos 2 caracteres.',
            'model.max' => 'El modelo de la maquinaria no puede exceder los 50 caracteres.',

            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        // Guardar maquinaria en la base de datos
        $maquinaria = new Maquinaria();
        $maquinaria->name = $request->name;
        $maquinaria->type = $request->type;
        $maquinaria->status = $request->status;
        $maquinaria->acquisition_date = $request->acquisition_date;
        $maquinaria->brand = $request->brand;
        $maquinaria->model = $request->model;
        $maquinaria->proveedor_id = $request->proveedor_id; // Asignar el proveedor relacionado
        $maquinaria->save();

        return redirect()->route('maquinarias.index')->with('success', 'La maquinaria ' . $maquinaria->name . ' ha sido registrada exitosamente.');
    }

    public function show(string $id)
    {
        // Busca al empleado por su ID
        $maquinaria = Maquinaria::findOrFail($id);

        // Retorna la vista 'empleados.show' y le pasa los datos del empleado
        return view('primary.maquinarias.maquinaria_show', compact('maquinaria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        $proveedores = Proveedor::all();
        return view('primary.maquinarias.maquinaria_update', compact('maquinaria', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $maquinaria = Maquinaria::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'type' => [
                'required',
                'string',
                'min:3',
                'max:50',
            ],
            'status' => [
                'required',
                'in:Operativa,En mantenimiento,Dada de baja,Pendiente de revisión,En reparación,Fuera de servicio,Requiere repuestos,En espera de piezas,Programada para actualización',
            ],
            'acquisition_date' => [
                'required',
                'date',
            ],
            'brand' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'model' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'proveedor_id' => [
                'required',
                'exists:proveedors,id',
            ],
        ], [
            // Mensajes de error personalizados
            'name.required' => 'El nombre de la maquinaria es obligatorio.',
            'name.string' => 'El nombre de la maquinaria debe ser una cadena de texto válida.',
            'name.min' => 'El nombre de la maquinaria debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre de la maquinaria no puede exceder los 100 caracteres.',

            'type.required' => 'El tipo de maquinaria es obligatorio.',
            'type.string' => 'El tipo de maquinaria debe ser una cadena de texto válida.',
            'type.min' => 'El tipo de maquinaria debe tener al menos 3 caracteres.',
            'type.max' => 'El tipo de maquinaria no puede exceder los 50 caracteres.',

            'status.required' => 'El estado de la maquinaria es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',

            'acquisition_date.required' => 'La fecha de adquisición es obligatoria.',
            'acquisition_date.date' => 'La fecha de adquisición debe ser una fecha válida.',

            'brand.required' => 'La marca de la maquinaria es obligatoria.',
            'brand.string' => 'La marca de la maquinaria debe ser una cadena de texto válida.',
            'brand.min' => 'La marca de la maquinaria debe tener al menos 2 caracteres.',
            'brand.max' => 'La marca de la maquinaria no puede exceder los 50 caracteres.',

            'model.required' => 'El modelo de la maquinaria es obligatorio.',
            'model.string' => 'El modelo de la maquinaria debe ser una cadena de texto válida.',
            'model.min' => 'El modelo de la maquinaria debe tener al menos 2 caracteres.',
            'model.max' => 'El modelo de la maquinaria no puede exceder los 50 caracteres.',

            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        // Actualizar la maquinaria en la base de datos
        $maquinaria->update($request->all());

        return redirect()->route('maquinarias.index')->with('success', 'La maquinaria ' . $maquinaria->name . ' ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
