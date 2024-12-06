<?php

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
use App\Http\Controllers\GastoController;

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
