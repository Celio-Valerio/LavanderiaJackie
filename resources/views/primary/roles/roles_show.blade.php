@extends('layouts.principal')
@section('title', 'Registrar rol')
@section('content')
    <style>
        .card {
            background-image: url('{{ asset('assets/img/laundry-background.jpg') }}');
            background-size: fill;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.76);
            border-radius: 15px;
            transition: background-color 0.3s ease;
        }

        .card-title {
            font-size: 30px !important;
            color: #333;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .info-label {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .info-value {
            font-size: 20px;
            font-weight: 500;
            color: #333;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 20px;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }

        .form-check-input:checked {
            background-color: #0d6efd; /* azul Bootstrap */
            border-color: #0d6efd;
        }

        .form-check-input {
            width: 2.5rem;
            height: 1.4rem;
            cursor: pointer;
            border: 1px solid #6c757d;
            background-color: #dee2e6;
            transition: all 0.2s ease-in-out;
        }

        .form-check-label {
            color: #000 !important;
            font-weight: 500;
        }

        h1, h2, label {
            color: #000 !important;
        }

        .permiso-section {
            border: 1px solid #ced4da;
            padding: 1.2rem;
            border-radius: 10px;
            background-color: #f8f9fa;
            margin-bottom: 1.5rem;
        }

        .switch-lg {
            width: 3.5rem;
            height: 1.7rem;
        }

        .switch-lg:checked {
            background-color: #0d6efd;
        }

        .switch-lg:focus {
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        }

        .switch-lg::before {
            width: 1.4rem;
            height: 1.4rem;
            transform: translateX(0.15rem);
        }

        .switch-lg:checked::before {
            transform: translateX(2rem);
        }

        .estado-franja {
            width: 8px;
            border-radius: 2px;
        }
    </style>

    <section class="section">
        @if($usuario->rolpermiso->nombre == 'Administrador')
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h1 class="card-title mb-4" style="font-size: 30px;">Detalles del rol</h1>
                            <!-- DATOS DEL ROL -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                                <h2 style="font-size: 22px; margin: 0;">Datos del rol</h2>
                            </div>
                            <hr>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Nombre del rol:</label>
                                    <div class="bg-white p-2 px-3 border rounded shadow-sm">
                                        {{ $rol->nombre }}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Fecha de creación:</label>
                                    <div class="bg-white p-2 px-3 border rounded shadow-sm">
                                        {{ \Carbon\Carbon::parse($rol->fecha)->translatedFormat('l d \d\e F, Y') }}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Estado:</label>
                                    <div class="d-flex align-items-stretch bg-white border rounded shadow-sm p-2 px-3">
                                        <div class="estado-franja me-2 {{ strtolower($rol->estado) === 'activo' ? 'bg-success' : 'bg-danger' }}"></div>
                                        <div class="d-flex align-items-center"><span>{{ ucfirst($rol->estado) }}</span></div>
                                    </div>
                                </div>
                            </div>



                            <!-- PERMISOS -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                                <h2 style="font-size: 22px; margin: 0;">Permisos del rol</h2>
                            </div>


                            <hr>

                            <!-- CLIENTES -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="clientes_lista">Clientes</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="clientes_lista" name="clientes_lista" value="1"
                                           {{ isset($rol) && $rol->clientes_lista ? 'checked' : (old('clientes_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="clientes_crear">Registrar cliente</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="clientes_crear" name="clientes_crear" value="1"
                                                   {{ isset($rol) && $rol->clientes_crear ? 'checked' : (old('clientes_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="clientes_ver">Mostrar cliente</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="clientes_ver" name="clientes_ver" value="1"
                                                   {{ isset($rol) && $rol->clientes_ver ? 'checked' : (old('clientes_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="clientes_editar">Editar cliente</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="clientes_editar" name="clientes_editar" value="1"
                                                   {{ isset($rol) && $rol->clientes_editar ? 'checked' : (old('clientes_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- COMPRAS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="compras_lista">Compras</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="compras_lista" name="compras_lista" value="1"
                                           {{ isset($rol) && $rol->compras_lista ? 'checked' : (old('compras_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="compras_crear">Registrar compras</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="compras_crear" name="compras_crear" value="1"
                                                   {{ isset($rol) && $rol->compras_crear ? 'checked' : (old('compras_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="compras_ver">Mostrar compras</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="compras_ver" name="compras_ver" value="1"
                                                   {{ isset($rol) && $rol->compras_ver ? 'checked' : (old('compras_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- CUENTAS DE BANCO -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="bancos_lista">Cuentas de banco</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="bancos_lista" name="bancos_lista" value="1"
                                           {{ isset($rol) && $rol->bancos_lista ? 'checked' : (old('bancos_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="bancos_crear">Registrar cuentas</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="bancos_crear" name="bancos_crear" value="1"
                                                   {{ isset($rol) && $rol->bancos_crear ? 'checked' : (old('bancos_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="bancos_ver">Mostrar cuentas</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="bancos_ver" name="bancos_ver" value="1"
                                                   {{ isset($rol) && $rol->bancos_ver ? 'checked' : (old('bancos_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CUPONES -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="cupones_lista">Cupones</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="cupones_lista" name="cupones_lista" value="1"
                                           {{ isset($rol) && $rol->cupones_lista ? 'checked' : (old('cupones_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cupones_crear">Registrar cupones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cupones_crear" name="cupones_crear" value="1"
                                                   {{ isset($rol) && $rol->cupones_crear ? 'checked' : (old('cupones_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cupones_ver">Mostrar cupones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cupones_ver" name="cupones_ver" value="1"
                                                   {{ isset($rol) && $rol->cupones_ver ? 'checked' : (old('cupones_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cupones_ver_perdiente">Cupones pendientes</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cupones_ver_perdiente" name="cupones_ver_perdiente" value="1"
                                                   {{ isset($rol) && $rol->cupones_ver_perdiente ? 'checked' : (old('cupones_ver_perdiente') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cupones_imprimir">Imprimir cupones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cupones_imprimir" name="cupones_imprimir" value="1"
                                                   {{ isset($rol) && $rol->cupones_imprimir ? 'checked' : (old('cupones_imprimir') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cupones_pdf">Descargar PDF</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cupones_pdf" name="cupones_pdf" value="1"
                                                   {{ isset($rol) && $rol->cupones_pdf ? 'checked' : (old('cupones_pdf') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CUPONES VENCIDOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="cuponesvencidos_lista">Cupones vencidos</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="cuponesvencidos_lista" name="cuponesvencidos_lista" value="1"
                                           {{ isset($rol) && $rol->cuponesvencidos_lista ? 'checked' : (old('cuponesvencidos_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cuponesvencidos_crear">Registrar vencidos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cuponesvencidos_crear" name="cuponesvencidos_crear" value="1"
                                                   {{ isset($rol) && $rol->cuponesvencidos_crear ? 'checked' : (old('cuponesvencidos_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="cuponesvencidos_ver">Mostrar vencidos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cuponesvencidos_ver" name="cuponesvencidos_ver" value="1"
                                                   {{ isset($rol) && $rol->cuponesvencidos_ver ? 'checked' : (old('cuponesvencidos_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- EMPLEADOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="empleados_lista">Empleados</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="empleados_lista" name="empleados_lista" value="1"
                                           {{ isset($rol) && $rol->empleados_lista ? 'checked' : (old('empleados_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="empleados_crear">Registrar empleados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="empleados_crear" name="empleados_crear" value="1"
                                                   {{ isset($rol) && $rol->empleados_crear ? 'checked' : (old('empleados_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="empleados_ver">Mostrar empleados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="empleados_ver" name="empleados_ver" value="1"
                                                   {{ isset($rol) && $rol->empleados_ver ? 'checked' : (old('empleados_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="empleados_editar">Editar empleados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="empleados_editar" name="empleados_editar" value="1"
                                                   {{ isset($rol) && $rol->empleados_editar ? 'checked' : (old('empleados_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="empleados_constancia">Emitir constancia</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="empleados_constancia" name="empleados_constancia" value="1"
                                                   {{ isset($rol) && $rol->empleados_constancia ? 'checked' : (old('empleados_constancia') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- GASTOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="gastos_lista">Gastos</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="gastos_lista" name="gastos_lista" value="1"
                                           {{ isset($rol) && $rol->gastos_lista ? 'checked' : (old('gastos_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="gastos_crear">Registrar gastos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="gastos_crear" name="gastos_crear" value="1"
                                                   {{ isset($rol) && $rol->gastos_crear ? 'checked' : (old('gastos_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="gastos_ver">Mostrar gastos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="gastos_ver" name="gastos_ver" value="1"
                                                   {{ isset($rol) && $rol->gastos_ver ? 'checked' : (old('gastos_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="gastos_editar">Editar gastos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="gastos_editar" name="gastos_editar" value="1"
                                                   {{ isset($rol) && $rol->gastos_editar ? 'checked' : (old('gastos_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="gastos_pdf">Descargar PDF</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="gastos_pdf" name="gastos_pdf" value="1"
                                                   {{ isset($rol) && $rol->gastos_pdf ? 'checked' : (old('gastos_pdf') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- INVENTARIO -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="inventario_lista">Inventario</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="inventario_lista" name="inventario_lista" value="1"
                                           {{ isset($rol) && $rol->inventario_lista ? 'checked' : (old('inventario_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                            </div>


                            <!-- MANTENIMIENTO -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="mantenimiendo_lista">Mantenimiento</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="mantenimiendo_lista" name="mantenimiendo_lista" value="1"
                                           {{ isset($rol) && $rol->mantenimiendo_lista ? 'checked' : (old('mantenimiendo_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="mantenimiendo_crear">Registrar mantenimiento</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="mantenimiendo_crear" name="mantenimiendo_crear" value="1"
                                                   {{ isset($rol) && $rol->mantenimiendo_crear ? 'checked' : (old('mantenimiendo_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="mantenimiendo_ver">Mostrar mantenimiento</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="mantenimiendo_ver" name="mantenimiendo_ver" value="1"
                                                   {{ isset($rol) && $rol->mantenimiendo_ver ? 'checked' : (old('mantenimiendo_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="mantenimiendo_editar">Editar mantenimiento</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="mantenimiendo_editar" name="mantenimiendo_editar" value="1"
                                                   {{ isset($rol) && $rol->mantenimiendo_editar ? 'checked' : (old('mantenimiendo_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MAQUINAS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="maquinas_lista">Máquinas</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="maquinas_lista" name="maquinas_lista" value="1"
                                           {{ isset($rol) && $rol->maquinas_lista ? 'checked' : (old('maquinas_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="maquinas_crear">Registrar máquina</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="maquinas_crear" name="maquinas_crear" value="1"
                                                   {{ isset($rol) && $rol->maquinas_crear ? 'checked' : (old('maquinas_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="maquinas_ver">Mostrar máquina</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="maquinas_ver" name="maquinas_ver" value="1"
                                                   {{ isset($rol) && $rol->maquinas_ver ? 'checked' : (old('maquinas_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="maquinas_editar">Editar máquina</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="maquinas_editar" name="maquinas_editar" value="1"
                                                   {{ isset($rol) && $rol->maquinas_editar ? 'checked' : (old('maquinas_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRESUPUESTO -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="presupuesto_lista">Presupuesto</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_lista" name="presupuesto_lista" value="1"
                                           {{ isset($rol) && $rol->presupuesto_lista ? 'checked' : (old('presupuesto_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="presupuesto_crear">Crear presupuesto</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_crear" name="presupuesto_crear" value="1"
                                                   {{ isset($rol) && $rol->presupuesto_crear ? 'checked' : (old('presupuesto_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="presupuesto_ver">Mostrar presupuesto</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_ver" name="presupuesto_ver" value="1"
                                                   {{ isset($rol) && $rol->presupuesto_ver ? 'checked' : (old('presupuesto_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="presupuesto_editar">Editar presupuesto</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_editar" name="presupuesto_editar" value="1"
                                                   {{ isset($rol) && $rol->presupuesto_editar ? 'checked' : (old('presupuesto_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRODUCTOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="productos_lista">Productos</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="productos_lista" name="productos_lista" value="1"
                                           {{ isset($rol) && $rol->productos_lista ? 'checked' : (old('productos_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="productos_crear">Registrar productos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="productos_crear" name="productos_crear" value="1"
                                                   {{ isset($rol) && $rol->productos_crear ? 'checked' : (old('productos_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="productos_ver">Mostrar productos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="productos_ver" name="productos_ver" value="1"
                                                   {{ isset($rol) && $rol->productos_ver ? 'checked' : (old('productos_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="productos_editar">Editar productos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="productos_editar" name="productos_editar" value="1"
                                                   {{ isset($rol) && $rol->productos_editar ? 'checked' : (old('productos_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- PROMOCIONES -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="promociones_lista">Promociones</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="promociones_lista" name="promociones_lista" value="1"
                                           {{ isset($rol) && $rol->promociones_lista ? 'checked' : (old('promociones_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="promociones_crear">Registrar promociones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="promociones_crear" name="promociones_crear" value="1"
                                                   {{ isset($rol) && $rol->promociones_crear ? 'checked' : (old('promociones_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="promociones_ver">Mostrar promociones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="promociones_ver" name="promociones_ver" value="1"
                                                   {{ isset($rol) && $rol->promociones_ver ? 'checked' : (old('promociones_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="promociones_modo">Modo vista</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="promociones_modo" name="promociones_modo" value="1"
                                                   {{ isset($rol) && $rol->promociones_modo ? 'checked' : (old('promociones_modo') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="promociones_editar">Editar promociones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="promociones_editar" name="promociones_editar" value="1"
                                                   {{ isset($rol) && $rol->promociones_editar ? 'checked' : (old('promociones_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PROVEEDORES -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="proveedores_lista">Proveedores</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="proveedores_lista" name="proveedores_lista" value="1"
                                           {{ isset($rol) && $rol->proveedores_lista ? 'checked' : (old('proveedores_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="proveedores_crear">Registrar proveedor</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="proveedores_crear" name="proveedores_crear" value="1"
                                                   {{ isset($rol) && $rol->proveedores_crear ? 'checked' : (old('proveedores_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="proveedores_ver">Mostrar proveedor</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="proveedores_ver" name="proveedores_ver" value="1"
                                                   {{ isset($rol) && $rol->proveedores_ver ? 'checked' : (old('proveedores_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="proveedores_editar">Editar proveedor</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="proveedores_editar" name="proveedores_editar" value="1"
                                                   {{ isset($rol) && $rol->proveedores_editar ? 'checked' : (old('proveedores_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SERVICIOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="servicios_lista">Servicios</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="servicios_lista" name="servicios_lista" value="1"
                                           {{ isset($rol) && $rol->servicios_lista ? 'checked' : (old('servicios_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="servicios_crear">Registrar servicios</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="servicios_crear" name="servicios_crear" value="1"
                                                   {{ isset($rol) && $rol->servicios_crear ? 'checked' : (old('servicios_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="servicios_ver">Mostrar servicios</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="servicios_ver" name="servicios_ver" value="1"
                                                   {{ isset($rol) && $rol->servicios_ver ? 'checked' : (old('servicios_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="servicios_editar">Editar servicios</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="servicios_editar" name="servicios_editar" value="1"
                                                   {{ isset($rol) && $rol->servicios_editar ? 'checked' : (old('servicios_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SERVICIOS EFECTUADOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="serviciosefectuados_lista">Servicios Efectuados</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_lista" name="serviciosefectuados_lista" value="1"
                                           {{ isset($rol) && $rol->serviciosefectuados_lista ? 'checked' : (old('serviciosefectuados_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciosefectuados_crear">Crear servicio</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_crear" name="serviciosefectuados_crear" value="1"
                                                   {{ isset($rol) && $rol->serviciosefectuados_crear ? 'checked' : (old('serviciosefectuados_crear') ? 'checked' : '') }} disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciosefectuados_ver">Mostrar efectuados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_ver" name="serviciosefectuados_ver" value="1"
                                                   {{ isset($rol) && $rol->serviciosefectuados_ver ? 'checked' : (old('serviciosefectuados_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciosefectuados_imprimir">Imprimir efectuados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_imprimir" name="serviciosefectuados_imprimir" value="1"
                                                   {{ isset($rol) && $rol->serviciosefectuados_imprimir ? 'checked' : (old('serviciosefectuados_imprimir') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciosefectuados_editar">Editar efectuados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_editar" name="serviciosefectuados_editar" value="1"
                                                   {{ isset($rol) && $rol->serviciosefectuados_editar ? 'checked' : (old('serviciosefectuados_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SERVICIOS PENDIENTES -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="serviciospendientes_lista">Servicios Pendientes</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_lista" name="serviciospendientes_lista" value="1"
                                           {{ isset($rol) && $rol->serviciospendientes_lista ? 'checked' : (old('serviciospendientes_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciospendientes_ver">Mostrar pendientes</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_ver" name="serviciospendientes_ver" value="1"
                                                   {{ isset($rol) && $rol->serviciospendientes_ver ? 'checked' : (old('serviciospendientes_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciospendientes_editar">Editar pendientes</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_editar" name="serviciospendientes_editar" value="1"
                                                   {{ isset($rol) && $rol->serviciospendientes_editar ? 'checked' : (old('serviciospendientes_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="serviciospendientes_imprimir">Imprimir pendientes</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_imprimir" name="serviciospendientes_imprimir" value="1"
                                                   {{ isset($rol) && $rol->serviciospendientes_imprimir ? 'checked' : (old('serviciospendientes_imprimir') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- VENTA DE SERVICIOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="ventaservicios_lista">Venta de Servicios</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="ventaservicios_lista" name="ventaservicios_lista" value="1"
                                           {{ isset($rol) && $rol->ventaservicios_lista ? 'checked' : (old('ventaservicios_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="ventaservicios_ver">Mostrar ventas</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="ventaservicios_ver" name="ventaservicios_ver" value="1"
                                                   {{ isset($rol) && $rol->ventaservicios_ver ? 'checked' : (old('ventaservicios_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="ventaservicios_imprimir">Imprimir ventas</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="ventaservicios_imprimir" name="ventaservicios_imprimir" value="1"
                                                   {{ isset($rol) && $rol->ventaservicios_imprimir ? 'checked' : (old('ventaservicios_imprimir') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TRANSACCIONES -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="transacciones_lista">Transacciones</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="transacciones_lista" name="transacciones_lista" value="1"
                                           {{ isset($rol) && $rol->transacciones_lista ? 'checked' : (old('transacciones_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="transacciones_pdf">Descargar PDF</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="transacciones_pdf" name="transacciones_pdf" value="1"
                                                   {{ isset($rol) && $rol->transacciones_pdf ? 'checked' : (old('transacciones_pdf') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="transacciones_ver">Mostrar transacciones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="transacciones_ver" name="transacciones_ver" value="1"
                                                   {{ isset($rol) && $rol->transacciones_ver ? 'checked' : (old('transacciones_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="transacciones_crear">Registrar transacciones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="transacciones_crear" name="transacciones_crear" value="1"
                                                   {{ isset($rol) && $rol->transacciones_crear ? 'checked' : (old('transacciones_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- USUARIOS -->
                            <div class="permiso-section">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check-label fw-bold" for="usuarios_lista">Usuarios</label>
                                    <input class="form-check-input switch-lg" type="checkbox" id="usuarios_lista" name="usuarios_lista" value="1"
                                           {{ isset($rol) && $rol->usuarios_lista ? 'checked' : (old('usuarios_lista') ? 'checked' : '') }} onclick="return false;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="usuarios_crear">Registrar usuario</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="usuarios_crear" name="usuarios_crear" value="1"
                                                   {{ isset($rol) && $rol->usuarios_crear ? 'checked' : (old('usuarios_crear') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="usuarios_ver">Mostrar usuario</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="usuarios_ver" name="usuarios_ver" value="1"
                                                   {{ isset($rol) && $rol->usuarios_ver ? 'checked' : (old('usuarios_ver') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="usuarios_editar">Editar usuario</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="usuarios_editar" name="usuarios_editar" value="1"
                                                   {{ isset($rol) && $rol->usuarios_editar ? 'checked' : (old('usuarios_editar') ? 'checked' : '') }} onclick="return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BOTONES -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('roles.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
                <div class="text-center p-5 bg-white rounded shadow-lg" style="max-width: 600px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/16962/16962145.png"
                         alt="Sin permisos" class="img-fluid mb-4" style="max-height: 250px; border-radius: 10px;">
                    <h2 class="text-danger mb-3">Acceso Denegado</h2>
                    <p class="fs-5">No tienes permisos para acceder a este apartado. Solo los usuarios con rol de <strong>Administrador</strong> pueden ver esta sección.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4 px-4 py-2">Volver al inicio</a>
                </div>
            </div>
        @endif


    </section>
@endsection
