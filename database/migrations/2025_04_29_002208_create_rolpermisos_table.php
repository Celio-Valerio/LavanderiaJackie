<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rolpermisos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('bancos_lista')->nullable();
            $table->boolean('bancos_crear')->nullable();
            $table->boolean('bancos_ver')->nullable();
            $table->boolean('transacciones_lista')->nullable();
            $table->boolean('transacciones_pdf')->nullable();
            $table->boolean('transacciones_ver')->nullable();
            $table->boolean('transacciones_crear')->nullable();
            $table->boolean('cupones_lista')->nullable();
            $table->boolean('cupones_crear')->nullable();
            $table->boolean('cupones_ver')->nullable();
            $table->boolean('cupones_ver_perdiente')->nullable();
            $table->boolean('cupones_imprimir')->nullable();
            $table->boolean('cupones_pdf')->nullable();
            $table->boolean('cuponesvencidos_lista')->nullable();
            $table->boolean('cuponesvencidos_crear')->nullable();
            $table->boolean('cuponesvencidos_ver')->nullable();
            $table->boolean('productos_lista')->nullable();
            $table->boolean('productos_crear')->nullable();
            $table->boolean('productos_ver')->nullable();
            $table->boolean('productos_editar')->nullable();
            $table->boolean('promociones_lista')->nullable();
            $table->boolean('promociones_crear')->nullable();
            $table->boolean('promociones_ver')->nullable();
            $table->boolean('promociones_modo')->nullable();
            $table->boolean('promociones_editar')->nullable();
            $table->boolean('compras_lista')->nullable();
            $table->boolean('compras_crear')->nullable();
            $table->boolean('compras_ver')->nullable();
            $table->boolean('gastos_lista')->nullable();
            $table->boolean('gastos_crear')->nullable();
            $table->boolean('gastos_ver')->nullable();
            $table->boolean('gastos_editar')->nullable();
            $table->boolean('gastos_pdf')->nullable();
            $table->boolean('inventario_lista')->nullable();
            $table->boolean('presupuesto_lista')->nullable();
            $table->boolean('presupuesto_crear')->nullable();
            $table->boolean('presupuesto_ver')->nullable();
            $table->boolean('presupuesto_editar')->nullable();
            $table->boolean('servicios_lista')->nullable();
            $table->boolean('servicios_crear')->nullable();
            $table->boolean('servicios_ver')->nullable();
            $table->boolean('servicios_editar')->nullable();
            $table->boolean('serviciospendientes_lista')->nullable();
            $table->boolean('serviciospendientes_ver')->nullable();
            $table->boolean('serviciospendientes_editar')->nullable();
            $table->boolean('serviciospendientes_imprimir')->nullable();
            $table->boolean('serviciosefectuados_lista')->nullable();
            $table->boolean('serviciosefectuados_crear')->nullable();
            $table->boolean('serviciosefectuados_ver')->nullable();
            $table->boolean('serviciosefectuados_imprimir')->nullable();
            $table->boolean('serviciosefectuados_editar')->nullable();
            $table->boolean('ventaservicios_lista')->nullable();
            $table->boolean('ventaservicios_ver')->nullable();
            $table->boolean('ventaservicios_imprimir')->nullable();
            $table->boolean('empleados_lista')->nullable();
            $table->boolean('empleados_crear')->nullable();
            $table->boolean('empleados_ver')->nullable();
            $table->boolean('empleados_editar')->nullable();
            $table->boolean('empleados_constancia')->nullable();
            $table->boolean('usuarios_lista')->nullable();
            $table->boolean('usuarios_crear')->nullable();
            $table->boolean('usuarios_ver')->nullable();
            $table->boolean('usuarios_editar')->nullable();
            $table->boolean('clientes_lista')->nullable();
            $table->boolean('clientes_crear')->nullable();
            $table->boolean('clientes_ver')->nullable();
            $table->boolean('clientes_editar')->nullable();
            $table->boolean('proveedores_lista')->nullable();
            $table->boolean('proveedores_crear')->nullable();
            $table->boolean('proveedores_ver')->nullable();
            $table->boolean('proveedores_editar')->nullable();
            $table->boolean('maquinas_lista')->nullable();
            $table->boolean('maquinas_crear')->nullable();
            $table->boolean('maquinas_ver')->nullable();
            $table->boolean('maquinas_editar')->nullable();
            $table->boolean('mantenimiendo_lista')->nullable();
            $table->boolean('mantenimiendo_crear')->nullable();
            $table->boolean('mantenimiendo_ver')->nullable();
            $table->boolean('mantenimiendo_editar')->nullable();
            $table->date('fecha');
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rolpermisos');
    }
};
    