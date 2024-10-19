<?php

use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\MaquinariaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;

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

