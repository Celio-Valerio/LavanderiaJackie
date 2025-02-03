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
            'estado' => 'in:Pendiente',
            'envio' => 'required|in:Local,A domicilio',
            'direccion' => 'nullable|string|max:500', // Validación para direccion
            'precio_envio' => 'nullable|numeric|min:1|max:999', // Validación para precio_envio
            'pago_envio' => 'nullable|in:Cliente,Empresa', // Validación para pago_envio
            ], [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',

            'servicio_id.required' => 'El servicio es obligatorio.',
            'servicio_id.exists' => 'El servicio seleccionado no existe.',

            'libras.required' => 'Las libras son obligatorias.',
            'libras.integer' => 'Las libras deben ser un número entero.',
            'libras.min' => 'Las libras deben ser al menos 1.',

            'estado.in' => 'El estado debe ser uno de los siguientes: Pendiente.',

            'envio.required' => 'El tipo de envío es obligatorio.',
            'envio.in' => 'El tipo de envío debe ser uno de los siguientes: Local o A domicilio.',

            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no debe exceder los 500 caracteres.',

            'precio_envio.numeric' => 'El precio de envío debe ser un número.',
            'precio_envio.min' => 'El precio de envío debe ser mayor o igual a 0.',
            'precio_envio.max' => 'El precio de envío debe ser menor o igual a 999.',

            'pago_envio.in' => 'El pago del envío debe ser uno de los siguientes: Cliente o Empresa.',
        ]);

        // Lógica de validación específica según el tipo de envío
        if ($request->envio === 'A domicilio') {
            // Si es "A domicilio", la dirección y pago de envío son obligatorios
            $request->validate([
                'direccion' => 'required|string|max:500', // Dirección obligatoria
                'pago_envio' => 'required|in:Cliente,Empresa', // Pago obligatorio
            ], [
                'direccion.required' => 'La dirección es obligatoria para el envío a domicilio.',
                'direccion.string' => 'La dirección debe ser una cadena de texto válida.',
                'direccion.max' => 'La dirección no debe exceder los 500 caracteres.',
                'pago_envio.required' => 'Es obligatorio indicar quién paga el envío (Cliente o Empresa).',
                'pago_envio.in' => 'La opción de pago del envío debe ser "Cliente" o "Empresa".',
            ]);
        }

        // Si el pago del envío es "Cliente", el precio de envío puede ser 0
        if ($request->pago_envio === 'Cliente') {
            $request->validate([
                'precio_envio' => 'nullable|numeric|min:0|max:0', // El precio de envío debe ser 0
            ], [
                'precio_envio.numeric' => 'El precio de envío debe ser un número.',
                'precio_envio.min' => 'El precio de envío debe ser 0.',
                'precio_envio.max' => 'El precio de envío debe ser 0.',
            ]);
        }

        if ($request->pago_envio === 'Empresa') {
            // Si el pago del envío es "Empresa", el precio de envío debe estar entre 0 y 999
            $request->validate([
                'precio_envio' => 'required|numeric|min:1|max:999', // El precio de envío debe estar entre 0 y 999
            ], [
                'precio_envio.required' => 'El precio de envío es obligatorio.',
                'precio_envio.numeric' => 'El precio de envío debe ser un número.',
                'precio_envio.min' => 'El precio de envío debe ser al menos L. 1.00.',
                'precio_envio.max' => 'El precio de envío debe ser menor o igual a L. 999.00.',
            ]);
        }

        // Crear el servicio efectuado
        $servicioEfectuado = new ServicioEfectuado();
        $servicioEfectuado->cliente_id = $request->cliente_id;
        $servicioEfectuado->servicio_id = $request->servicio_id;
        $servicioEfectuado->promo_id = $request->promo_id;
        $servicioEfectuado->libras = $request->libras;
        $servicioEfectuado->notas = $request->notas;
        $servicioEfectuado->estado = 'Pendiente';
        $servicioEfectuado->envio = $request->envio;
        $servicioEfectuado->direccion = $request->direccion; // Guardar la dirección
        $servicioEfectuado->precio_envio = $request->precio_envio; // Guardar el precio de envío
        $servicioEfectuado->pago_envio = $request->pago_envio; // Guardar quién paga el envío
        $servicioEfectuado->total = str_replace(',', '', $request->total); // Eliminar las comas
        // Asignar fecha y hora actual
        $servicioEfectuado->fecha = now()->toDateString(); // Fecha actual en formato Y-m-d
        $servicioEfectuado->hora = now()->toTimeString(); // Hora actual en formato H:i:s
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
     * Display the specified resource.
     */
    public function factura($id)
    {
        // Buscar el servicio efectuado por su ID
        $servicioEfectuado = ServicioEfectuado::findOrFail($id);

        // Pasar los datos a la vista y renderizarla
        return view('primary.servicios_efectuados.servicios_efectuados_factura', compact('servicioEfectuado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Buscar el servicio pendiente por su ID
        $servicioPendiente = ServicioEfectuado::findOrFail($id);

        // Obtener los datos necesarios para el formulario (clientes, servicios, promociones, etc.)
        $clientes = Cliente::all();
        $servicios = Servicio::all();
        $promos = Promo::all();

        // Retornar la vista de edición con los datos
        return view('primary.servicios_efectuados.servicios_efectuados_update', compact('servicioPendiente', 'clientes', 'servicios', 'promos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'promo_id' => 'nullable|exists:promos,id',
            'libras' => 'required|integer|min:1',
            'notas' => 'nullable|string|max:500',
            'estado' => 'in:Pendiente,Terminado,Entregado', // Permitir actualizar el estado
            'envio' => 'required|in:Local,A domicilio',
            'direccion' => 'nullable|string|max:500', // Validación para dirección
            'precio_envio' => 'nullable|numeric|min:1|max:999', // Validación para precio_envio
            'pago_envio' => 'nullable|in:Cliente,Empresa', // Validación para pago_envio
        ], [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',

            'servicio_id.required' => 'El servicio es obligatorio.',
            'servicio_id.exists' => 'El servicio seleccionado no existe.',

            'libras.required' => 'Las libras son obligatorias.',
            'libras.integer' => 'Las libras deben ser un número entero.',
            'libras.min' => 'Las libras deben ser al menos 1.',

            'estado.in' => 'El estado debe ser uno de los siguientes: Pendiente, Terminado o Entregado.',

            'envio.required' => 'El tipo de envío es obligatorio.',
            'envio.in' => 'El tipo de envío debe ser uno de los siguientes: Local o A domicilio.',

            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no debe exceder los 500 caracteres.',

            'precio_envio.numeric' => 'El precio de envío debe ser un número.',
            'precio_envio.min' => 'El precio de envío debe ser mayor o igual a 0.',
            'precio_envio.max' => 'El precio de envío debe ser menor o igual a 999.',

            'pago_envio.in' => 'El pago del envío debe ser uno de los siguientes: Cliente o Empresa.',
        ]);

        // Lógica de validación específica según el tipo de envío
        if ($request->envio === 'A domicilio') {
            // Si es "A domicilio", la dirección y pago de envío son obligatorios
            $request->validate([
                'direccion' => 'required|string|max:500', // Dirección obligatoria
                'pago_envio' => 'required|in:Cliente,Empresa', // Pago obligatorio
            ], [
                'direccion.required' => 'La dirección es obligatoria para el envío a domicilio.',
                'direccion.string' => 'La dirección debe ser una cadena de texto válida.',
                'direccion.max' => 'La dirección no debe exceder los 500 caracteres.',
                'pago_envio.required' => 'Es obligatorio indicar quién paga el envío (Cliente o Empresa).',
                'pago_envio.in' => 'La opción de pago del envío debe ser "Cliente" o "Empresa".',
            ]);
        }

        // Si el pago del envío es "Cliente", el precio de envío puede ser 0
        if ($request->pago_envio === 'Cliente') {
            $request->validate([
                'precio_envio' => 'nullable|numeric|min:0|max:0', // El precio de envío debe ser 0
            ], [
                'precio_envio.numeric' => 'El precio de envío debe ser un número.',
                'precio_envio.min' => 'El precio de envío debe ser 0.',
                'precio_envio.max' => 'El precio de envío debe ser 0.',
            ]);
        }

        if ($request->pago_envio === 'Empresa') {
            // Si el pago del envío es "Empresa", el precio de envío debe estar entre 0 y 999
            $request->validate([
                'precio_envio' => 'required|numeric|min:1|max:999', // El precio de envío debe estar entre 0 y 999
            ], [
                'precio_envio.required' => 'El precio de envío es obligatorio.',
                'precio_envio.numeric' => 'El precio de envío debe ser un número.',
                'precio_envio.min' => 'El precio de envío debe ser al menos L. 1.00.',
                'precio_envio.max' => 'El precio de envío debe ser menor o igual a L. 999.00.',
            ]);
        }

        // Buscar el servicio efectuado existente
        $servicioPendiente = ServicioEfectuado::findOrFail($id);

        // Actualizar los datos del servicio efectuado solo si se envían en el request
        $servicioPendiente->cliente_id = $request->cliente_id ?? $servicioPendiente->cliente_id;
        $servicioPendiente->servicio_id = $request->servicio_id ?? $servicioPendiente->servicio_id;
        $servicioPendiente->promo_id = $request->promo_id ?? $servicioPendiente->promo_id;
        $servicioPendiente->libras = $request->libras ?? $servicioPendiente->libras;
        $servicioPendiente->notas = $request->notas ?? $servicioPendiente->notas;
        $servicioPendiente->estado = $request->estado ?? $servicioPendiente->estado;
        $servicioPendiente->envio = $request->envio ?? $servicioPendiente->envio;
        $servicioPendiente->direccion = $request->direccion ?? $servicioPendiente->direccion;
        $servicioPendiente->precio_envio = $request->precio_envio ?? $servicioPendiente->precio_envio;
        $servicioPendiente->pago_envio = $request->pago_envio ?? $servicioPendiente->pago_envio;
        $servicioPendiente->total = isset($request->total) ? str_replace(',', '', $request->total) : $servicioPendiente->total;
        $servicioPendiente->fecha = now()->toDateString(); // Siempre actualiza la fecha
        $servicioPendiente->hora = now()->toTimeString(); // Siempre actualiza la hora

        $servicioPendiente->save();


        return redirect()->route('servicios_pendientes.index')->with('success', 'El servicio pendiente ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
