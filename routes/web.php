<?php

use App\Http\Controllers\ControlCuentaController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\PromoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ServicioEfectuadoController;
use App\Http\Controllers\ServicioPendienteController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\GastoDiarioController;
use App\Http\Controllers\CuentaBancoController;
use App\Http\Controllers\PresupuestoController;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pagina_principal');
});

Route::get('/inicio', function () {
    return view('layouts.principal');
});

// Ruta para mostrar la lista de clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// Rutas de recursos para clientes (incluye crear, almacenar, editar, actualizar y eliminar)
Route::resource('clientes', ClienteController::class);

// Ruta para recargar el formulario de editar cliente
Route::get('/clientes/{id}/reload', [ClienteController::class, 'reload'])->name('clientes.reload');

// Rutas para manejar empleados
Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index'); // Lista de empleados

// Rutas de recursos para empleados
Route::resource('empleados', EmpleadoController::class);

// Ruta para recargar el formulario de editar empleado
Route::get('/empleados/{id}/reload', [EmpleadoController::class, 'reload'])->name('empleados.reload');



// Rutas para manejar proveedores
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index'); // Lista de proveedores

// Rutas de recursos para proveedores
Route::resource('proveedores', ProveedorController::class);

// Ruta para recargar el formulario de editar proveedor
Route::get('/proveedores/{id}/reload', [ProveedorController::class, 'reload'])->name('proveedores.reload');


// Rutas para manejar proveedores
Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index'); // Lista de proveedores

// Rutas de recursos para proveedores
Route::resource('mantenimientos', MantenimientoController::class);

// Ruta para recargar el formulario de editar proveedor
Route::get('/mantenimientos/{id}/reload', [MantenimientoController::class, 'reload'])->name('mantenimientos.reload');


// Rutas para manejar maquinarias
Route::get('/maquinarias', [MaquinariaController::class, 'index'])->name('maquinarias.index'); // Lista de proveedores

// Rutas de recursos para maquinarias
Route::resource('maquinarias', MaquinariaController::class);

// Ruta para recargar el formulario de editar maquinaria
Route::get('/maquinarias/{id}/reload', [MaquinariaController::class, 'reload'])->name('maquinarias.reload');

// Rutas para manejar promociones
Route::get('/promociones', [PromoController::class, 'index'])->name('promociones.index'); // Lista de promociones
Route::get('/promociones-tarjetas', [PromoController::class, 'view'])->name('promociones.view'); // Lista de promociones

// Rutas de recursos para promociones
Route::resource('promociones', PromoController::class);

// Ruta para recargar el formulario de editar promocione
Route::get('/promociones/{id}/reload', [PromoController::class, 'reload'])->name('promociones.reload');


// Rutas para manejar compras
Route::get('/compras', [CompraController::class, 'index'])->name('compras.index'); // Lista de compras

// Rutas de recursos para compras
Route::resource('compras', CompraController::class);

// Ruta para recargar el formulario de editar compra
Route::get('/compras/{id}/reload', [CompraController::class, 'reload'])->name('compras.reload');

// Rutas para manejar gastos
Route::get('/gastos', [GastoController::class, 'index'])->name('gastos.index'); // Lista de gastos

// Rutas de recursos para gastos
Route::resource('gastos', GastoController::class);

// Rutas para manejar productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index'); // Lista de productos

// Rutas de recursos para productos
Route::resource('productos', ProductoController::class);

// Ruta para recargar el formulario de editar producto
Route::get('/productos/{id}/reload', [ProductoController::class, 'reload'])->name('productos.reload');

// Rutas para manejar servicios
Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index'); // Lista de servicios
Route::get('/servicios-tarjetas', [ServicioController::class, 'view'])->name('servicios.view'); // Vista en tarjetas

// Rutas de recursos para servicios
Route::resource('servicios', ServicioController::class);

// Ruta para recargar el formulario de editar servicio
Route::get('/servicios/{id}/reload', [ServicioController::class, 'reload'])->name('servicios.reload');

// Ruta para buscar servicios (por nombre, tipo, etc.)
Route::get('/servicios/buscar', [ServicioController::class, 'search'])->name('servicios.search');

// Ruta para obtener los servicios activos
Route::get('/servicios/activos', [ServicioController::class, 'active'])->name('servicios.active');

// Ruta para la lista de servicios efectuados
Route::get('/servicios-pendientes', [ServicioPendienteController::class, 'index'])->name('servicios_pendientes.index');

