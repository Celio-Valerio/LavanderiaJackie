<?php

namespace App\Http\Controllers;

use App\Models\Rolpermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RolpermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Rolpermiso::all();
        $usuario = Auth::user();
        return view('primary.roles.roles_index', compact('roles', 'usuario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = Auth::user();
        return view('primary.roles.formulario_rol', compact('usuario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'unique:rolpermisos,nombre', 'regex:/^[a-zA-Z0-9\s]+$/'],

        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'El nombre del rol debe ser único.',
            'nombre.regex' => 'El nombre del rol solo puede contener letras y números.',

        ]);

        $NuevoRol = new Rolpermiso();
        $NuevoRol->nombre = $request->input('nombre');
        $NuevoRol->bancos_lista = $request->input('bancos_lista', 0);
        $NuevoRol->bancos_crear = $request->input('bancos_crear', 0);
        $NuevoRol->bancos_ver = $request->input('bancos_ver', 0);
        $NuevoRol->transacciones_lista = $request->input('transacciones_lista', 0);
        $NuevoRol->transacciones_pdf = $request->input('transacciones_pdf', 0);
        $NuevoRol->transacciones_ver = $request->input('transacciones_ver', 0);
        $NuevoRol->transacciones_crear = $request->input('transacciones_crear', 0);
        $NuevoRol->cupones_lista = $request->input('cupones_lista', 0);
        $NuevoRol->cupones_crear = $request->input('cupones_crear', 0);
        $NuevoRol->cupones_ver = $request->input('cupones_ver', 0);
        $NuevoRol->cupones_ver_perdiente = $request->input('cupones_ver_perdiente', 0);
        $NuevoRol->cupones_imprimir = $request->input('cupones_imprimir', 0);
        $NuevoRol->cupones_pdf = $request->input('cupones_pdf', 0);
        $NuevoRol->cuponesvencidos_lista = $request->input('cuponesvencidos_lista', 0);
        $NuevoRol->cuponesvencidos_crear = $request->input('cuponesvencidos_crear', 0);
        $NuevoRol->cuponesvencidos_ver = $request->input('cuponesvencidos_ver', 0);
        $NuevoRol->productos_lista = $request->input('productos_lista', 0);
        $NuevoRol->productos_crear = $request->input('productos_crear', 0);
        $NuevoRol->productos_ver = $request->input('productos_ver', 0);
        $NuevoRol->productos_editar = $request->input('productos_editar', 0);
        $NuevoRol->promociones_lista = $request->input('promociones_lista', 0);
        $NuevoRol->promociones_crear = $request->input('promociones_crear', 0);
        $NuevoRol->promociones_ver = $request->input('promociones_ver', 0);
        $NuevoRol->promociones_modo = $request->input('promociones_modo', 0);
        $NuevoRol->promociones_editar = $request->input('promociones_editar', 0);
        $NuevoRol->compras_lista = $request->input('compras_lista', 0);
        $NuevoRol->compras_crear = $request->input('compras_crear', 0);
        $NuevoRol->compras_ver = $request->input('compras_ver', 0);
        $NuevoRol->gastos_lista = $request->input('gastos_lista', 0);
        $NuevoRol->gastos_crear = $request->input('gastos_crear', 0);
        $NuevoRol->gastos_ver = $request->input('gastos_ver', 0);
        $NuevoRol->gastos_editar = $request->input('gastos_editar', 0);
        $NuevoRol->gastos_pdf = $request->input('gastos_pdf', 0);
        $NuevoRol->inventario_lista = $request->input('inventario_lista', 0);
        $NuevoRol->presupuesto_lista = $request->input('presupuesto_lista', 0);
        $NuevoRol->presupuesto_crear = $request->input('presupuesto_crear', 0);
        $NuevoRol->presupuesto_ver = $request->input('presupuesto_ver', 0);
        $NuevoRol->presupuesto_editar = $request->input('presupuesto_editar', 0);
        $NuevoRol->servicios_lista = $request->input('servicios_lista', 0);
        $NuevoRol->servicios_crear = $request->input('servicios_crear', 0);
        $NuevoRol->servicios_ver = $request->input('servicios_ver', 0);
        $NuevoRol->servicios_editar = $request->input('servicios_editar', 0);
        $NuevoRol->serviciospendientes_lista = $request->input('serviciospendientes_lista', 0);
        $NuevoRol->serviciospendientes_ver = $request->input('serviciospendientes_ver', 0);
        $NuevoRol->serviciospendientes_editar = $request->input('serviciospendientes_editar', 0);
        $NuevoRol->serviciospendientes_imprimir = $request->input('serviciospendientes_imprimir', 0);
        $NuevoRol->serviciosefectuados_lista = $request->input('serviciosefectuados_lista', 0);
        $NuevoRol->serviciosefectuados_crear = $request->input('serviciosefectuados_crear', 0);
        $NuevoRol->serviciosefectuados_ver = $request->input('serviciosefectuados_ver', 0);
        $NuevoRol->serviciosefectuados_imprimir = $request->input('serviciosefectuados_imprimir', 0);
        $NuevoRol->serviciosefectuados_editar = $request->input('serviciosefectuados_editar', 0);
        $NuevoRol->ventaservicios_lista = $request->input('ventaservicios_lista', 0);
        $NuevoRol->ventaservicios_ver = $request->input('ventaservicios_ver', 0);
        $NuevoRol->ventaservicios_imprimir = $request->input('ventaservicios_imprimir', 0);
        $NuevoRol->empleados_lista = $request->input('empleados_lista', 0);
        $NuevoRol->empleados_crear = $request->input('empleados_crear', 0);
        $NuevoRol->empleados_ver = $request->input('empleados_ver', 0);
        $NuevoRol->empleados_editar = $request->input('empleados_editar', 0);
        $NuevoRol->empleados_constancia = $request->input('empleados_constancia', 0);
        $NuevoRol->usuarios_lista = $request->input('usuarios_lista', 0);
        $NuevoRol->usuarios_crear = $request->input('usuarios_crear', 0);
        $NuevoRol->usuarios_ver = $request->input('usuarios_ver', 0);
        $NuevoRol->usuarios_editar = $request->input('usuarios_editar', 0);
        $NuevoRol->clientes_lista = $request->input('clientes_lista', 0);
        $NuevoRol->clientes_crear = $request->input('clientes_crear', 0);
        $NuevoRol->clientes_ver = $request->input('clientes_ver', 0);
        $NuevoRol->clientes_editar = $request->input('clientes_editar', 0);
        $NuevoRol->proveedores_lista = $request->input('proveedores_lista', 0);
        $NuevoRol->proveedores_crear = $request->input('proveedores_crear', 0);
        $NuevoRol->proveedores_ver = $request->input('proveedores_ver', 0);
        $NuevoRol->proveedores_editar = $request->input('proveedores_editar', 0);
        $NuevoRol->maquinas_lista = $request->input('maquinas_lista', 0);
        $NuevoRol->maquinas_crear = $request->input('maquinas_crear', 0);
        $NuevoRol->maquinas_ver = $request->input('maquinas_ver', 0);
        $NuevoRol->maquinas_editar = $request->input('maquinas_editar', 0);
        $NuevoRol->mantenimiendo_lista = $request->input('mantenimiendo_lista', 0);
        $NuevoRol->mantenimiendo_crear = $request->input('mantenimiendo_crear', 0);
        $NuevoRol->mantenimiendo_ver = $request->input('mantenimiendo_ver', 0);
        $NuevoRol->mantenimiendo_editar = $request->input('mantenimiendo_editar', 0);
        $NuevoRol->fecha = now();

        if($request->input('bancos_lista') == 0 && $request->input('mantenimiendo_lista') == 0 &&$request->input('maquinas_lista') == 0 &&
            $request->input('proveedores_lista') == 0 && $request->input('clientes_lista') == 0 && $request->input('usuarios_lista') == 0 &&
            $request->input('empleados_lista') == 0 && $request->input('ventaservicios_lista') == 0 && $request->input('serviciosefectuados_lista') == 0 &&
            $request->input('serviciospendientes_lista') == 0 && $request->input('servicios_lista') == 0 && $request->input('presupuesto_lista') == 0 &&
            $request->input('inventario_lista') == 0 && $request->input('gastos_lista') == 0 && $request->input('compras_lista') == 0 &&
            $request->input('promociones_lista') == 0 && $request->input('productos_lista') == 0 && $request->input('cuponesvencidos_lista') == 0 && $request->input('cupones_lista') == 0 &&
            $request->input('transacciones_lista') == 0){
            $NuevoRol->estado = 'Inactivo';
        }
        else{
            $NuevoRol->estado = 'Activo';
        }

        if ($NuevoRol->save()){
            return redirect()->route('roles.index')->with('success', 'Rol guardado exitosamente.');
        } else {
            return redirect()->route('roles.index')->with('success', 'Error. El rol no pudo ser guardado.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rol = Rolpermiso::findOrfail($id);
        $usuario = Auth::user();
        return view('primary.roles.roles_show', compact('usuario', 'rol'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rol = Rolpermiso::findOrfail($id);
        $usuario = Auth::user();
        return view('primary.roles.formulario_rol', compact('usuario', 'rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $NuevoRol = Rolpermiso::findOrfail($id);
        $request->validate([
            'nombre' => ['required', Rule::unique('rolpermisos', 'nombre')->ignore($NuevoRol->id), 'regex:/^[a-zA-Z0-9\s]+$/'],

        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'El nombre del rol debe ser único.',
            'nombre.regex' => 'El nombre del rol solo puede contener letras y números.',

        ]);
        $NuevoRol->nombre = $request->input('nombre');
        $NuevoRol->bancos_lista = $request->input('bancos_lista', 0);
        $NuevoRol->bancos_crear = $request->input('bancos_crear', 0);
        $NuevoRol->bancos_ver = $request->input('bancos_ver', 0);
        $NuevoRol->transacciones_lista = $request->input('transacciones_lista', 0);
        $NuevoRol->transacciones_pdf = $request->input('transacciones_pdf', 0);
        $NuevoRol->transacciones_ver = $request->input('transacciones_ver', 0);
        $NuevoRol->transacciones_crear = $request->input('transacciones_crear', 0);
        $NuevoRol->cupones_lista = $request->input('cupones_lista', 0);
        $NuevoRol->cupones_crear = $request->input('cupones_crear', 0);
        $NuevoRol->cupones_ver = $request->input('cupones_ver', 0);
        $NuevoRol->cupones_ver_perdiente = $request->input('cupones_ver_perdiente', 0);
        $NuevoRol->cupones_imprimir = $request->input('cupones_imprimir', 0);
        $NuevoRol->cupones_pdf = $request->input('cupones_pdf', 0);
        $NuevoRol->cuponesvencidos_lista = $request->input('cuponesvencidos_lista', 0);
        $NuevoRol->cuponesvencidos_crear = $request->input('cuponesvencidos_crear', 0);
        $NuevoRol->cuponesvencidos_ver = $request->input('cuponesvencidos_ver', 0);
        $NuevoRol->productos_lista = $request->input('productos_lista', 0);
        $NuevoRol->productos_crear = $request->input('productos_crear', 0);
        $NuevoRol->productos_ver = $request->input('productos_ver', 0);
        $NuevoRol->productos_editar = $request->input('productos_editar', 0);
        $NuevoRol->promociones_lista = $request->input('promociones_lista', 0);
        $NuevoRol->promociones_crear = $request->input('promociones_crear', 0);
        $NuevoRol->promociones_ver = $request->input('promociones_ver', 0);
        $NuevoRol->promociones_modo = $request->input('promociones_modo', 0);
        $NuevoRol->promociones_editar = $request->input('promociones_editar', 0);
        $NuevoRol->compras_lista = $request->input('compras_lista', 0);
        $NuevoRol->compras_crear = $request->input('compras_crear', 0);
        $NuevoRol->compras_ver = $request->input('compras_ver', 0);
        $NuevoRol->gastos_lista = $request->input('gastos_lista', 0);
        $NuevoRol->gastos_crear = $request->input('gastos_crear', 0);
        $NuevoRol->gastos_ver = $request->input('gastos_ver', 0);
        $NuevoRol->gastos_editar = $request->input('gastos_editar', 0);
        $NuevoRol->gastos_pdf = $request->input('gastos_pdf', 0);
        $NuevoRol->inventario_lista = $request->input('inventario_lista', 0);
        $NuevoRol->presupuesto_lista = $request->input('presupuesto_lista', 0);
        $NuevoRol->presupuesto_crear = $request->input('presupuesto_crear', 0);
        $NuevoRol->presupuesto_ver = $request->input('presupuesto_ver', 0);
        $NuevoRol->presupuesto_editar = $request->input('presupuesto_editar', 0);
        $NuevoRol->servicios_lista = $request->input('servicios_lista', 0);
        $NuevoRol->servicios_crear = $request->input('servicios_crear', 0);
        $NuevoRol->servicios_ver = $request->input('servicios_ver', 0);
        $NuevoRol->servicios_editar = $request->input('servicios_editar', 0);
        $NuevoRol->serviciospendientes_lista = $request->input('serviciospendientes_lista', 0);
        $NuevoRol->serviciospendientes_ver = $request->input('serviciospendientes_ver', 0);
        $NuevoRol->serviciospendientes_editar = $request->input('serviciospendientes_editar', 0);
        $NuevoRol->serviciospendientes_imprimir = $request->input('serviciospendientes_imprimir', 0);
        $NuevoRol->serviciosefectuados_lista = $request->input('serviciosefectuados_lista', 0);
        $NuevoRol->serviciosefectuados_crear = $request->input('serviciosefectuados_crear', 0);
        $NuevoRol->serviciosefectuados_ver = $request->input('serviciosefectuados_ver', 0);
        $NuevoRol->serviciosefectuados_imprimir = $request->input('serviciosefectuados_imprimir', 0);
        $NuevoRol->serviciosefectuados_editar = $request->input('serviciosefectuados_editar', 0);
        $NuevoRol->ventaservicios_lista = $request->input('ventaservicios_lista', 0);
        $NuevoRol->ventaservicios_ver = $request->input('ventaservicios_ver', 0);
        $NuevoRol->ventaservicios_imprimir = $request->input('ventaservicios_imprimir', 0);
        $NuevoRol->empleados_lista = $request->input('empleados_lista', 0);
        $NuevoRol->empleados_crear = $request->input('empleados_crear', 0);
        $NuevoRol->empleados_ver = $request->input('empleados_ver', 0);
        $NuevoRol->empleados_editar = $request->input('empleados_editar', 0);
        $NuevoRol->empleados_constancia = $request->input('empleados_constancia', 0);
        $NuevoRol->usuarios_lista = $request->input('usuarios_lista', 0);
        $NuevoRol->usuarios_crear = $request->input('usuarios_crear', 0);
        $NuevoRol->usuarios_ver = $request->input('usuarios_ver', 0);
        $NuevoRol->usuarios_editar = $request->input('usuarios_editar', 0);
        $NuevoRol->clientes_lista = $request->input('clientes_lista', 0);
        $NuevoRol->clientes_crear = $request->input('clientes_crear', 0);
        $NuevoRol->clientes_ver = $request->input('clientes_ver', 0);
        $NuevoRol->clientes_editar = $request->input('clientes_editar', 0);
        $NuevoRol->proveedores_lista = $request->input('proveedores_lista', 0);
        $NuevoRol->proveedores_crear = $request->input('proveedores_crear', 0);
        $NuevoRol->proveedores_ver = $request->input('proveedores_ver', 0);
        $NuevoRol->proveedores_editar = $request->input('proveedores_editar', 0);
        $NuevoRol->maquinas_lista = $request->input('maquinas_lista', 0);
        $NuevoRol->maquinas_crear = $request->input('maquinas_crear', 0);
        $NuevoRol->maquinas_ver = $request->input('maquinas_ver', 0);
        $NuevoRol->maquinas_editar = $request->input('maquinas_editar', 0);
        $NuevoRol->mantenimiendo_lista = $request->input('mantenimiendo_lista', 0);
        $NuevoRol->mantenimiendo_crear = $request->input('mantenimiendo_crear', 0);
        $NuevoRol->mantenimiendo_ver = $request->input('mantenimiendo_ver', 0);
        $NuevoRol->mantenimiendo_editar = $request->input('mantenimiendo_editar', 0);
        $NuevoRol->fecha = now();

        if($request->input('bancos_lista') == 0 && $request->input('mantenimiendo_lista') == 0 &&$request->input('maquinas_lista') == 0 &&
            $request->input('proveedores_lista') == 0 && $request->input('clientes_lista') == 0 && $request->input('usuarios_lista') == 0 &&
            $request->input('empleados_lista') == 0 && $request->input('ventaservicios_lista') == 0 && $request->input('serviciosefectuados_lista') == 0 &&
            $request->input('serviciospendientes_lista') == 0 && $request->input('servicios_lista') == 0 && $request->input('presupuesto_lista') == 0 &&
            $request->input('inventario_lista') == 0 && $request->input('gastos_lista') == 0 && $request->input('compras_lista') == 0 &&
            $request->input('promociones_lista') == 0 && $request->input('productos_lista') == 0 && $request->input('cuponesvencidos_lista') == 0 && $request->input('cupones_lista') == 0 &&
            $request->input('transacciones_lista') == 0){
            $NuevoRol->estado = 'Inactivo';
        }
        else{
            $NuevoRol->estado = 'Activo';
        }

        if ($NuevoRol->save()){
            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
        } else {
            return redirect()->route('roles.index')->with('success', 'Error. El rol no pudo ser actualizado.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}