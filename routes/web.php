<?php

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

// Rutas para manejar empleados
Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index'); // Lista de empleados

// Rutas de recursos para empleados
Route::resource('empleados', EmpleadoController::class);

// Rutas para manejar proveedores
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index'); // Lista de proveedores

// Rutas de recursos para proveedores
Route::resource('proveedores', ProveedorController::class);