// Ruta para crear un nuevo servicio pendiente
Route::get('/servicios-pendientes/create', [ServicioPendienteController::class, 'create'])->name('servicios_pendientes.create');

// Ruta para almacenar un nuevo servicio pendiente
Route::post('/servicios-pendientes', [ServicioPendienteController::class, 'store'])->name('servicios_pendientes.store');

// Ruta para la visualización de un servicio pendiente
Route::get('/servicios-pendientes/show/{id}', [ServicioPendienteController::class, 'show'])->name('servicios_pendientes.show');

// Ruta para recargar el formulario de editar servicio pendiente
Route::get('/servicios-pendientes/{id}/reload', [ServicioPendienteController::class, 'reload'])->name('servicios_pendientes.reload');

// Ruta para cambiar el estado de un servicio pendiente (activar/desactivar)
Route::post('/servicios-pendientes/{id}/toggle', [ServicioPendienteController::class, 'toggleStatus'])->name('servicios_pendientes.toggle');

// Ruta para mostrar el formulario de edición de un servicio pendiente
Route::get('/servicios-pendientes/{id}/edit', [ServicioPendienteController::class, 'edit'])->name('servicios_pendientes.edit');

// Ruta para actualizar un servicio pendiente existente
Route::put('/servicios-pendientes/{id}', [ServicioPendienteController::class, 'update'])->name('servicios_pendientes.update');

// Ruta para la visualización de un servicio pendiente factura
Route::get('/servicios-pendientes/factura/{id}', [ServicioPendienteController::class, 'factura'])->name('servicios_pendientes.factura');

// Ruta para la lista de servicios efectuados
Route::get('/servicios-efectuados', [ServicioEfectuadoController::class, 'index'])->name('servicios_efectuados.index');

// Ruta para crear un nuevo servicio efectuado
Route::get('/servicios-efectuados/create', [ServicioEfectuadoController::class, 'create'])->name('servicios_efectuados.create');

// Ruta para almacenar un nuevo servicio efectuado
Route::post('/servicios-efectuados', [ServicioEfectuadoController::class, 'store'])->name('servicios_efectuados.store');

// Ruta para la visualización de un servicio efectuado
Route::get('/servicios-efectuados/show/{id}', [ServicioEfectuadoController::class, 'show'])->name('servicios_efectuados.show');

// Ruta para recargar el formulario de editar servicio efectuado
Route::get('/servicios-efectuados/{id}/reload', [ServicioEfectuadoController::class, 'reload'])->name('servicios_efectuados.reload');

// Ruta para cambiar el estado de un servicio efectuado (activar/desactivar)
Route::post('/servicios-efectuados/{id}/toggle', [ServicioEfectuadoController::class, 'toggleStatus'])->name('servicios_efectuados.toggle');

// Ruta para mostrar el formulario de edición de un servicio efectuado
Route::get('/servicios-efectuados/{id}/edit', [ServicioEfectuadoController::class, 'edit'])->name('servicios_efectuados.edit');

// Ruta para actualizar un servicio efectuado existente
Route::put('/servicios-efectuados/{id}', [ServicioEfectuadoController::class, 'update'])->name('servicios_efectuados.update');

// Ruta para la visualización de un servicio efectuado en factura
Route::get('/servicios-efectuados/factura/{id}', [ServicioEfectuadoController::class, 'factura'])->name('servicios_efectuados.factura');

// Ruta para la lista de servicios efectuados
Route::get('/servicios-ventas', [ServicioEfectuadoController::class, 'ventas'])->name('servicios_efectuados.ventas');

// Rutas para manejar inventarios
Route::get('/inventarios', [InventarioController::class, 'index'])->name('inventarios.inventarios_index'); // Lista de productos

// Rutas de recursos para inventarios
Route::resource('inventarios', InventarioController::class);

//Ruta de historial de clientes
Route::get('/historial_Cliente/{id}', [\App\Http\Controllers\HistorialCliente::class, 'historialCliente'])->name('historial.ver');

//Ruta actualizar estado
Route::post('actualizarEstado/{id}', [ServicioPendienteController::class, 'actualizarEstado'])
    ->name('actualizarEstado');

//Ruta actualizar estado de efectuados
Route::post('actualizarEstadoE/{id}', [ServicioEfectuadoController::class, 'actualizarEstadoe'])
    ->name('actualizarEstadoE');

