<?php

namespace Database\Seeders;

use App\Models\Rolpermiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolpermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campos = [
            'bancos_lista', 'bancos_crear', 'bancos_ver',
            'transacciones_lista', 'transacciones_pdf', 'transacciones_ver', 'transacciones_crear',
            'cupones_lista', 'cupones_crear', 'cupones_ver', 'cupones_ver_perdiente', 'cupones_imprimir', 'cupones_pdf',
            'cuponesvencidos_lista', 'cuponesvencidos_crear', 'cuponesvencidos_ver',
            'productos_lista', 'productos_crear', 'productos_ver', 'productos_editar',
            'promociones_lista', 'promociones_crear', 'promociones_ver', 'promociones_modo', 'promociones_editar',
            'compras_lista', 'compras_crear', 'compras_ver',
            'gastos_lista', 'gastos_crear', 'gastos_ver', 'gastos_editar', 'gastos_pdf',
            'inventario_lista',
            'presupuesto_lista', 'presupuesto_crear', 'presupuesto_ver', 'presupuesto_editar',
            'servicios_lista', 'servicios_crear', 'servicios_ver', 'servicios_editar',
            'serviciospendientes_lista', 'serviciospendientes_ver', 'serviciospendientes_editar', 'serviciospendientes_imprimir',
            'serviciosefectuados_lista', 'serviciosefectuados_ver', 'serviciosefectuados_crear','serviciosefectuados_imprimir', 'serviciosefectuados_editar',
            'ventaservicios_lista', 'ventaservicios_ver', 'ventaservicios_imprimir',
            'empleados_lista', 'empleados_crear', 'empleados_ver', 'empleados_editar', 'empleados_constancia',
            'usuarios_lista', 'usuarios_crear', 'usuarios_ver', 'usuarios_editar',
            'clientes_lista', 'clientes_crear', 'clientes_ver', 'clientes_editar',
            'proveedores_lista', 'proveedores_crear', 'proveedores_ver', 'proveedores_editar',
            'maquinas_lista', 'maquinas_crear', 'maquinas_ver', 'maquinas_editar',
            'mantenimiendo_lista', 'mantenimiendo_crear', 'mantenimiendo_ver', 'mantenimiendo_editar'
        ];

        // Administrador
        $admin = new Rolpermiso();
        $admin->nombre = 'Administrador';
        $admin->fecha ='20250420';
        $admin->estado = 'Activo';
        foreach ($campos as $campo) {
            $admin->$campo = true;
        }
        $admin->save();

        // Gerente
        $gerente = new Rolpermiso();
        $gerente->nombre = 'Gerente';
        $gerente->fecha = '20250420';
        $gerente->estado = 'Activo';
        foreach ($campos as $campo) {
            $gerente->$campo = true;
        }
        $gerente->save();

        // Usuario normal
        $usuario = new Rolpermiso();
        $usuario->nombre = 'Usuario normal';
        $usuario->fecha = '20250420';
        $usuario->estado = 'Activo';

        $usuario->servicios_lista = true;
        $usuario->servicios_ver = true;
        $usuario->serviciospendientes_lista = true;
        $usuario->serviciospendientes_ver = true;
        $usuario->serviciosefectuados_lista = true;
        $usuario->serviciosefectuados_ver = true;
        $usuario->mantenimiendo_lista = true;
        $usuario->mantenimiendo_ver = true;
        $usuario->save();
    }
}
