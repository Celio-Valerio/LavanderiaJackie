<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Promo;
use App\Models\Servicio;
use App\Models\ServicioEfectuado;
use Illuminate\Http\Request;

class ServicioEfectuadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los servicios efectuados
        $serviciosEfectuados = ServicioEfectuado::all();
        return view('primary.servicios_efectuados.servicios_efectuados_index', compact('serviciosEfectuados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener clientes, servicios y promociones para mostrarlos en el formulario de creación
        $clientes = Cliente::all();
        $servicios = Servicio::all();
        $promos = Promo::all();  // Si no se quiere usar, puede ser `nullable` en la migración
        return view('primary.servicios_efectuados.servicios_efectuados_create', compact('clientes', 'servicios', 'promos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'promo_id' => 'nullable|exists:promos,id',
            'libras' => 'required|integer|min:1',
            'notas' => 'nullable|string|max:500',
            'estado' => 'required|in:Pendiente,Terminado,Entregado',
            'envio' => 'required|in:Local,A domicilio',
            'direccion' => 'nullable|string|max:500', // Validación para direccion
            'precio_envio' => 'nullable|numeric|min:1|max:350', // Validación para precio_envio
            'pago_envio' => 'required|in:Cliente,Empresa', // Validación para pago_envio
        ], [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'servicio_id.required' => 'El servicio es obligatorio.',
            'servicio_id.exists' => 'El servicio seleccionado no existe.',
            'libras.required' => 'Las libras son obligatorias.',
            'libras.integer' => 'Las libras deben ser un número entero.',
            'libras.min' => 'Las libras deben ser al menos 1.',
            'estado.required' => 'El estado del servicio es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los siguientes: Pendiente, Terminado, Entregado.',
            'envio.required' => 'El tipo de envío es obligatorio.',
            'envio.in' => 'El tipo de envío debe ser uno de los siguientes: Local o A domicilio.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no debe exceder los 500 caracteres.',
            'precio_envio.numeric' => 'El precio de envío debe ser un número.',
            'precio_envio.min' => 'El precio de envío debe ser mayor que L. 1.00.',
            'precio_envio.max' => 'El precio de envío debe ser menor que L. 350.00.',
            'pago_envio.required' => 'Es obligatorio indicar quién paga el envío.',
            'pago_envio.in' => 'El pago del envío debe ser uno de los siguientes: Cliente o Empresa.',
        ]);

        // Crear el servicio efectuado
        $servicioEfectuado = new ServicioEfectuado();
        $servicioEfectuado->cliente_id = $request->cliente_id;
        $servicioEfectuado->servicio_id = $request->servicio_id;
        $servicioEfectuado->promo_id = $request->promo_id;
        $servicioEfectuado->libras = $request->libras;
        $servicioEfectuado->notas = $request->notas;
        $servicioEfectuado->estado = $request->estado;
        $servicioEfectuado->envio = $request->envio;
        $servicioEfectuado->direccion = $request->direccion; // Guardar la dirección
        $servicioEfectuado->precio_envio = $request->precio_envio; // Guardar el precio de envío
        $servicioEfectuado->pago_envio = $request->pago_envio; // Guardar quién paga el envío
        $servicioEfectuado->total = $request->total; // Guardar el total
        $servicioEfectuado->save();

        return redirect()->route('servicios_efectuados.index')->with('success', 'El servicio efectuado ha sido registrado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar el servicio efectuado por su ID
        $servicioEfectuado = ServicioEfectuado::findOrFail($id);

        // Pasar los datos a la vista y renderizarla
        return view('primary.servicios_efectuados.servicios_efectuados_show', compact('servicioEfectuado'));
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