//Enviar correo
Route::post('enviar_correo', function (Request $request) { })->name('enviar_correo');

// Ruta para la lista de gastos diarios
Route::get('/gastos-diarios', [GastoDiarioController::class, 'index'])->name('gastos_diarios.index');
Route::get('/gastos-diarios/create', [GastoDiarioController::class, 'create'])->name('gastos_diarios.create');
Route::put('/gastos-diarios/{id}', [GastoDiarioController::class, 'update'])->name('gastos_diarios.update');




// Ruta para listar todas las cuentas bancarias
Route::get('/cuenta-bancos', [CuentaBancoController::class, 'index'])->name('cuenta_bancos.index');

// Ruta para mostrar el formulario de creación de una nueva cuenta bancaria
Route::get('/cuenta-bancos/create', [CuentaBancoController::class, 'create'])->name('cuenta_bancos.create');

// Ruta para almacenar una nueva cuenta bancaria
Route::post('/cuenta-bancos', [CuentaBancoController::class, 'store'])->name('cuenta_bancos.store');

// Ruta para mostrar los detalles de una cuenta bancaria específica
Route::get('/cuenta-bancos/{id}', [CuentaBancoController::class, 'show'])->name('cuenta_bancos.show');

// Ruta para mostrar el formulario de edición de una cuenta bancaria
Route::get('/cuenta-bancos/{id}/edit', [CuentaBancoController::class, 'edit'])->name('cuenta_bancos.edit');

// Ruta para actualizar una cuenta bancaria existente
Route::put('/cuenta-bancos/{id}', [CuentaBancoController::class, 'update'])->name('cuenta_bancos.update');

// Ruta para eliminar una cuenta bancaria
Route::delete('/cuenta-bancos/{id}', [CuentaBancoController::class, 'destroy'])->name('cuenta_bancos.destroy');

// Ruta para recargar los datos de una cuenta bancaria (puede ser usada en AJAX)
Route::get('/cuenta-bancos/{id}/reload', [CuentaBancoController::class, 'reload'])->name('cuenta_bancos.reload');

// Ruta para cambiar el estado de una cuenta bancaria (ejemplo: activar/desactivar)
Route::post('/cuenta-bancos/{id}/toggle', [CuentaBancoController::class, 'toggleStatus'])->name('cuenta_bancos.toggle');

// Ruta para visualizar un extracto o transacciones de la cuenta bancaria
Route::get('/cuenta-bancos/{id}/extracto', [CuentaBancoController::class, 'extracto'])->name('cuenta_bancos.extracto');

// Ruta para hacer un depósito en la cuenta bancaria
Route::post('/cuenta-bancos/{id}/deposito', [CuentaBancoController::class, 'depositar'])->name('cuenta_bancos.depositar');

// Ruta para hacer un retiro de la cuenta bancaria
Route::post('/cuenta-bancos/{id}/retiro', [CuentaBancoController::class, 'retirar'])->name('cuenta_bancos.retirar');

// Ruta para listar todas las cuentas bancarias
Route::get('/control-cuentas', [ControlCuentaController::class, 'index'])->name('control_cuentas.index');

// Ruta para mostrar el formulario de creación de una nueva cuenta bancaria
Route::get('/control-cuentas/create', [ControlCuentaController::class, 'create'])->name('control_cuentas.create');

// Ruta para almacenar una nueva cuenta bancaria
Route::post('/control-cuentas', [ControlCuentaController::class, 'store'])->name('control_cuentas.store');

// Ruta para mostrar los detalles de una cuenta bancaria específica
Route::get('/control-cuentas/{id}', [ControlCuentaController::class, 'show'])->name('control_cuentas.show');

// Ruta para la visualización de un servicio pendiente
Route::get('/control-cuentas/show/{id}', [ControlCuentaController::class, 'show'])->name('control_cuentas.show');

// Rutas para manejar gastos
Route::get('/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index'); // Lista de gastos

// Rutas de recursos para gastos
Route::resource('presupuestos', PresupuestoController::class);

// Ruta para mostrar el formulario de edición de un presupuesto
Route::get('/presupuestos/{id}/edit', [PresupuestoController::class, 'edit'])->name('presupuestos.edit');

// Ruta para actualizar un presupuesto existente
Route::put('/presupuestos/{id}', [PresupuestoController::class, 'update'])->name('presupuestos.update');
