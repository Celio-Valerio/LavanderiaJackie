@extends('layouts.principal')
@section('title', 'Registrar rol')
@section('content')
    <style>
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
    </style>



    <section class="section">
        @if($usuario->rolpermiso->nombre == 'Administrador')
            <div class="row">
                <div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h1 class="card-title mb-4" style="font-size: 30px;">Registrar rol</h1>
                            <form id="gastoForm" action="{{ isset($rol) ? route('roles.update', $rol->id) : route('roles.store') }}" method="POST" novalidate>
                                @csrf
                                @if(isset($rol))
                                    @method('put')
                                @endif

                                <!-- DATOS DEL ROL -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                                    <h2 style="font-size: 22px; margin: 0;">Datos del rol</h2>
                                </div>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre del rol</label>
                                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ isset($rol) ? $rol->nombre : old('nombre') }}" placeholder="Ej: Administrador" maxlength="50">
                                        @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- PERMISOS -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                                    <h2 style="font-size: 22px; margin: 0;">Permisos del rol</h2>
                                    <div class="form-check form-switch d-flex align-items-center" style="gap: 10px; margin: 0;">
                                        <label class="form-check-label" for="todos" style="margin: 0;">Seleccionar todos</label>
                                        <input style="margin-left: 20px" class="form-check-input switch-lg" type="checkbox" role="switch" id="todos" name="todos" value="1"
                                            {{ old('todos') ? 'checked' : '' }}>
                                    </div>
                                </div>


                                <hr>

                                <div class="row" style="margin: 10px">
                                    <!-- CLIENTES -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="clientes_lista">Clientes</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="clientes_lista" name="clientes_lista" value="1"
                                                   {{ isset($rol) && $rol->clientes_lista ? 'checked' : (old('clientes_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="clientes_crear" name="clientes_crear" value="1"
                                                               {{ isset($rol) && $rol->clientes_crear ? 'checked' : (old('clientes_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="clientes_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="clientes_ver" name="clientes_ver" value="1"
                                                               {{ isset($rol) && $rol->clientes_ver ? 'checked' : (old('clientes_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="clientes_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="clientes_editar" name="clientes_editar" value="1"
                                                               {{ isset($rol) && $rol->clientes_editar ? 'checked' : (old('clientes_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="clientes_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- COMPRAS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="compras_lista">Compras</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="compras_lista" name="compras_lista" value="1"
                                                   {{ isset($rol) && $rol->compras_lista ? 'checked' : (old('compras_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="compras_crear" name="compras_crear" value="1"
                                                               {{ isset($rol) && $rol->compras_crear ? 'checked' : (old('compras_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="compras_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="compras_ver" name="compras_ver" value="1"
                                                               {{ isset($rol) && $rol->compras_ver ? 'checked' : (old('compras_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="compras_ver">Mostrar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- CUENTAS DE BANCO -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="bancos_lista">Cuentas de banco</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="bancos_lista" name="bancos_lista" value="1"
                                                   {{ isset($rol) && $rol->bancos_lista ? 'checked' : (old('bancos_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="bancos_crear" name="bancos_crear" value="1"
                                                               {{ isset($rol) && $rol->bancos_crear ? 'checked' : (old('bancos_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label" for="bancos_crear">Registrar</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="bancos_ver" name="bancos_ver" value="1"
                                                               {{ isset($rol) && $rol->bancos_ver ? 'checked' : (old('bancos_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label" for="bancos_ver">Mostrar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row" style="margin: 10px">
                                    <!-- CUPONES -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="cupones_lista">Cupones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cupones_lista" name="cupones_lista" value="1"
                                                   {{ isset($rol) && $rol->cupones_lista ? 'checked' : (old('cupones_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cupones_crear" name="cupones_crear" value="1"
                                                               {{ isset($rol) && $rol->cupones_crear ? 'checked' : (old('cupones_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cupones_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cupones_ver" name="cupones_ver" value="1"
                                                               {{ isset($rol) && $rol->cupones_ver ? 'checked' : (old('cupones_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cupones_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cupones_ver_perdiente" name="cupones_ver_perdiente" value="1"
                                                               {{ isset($rol) && $rol->cupones_ver_perdiente ? 'checked' : (old('cupones_ver_perdiente') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cupones_ver_perdiente">Cupones pendientes</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cupones_imprimir" name="cupones_imprimir" value="1"
                                                               {{ isset($rol) && $rol->cupones_imprimir ? 'checked' : (old('cupones_imprimir') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cupones_imprimir">Imprimir</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cupones_pdf" name="cupones_pdf" value="1"
                                                               {{ isset($rol) && $rol->cupones_pdf ? 'checked' : (old('cupones_pdf') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cupones_pdf">Descargar PDF</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CUPONES VENCIDOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="cuponesvencidos_lista">Cupones vencidos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="cuponesvencidos_lista" name="cuponesvencidos_lista" value="1"
                                                   {{ isset($rol) && $rol->cuponesvencidos_lista ? 'checked' : (old('cuponesvencidos_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cuponesvencidos_crear" name="cuponesvencidos_crear" value="1"
                                                               {{ isset($rol) && $rol->cuponesvencidos_crear ? 'checked' : (old('cuponesvencidos_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cuponesvencidos_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="cuponesvencidos_ver" name="cuponesvencidos_ver" value="1"
                                                               {{ isset($rol) && $rol->cuponesvencidos_ver ? 'checked' : (old('cuponesvencidos_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="cuponesvencidos_ver">Mostrar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EMPLEADOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="empleados_lista">Empleados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="empleados_lista" name="empleados_lista" value="1"
                                                   {{ isset($rol) && $rol->empleados_lista ? 'checked' : (old('empleados_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="empleados_crear" name="empleados_crear" value="1"
                                                               {{ isset($rol) && $rol->empleados_crear ? 'checked' : (old('empleados_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="empleados_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="empleados_ver" name="empleados_ver" value="1"
                                                               {{ isset($rol) && $rol->empleados_ver ? 'checked' : (old('empleados_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="empleados_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="empleados_editar" name="empleados_editar" value="1"
                                                               {{ isset($rol) && $rol->empleados_editar ? 'checked' : (old('empleados_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="empleados_editar">Editar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="empleados_constancia" name="empleados_constancia" value="1"
                                                               {{ isset($rol) && $rol->empleados_constancia ? 'checked' : (old('empleados_constancia') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="empleados_constancia">Emitir constancia</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row" style="margin: 10px">
                                    <!-- GASTOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="gastos_lista">Gastos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="gastos_lista" name="gastos_lista" value="1"
                                                   {{ isset($rol) && $rol->gastos_lista ? 'checked' : (old('gastos_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="gastos_crear" name="gastos_crear" value="1"
                                                               {{ isset($rol) && $rol->gastos_crear ? 'checked' : (old('gastos_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="gastos_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="gastos_ver" name="gastos_ver" value="1"
                                                               {{ isset($rol) && $rol->gastos_ver ? 'checked' : (old('gastos_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="gastos_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="gastos_editar" name="gastos_editar" value="1"
                                                               {{ isset($rol) && $rol->gastos_editar ? 'checked' : (old('gastos_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="gastos_editar">Editar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="gastos_pdf" name="gastos_pdf" value="1"
                                                               {{ isset($rol) && $rol->gastos_pdf ? 'checked' : (old('gastos_pdf') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="gastos_pdf">Descargar PDF</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- INVENTARIO -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="inventario_lista">Inventario</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="inventario_lista" name="inventario_lista" value="1"
                                                {{ isset($rol) && $rol->inventario_lista ? 'checked' : (old('inventario_lista') ? 'checked' : '') }}>
                                        </div>
                                    </div>


                                    <!-- MANTENIMIENTO -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="mantenimiendo_lista">Mantenimiento</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="mantenimiendo_lista" name="mantenimiendo_lista" value="1"
                                                   {{ isset($rol) && $rol->mantenimiendo_lista ? 'checked' : (old('mantenimiendo_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="mantenimiento_crear" name="mantenimiento_crear" value="1"
                                                               {{ isset($rol) && $rol->mantenimiento_crear ? 'checked' : (old('mantenimiento_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="mantenimiento_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="mantenimiento_ver" name="mantenimiento_ver" value="1"
                                                               {{ isset($rol) && $rol->mantenimiento_ver ? 'checked' : (old('mantenimiento_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="mantenimiento_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="mantenimiento_editar" name="mantenimiento_editar" value="1"
                                                               {{ isset($rol) && $rol->mantenimiento_editar ? 'checked' : (old('mantenimiento_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="mantenimiento_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin: 10px">
                                    <!-- MAQUINAS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="maquinas_lista">Máquinas</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="maquinas_lista" name="maquinas_lista" value="1"
                                                   {{ isset($rol) && $rol->maquinas_lista ? 'checked' : (old('maquinas_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="maquinas_crear" name="maquinas_crear" value="1"
                                                               {{ isset($rol) && $rol->maquinas_crear ? 'checked' : (old('maquinas_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="maquinas_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="maquinas_ver" name="maquinas_ver" value="1"
                                                               {{ isset($rol) && $rol->maquinas_ver ? 'checked' : (old('maquinas_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="maquinas_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="maquinas_editar" name="maquinas_editar" value="1"
                                                               {{ isset($rol) && $rol->maquinas_editar ? 'checked' : (old('maquinas_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="maquinas_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- PRESUPUESTO -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="presupuesto_lista">Presupuesto</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_lista" name="presupuesto_lista" value="1"
                                                   {{ isset($rol) && $rol->presupuesto_lista ? 'checked' : (old('presupuesto_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_crear" name="presupuesto_crear" value="1"
                                                               {{ isset($rol) && $rol->presupuesto_crear ? 'checked' : (old('presupuesto_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="presupuesto_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_ver" name="presupuesto_ver" value="1"
                                                               {{ isset($rol) && $rol->presupuesto_ver ? 'checked' : (old('presupuesto_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="presupuesto_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="presupuesto_editar" name="presupuesto_editar" value="1"
                                                               {{ isset($rol) && $rol->presupuesto_editar ? 'checked' : (old('presupuesto_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="presupuesto_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- PRODUCTOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="productos_lista">Productos</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="productos_lista" name="productos_lista" value="1"
                                                   {{ isset($rol) && $rol->productos_lista ? 'checked' : (old('productos_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="productos_crear" name="productos_crear" value="1"
                                                               {{ isset($rol) && $rol->productos_crear ? 'checked' : (old('productos_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="productos_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="productos_ver" name="productos_ver" value="1"
                                                               {{ isset($rol) && $rol->productos_ver ? 'checked' : (old('productos_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="productos_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="productos_editar" name="productos_editar" value="1"
                                                               {{ isset($rol) && $rol->productos_editar ? 'checked' : (old('productos_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="productos_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row" style="margin: 10px">
                                    <!-- PROMOCIONES -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="promociones_lista">Promociones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="promociones_lista" name="promociones_lista" value="1"
                                                   {{ isset($rol) && $rol->promociones_lista ? 'checked' : (old('promociones_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="promociones_crear" name="promociones_crear" value="1"
                                                               {{ isset($rol) && $rol->promociones_crear ? 'checked' : (old('promociones_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="promociones_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="promociones_ver" name="promociones_ver" value="1"
                                                               {{ isset($rol) && $rol->promociones_ver ? 'checked' : (old('promociones_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="promociones_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="promociones_modo" name="promociones_modo" value="1"
                                                               {{ isset($rol) && $rol->promociones_modo ? 'checked' : (old('promociones_modo') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="promociones_modo">Modo vista</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="promociones_editar" name="promociones_editar" value="1"
                                                               {{ isset($rol) && $rol->promociones_editar ? 'checked' : (old('promociones_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="promociones_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- PROVEEDORES -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="proveedores_lista">Proveedores</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="proveedores_lista" name="proveedores_lista" value="1"
                                                   {{ isset($rol) && $rol->proveedores_lista ? 'checked' : (old('proveedores_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="proveedores_crear" name="proveedores_crear" value="1"
                                                               {{ isset($rol) && $rol->proveedores_crear ? 'checked' : (old('proveedores_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="proveedores_crear">Registrar</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="proveedores_ver" name="proveedores_ver" value="1"
                                                               {{ isset($rol) && $rol->proveedores_ver ? 'checked' : (old('proveedores_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="proveedores_ver">Mostrar</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="proveedores_editar" name="proveedores_editar" value="1"
                                                               {{ isset($rol) && $rol->proveedores_editar ? 'checked' : (old('proveedores_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="proveedores_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SERVICIOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="servicios_lista">Servicios</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="servicios_lista" name="servicios_lista" value="1"
                                                   {{ isset($rol) && $rol->servicios_lista ? 'checked' : (old('servicios_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="proveedores_crear" name="proveedores_crear" value="1"
                                                               {{ isset($rol) && $rol->proveedores_crear ? 'checked' : (old('proveedores_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="proveedores_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="proveedores_ver" name="proveedores_ver" value="1"
                                                               {{ isset($rol) && $rol->proveedores_ver ? 'checked' : (old('proveedores_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="proveedores_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="proveedores_editar" name="proveedores_editar" value="1"
                                                               {{ isset($rol) && $rol->proveedores_editar ? 'checked' : (old('proveedores_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="proveedores_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row" style="margin: 10px">
                                    <!-- SERVICIOS EFECTUADOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="serviciosefectuados_lista">Servicios Efectuados</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_lista" name="serviciosefectuados_lista" value="1"
                                                   {{ isset($rol) && $rol->serviciosefectuados_lista ? 'checked' : (old('serviciosefectuados_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_crear" name="serviciosefectuados_crear" value="1"
                                                               {{ isset($rol) && $rol->serviciosefectuados_crear ? 'checked' : (old('serviciosefectuados_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciosefectuados_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_ver" name="serviciosefectuados_ver" value="1"
                                                               {{ isset($rol) && $rol->serviciosefectuados_ver ? 'checked' : (old('serviciosefectuados_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciosefectuados_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_imprimir" name="serviciosefectuados_imprimir" value="1"
                                                               {{ isset($rol) && $rol->serviciosefectuados_imprimir ? 'checked' : (old('serviciosefectuados_imprimir') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciosefectuados_imprimir">Imprimir</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciosefectuados_editar" name="serviciosefectuados_editar" value="1"
                                                               {{ isset($rol) && $rol->serviciosefectuados_editar ? 'checked' : (old('serviciosefectuados_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciosefectuados_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- SERVICIOS PENDIENTES -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="serviciospendientes_lista">Servicios Pendientes</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_lista" name="serviciospendientes_lista" value="1"
                                                   {{ isset($rol) && $rol->serviciospendientes_lista ? 'checked' : (old('serviciospendientes_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_ver" name="serviciospendientes_ver" value="1"
                                                               {{ isset($rol) && $rol->serviciospendientes_ver ? 'checked' : (old('serviciospendientes_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciospendientes_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_editar" name="serviciospendientes_editar" value="1"
                                                               {{ isset($rol) && $rol->serviciospendientes_editar ? 'checked' : (old('serviciospendientes_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciospendientes_editar">Editar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="serviciospendientes_imprimir" name="serviciospendientes_imprimir" value="1"
                                                               {{ isset($rol) && $rol->serviciospendientes_imprimir ? 'checked' : (old('serviciospendientes_imprimir') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="serviciospendientes_imprimir">Imprimir</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- VENTA DE SERVICIOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="ventaservicios_lista">Venta de Servicios</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="ventaservicios_lista" name="ventaservicios_lista" value="1"
                                                   {{ isset($rol) && $rol->ventaservicios_lista ? 'checked' : (old('ventaservicios_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="ventaservicios_ver" name="ventaservicios_ver" value="1"
                                                               {{ isset($rol) && $rol->ventaservicios_ver ? 'checked' : (old('ventaservicios_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="ventaservicios_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="ventaservicios_imprimir" name="ventaservicios_imprimir" value="1"
                                                               {{ isset($rol) && $rol->ventaservicios_imprimir ? 'checked' : (old('ventaservicios_imprimir') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="ventaservicios_imprimir">Imprimir</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row" style="margin: 10px">
                                    <!-- TRANSACCIONES -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="transacciones_lista">Transacciones</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="transacciones_lista" name="transacciones_lista" value="1"
                                                   {{ isset($rol) && $rol->transacciones_lista ? 'checked' : (old('transacciones_lista') ? 'checked' : '') }} onchange="cambio(this)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="transacciones_pdf" name="transacciones_pdf" value="1"
                                                               {{ isset($rol) && $rol->transacciones_pdf ? 'checked' : (old('transacciones_pdf') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="transacciones_pdf">Descargar PDF</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="transacciones_ver" name="transacciones_ver" value="1"
                                                               {{ isset($rol) && $rol->transacciones_ver ? 'checked' : (old('transacciones_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="transacciones_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="transacciones_crear" name="transacciones_crear" value="1"
                                                               {{ isset($rol) && $rol->transacciones_crear ? 'checked' : (old('transacciones_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="transacciones_crear">Registrar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- USUARIOS -->
                                    <div class="permiso-section col-4">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-check-label fw-bold" for="usuarios_lista">Usuarios</label>
                                            <input class="form-check-input switch-lg" type="checkbox" id="usuarios_lista" name="usuarios_lista" value="1"
                                                {{ isset($rol) && $rol->usuarios_lista ? 'checked' : (old('usuarios_lista') ? 'checked' : '') }}>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="usuarios_crear" name="usuarios_crear" value="1"
                                                               {{ isset($rol) && $rol->usuarios_crear ? 'checked' : (old('usuarios_crear') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="usuarios_crear">Registrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="usuarios_ver" name="usuarios_ver" value="1"
                                                               {{ isset($rol) && $rol->usuarios_ver ? 'checked' : (old('usuarios_ver') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="usuarios_ver">Mostrar</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="width: 100%;">
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input switch-lg" type="checkbox" id="usuarios_editar" name="usuarios_editar" value="1"
                                                               {{ isset($rol) && $rol->usuarios_editar ? 'checked' : (old('usuarios_editar') ? 'checked' : '') }} disabled>
                                                    </div>
                                                    <label class="form-check-label mb-0" for="usuarios_editar">Editar</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- BOTONES -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-primary flex-fill me-2">Registrar</button>
                                    <button type="button" class="btn btn-warning flex-fill me-2" id="clearButton">Limpiar</button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                                </div>
                            </form>
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

        <script>
            function toggleSubPermisos(listaId, subPermisosIds) {
                var listaCheckbox = document.getElementById(listaId);

                subPermisosIds.forEach(function(id) {
                    var checkbox = document.getElementById(id);
                    if (listaCheckbox && checkbox) {
                        if (listaCheckbox.checked) {
                            checkbox.disabled = false;
                        } else {
                            checkbox.disabled = true;
                            checkbox.checked = false;
                        }
                    }
                });
            }

            // Llamadas por cada grupo:
            document.getElementById('bancos_lista').addEventListener('change', function() {
                toggleSubPermisos('bancos_lista', ['bancos_crear', 'bancos_ver']);
            });

            document.getElementById('transacciones_lista').addEventListener('change', function() {
                toggleSubPermisos('transacciones_lista', ['transacciones_pdf', 'transacciones_ver', 'transacciones_crear']);
            });

            document.getElementById('cupones_lista').addEventListener('change', function() {
                toggleSubPermisos('cupones_lista', ['cupones_crear', 'cupones_ver', 'cupones_ver_perdiente', 'cupones_imprimir', 'cupones_pdf']);
            });

            document.getElementById('cuponesvencidos_lista').addEventListener('change', function() {
                toggleSubPermisos('cuponesvencidos_lista', ['cuponesvencidos_crear', 'cuponesvencidos_ver']);
            });

            document.getElementById('productos_lista').addEventListener('change', function() {
                toggleSubPermisos('productos_lista', ['productos_crear', 'productos_ver', 'productos_editar']);
            });

            document.getElementById('promociones_lista').addEventListener('change', function() {
                toggleSubPermisos('promociones_lista', ['promociones_crear', 'promociones_ver', 'promociones_modo', 'promociones_editar']);
            });

            document.getElementById('compras_lista').addEventListener('change', function() {
                toggleSubPermisos('compras_lista', ['compras_crear', 'compras_ver']);
            });

            document.getElementById('gastos_lista').addEventListener('change', function() {
                toggleSubPermisos('gastos_lista', ['gastos_crear', 'gastos_ver', 'gastos_editar', 'gastos_pdf']);
            });

            document.getElementById('inventario_lista').addEventListener('change', function() {
                toggleSubPermisos('inventario_lista', []);
            });

            document.getElementById('presupuesto_lista').addEventListener('change', function() {
                toggleSubPermisos('presupuesto_lista', ['presupuesto_crear', 'presupuesto_ver', 'presupuesto_editar']);
            });

            document.getElementById('servicios_lista').addEventListener('change', function() {
                toggleSubPermisos('servicios_lista', ['servicios_crear', 'servicios_ver', 'servicios_editar']);
            });

            document.getElementById('serviciospendientes_lista').addEventListener('change', function() {
                toggleSubPermisos('serviciospendientes_lista', ['serviciospendientes_ver', 'serviciospendientes_editar', 'serviciospendientes_imprimir']);
            });

            document.getElementById('serviciosefectuados_lista').addEventListener('change', function() {
                toggleSubPermisos('serviciosefectuados_lista', ['serviciosefectuados_ver', 'serviciosefectuados_crear', 'serviciosefectuados_imprimir', 'serviciosefectuados_editar']);
            });

            document.getElementById('ventaservicios_lista').addEventListener('change', function() {
                toggleSubPermisos('ventaservicios_lista', ['ventaservicios_ver', 'ventaservicios_imprimir']);
            });

            document.getElementById('empleados_lista').addEventListener('change', function() {
                toggleSubPermisos('empleados_lista', ['empleados_crear', 'empleados_ver', 'empleados_editar', 'empleados_constancia']);
            });

            document.getElementById('usuarios_lista').addEventListener('change', function() {
                toggleSubPermisos('usuarios_lista', ['usuarios_crear', 'usuarios_ver', 'usuarios_editar']);
            });

            document.getElementById('clientes_lista').addEventListener('change', function() {
                toggleSubPermisos('clientes_lista', ['clientes_crear', 'clientes_ver', 'clientes_editar']);
            });

            document.getElementById('proveedores_lista').addEventListener('change', function() {
                toggleSubPermisos('proveedores_lista', ['proveedores_crear', 'proveedores_ver', 'proveedores_editar']);
            });

            document.getElementById('maquinas_lista').addEventListener('change', function() {
                toggleSubPermisos('maquinas_lista', ['maquinas_crear', 'maquinas_ver', 'maquinas_editar']);
            });

            document.getElementById('mantenimiendo_lista').addEventListener('change', function() {
                toggleSubPermisos('mantenimiendo_lista', ['mantenimiendo_crear', 'mantenimiendo_ver', 'mantenimiendo_editar']);
            });

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Al cargar la página, ejecutar todos los toggles
                toggleSubPermisos('bancos_lista', ['bancos_crear', 'bancos_ver']);
                toggleSubPermisos('transacciones_lista', ['transacciones_pdf', 'transacciones_ver', 'transacciones_crear']);
                toggleSubPermisos('cupones_lista', ['cupones_crear', 'cupones_ver', 'cupones_ver_perdiente', 'cupones_imprimir', 'cupones_pdf']);
                toggleSubPermisos('cuponesvencidos_lista', ['cuponesvencidos_crear', 'cuponesvencidos_ver']);
                toggleSubPermisos('productos_lista', ['productos_crear', 'productos_ver', 'productos_editar']);
                toggleSubPermisos('promociones_lista', ['promociones_crear', 'promociones_ver', 'promociones_modo', 'promociones_editar']);
                toggleSubPermisos('compras_lista', ['compras_crear', 'compras_ver']);
                toggleSubPermisos('gastos_lista', ['gastos_crear', 'gastos_ver', 'gastos_editar', 'gastos_pdf']);
                toggleSubPermisos('inventario_lista', []);
                toggleSubPermisos('presupuesto_lista', ['presupuesto_crear', 'presupuesto_ver', 'presupuesto_editar']);
                toggleSubPermisos('servicios_lista', ['servicios_crear', 'servicios_ver', 'servicios_editar']);
                toggleSubPermisos('serviciospendientes_lista', ['serviciospendientes_ver', 'serviciospendientes_editar', 'serviciospendientes_imprimir']);
                toggleSubPermisos('serviciosefectuados_lista', ['serviciosefectuados_ver','serviciosefectuados_crear', 'serviciosefectuados_imprimir', 'serviciosefectuados_editar']);
                toggleSubPermisos('ventaservicios_lista', ['ventaservicios_ver', 'ventaservicios_imprimir']);
                toggleSubPermisos('empleados_lista', ['empleados_crear', 'empleados_ver', 'empleados_editar', 'empleados_constancia']);
                toggleSubPermisos('usuarios_lista', ['usuarios_crear', 'usuarios_ver', 'usuarios_editar']);
                toggleSubPermisos('clientes_lista', ['clientes_crear', 'clientes_ver', 'clientes_editar']);
                toggleSubPermisos('proveedores_lista', ['proveedores_crear', 'proveedores_ver', 'proveedores_editar']);
                toggleSubPermisos('maquinas_lista', ['maquinas_crear', 'maquinas_ver', 'maquinas_editar']);
                toggleSubPermisos('mantenimiendo_lista', ['mantenimiendo_crear', 'mantenimiendo_ver', 'mantenimiendo_editar']);
            });

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const masterSwitch = document.getElementById('todos');
                const allSwitches = document.querySelectorAll('.form-check-input.switch-lg:not(#todos)');

                masterSwitch.addEventListener('change', function () {
                    allSwitches.forEach(input => {
                        input.checked = masterSwitch.checked;

                        // Si el checkbox pertenece a un principal (como clientes_lista), dispara el cambio
                        if (input.id.endsWith('_lista')) {
                            input.dispatchEvent(new Event('change'));
                        }

                        // Si es subpermiso, habilitarlo o deshabilitarlo
                        if (!input.id.endsWith('_lista')) {
                            input.disabled = !masterSwitch.checked;
                        }
                    });
                });

                // Al cargar la página, simula el cambio si está chequeado
                if (masterSwitch.checked) {
                    masterSwitch.dispatchEvent(new Event('change'));
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const clearButton = document.getElementById('clearButton');
                const masterSwitch = document.getElementById('todos');
                const allSwitches = document.querySelectorAll('.form-check-input.switch-lg:not(#todos)');
                const nombreInput = document.getElementById('nombre');

                clearButton.addEventListener('click', function () {
                    masterSwitch.checked = false;
                    masterSwitch.dispatchEvent(new Event('change'));

                    allSwitches.forEach(input => {
                        input.checked = false;

                        if (!input.id.endsWith('_lista')) {
                            input.disabled = true;
                        }

                        if (input.id.endsWith('_lista')) {
                            input.dispatchEvent(new Event('change'));
                        }
                    });
                    if (nombreInput) {
                        nombreInput.value = '';
                    }
                });
            });
        </script>


    </section>
@endsection
