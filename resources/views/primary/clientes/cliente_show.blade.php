@extends('layouts.principal')
@section('title', 'Detalles del Cliente')
@section('content')

<section class="section">
        @if($usuario->rolpermiso->clientes_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Detalles del cliente</h1>
                            <hr>

                            <!-- Información del Cliente -->
                            <div class="row mb-3">
                                <!-- Nombre del Cliente (2 columnas en una fila) -->
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Nombre completo:</strong> {{ $cliente->first_name }} {{ $cliente->last_name }}</label>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Tipo de cliente:</strong>
                                        @if ($cliente->type === 'Credito')
                                            Crédito
                                        @else
                                            Contado
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Teléfono (1 columna) -->
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Teléfono:</strong> {{ $cliente->phone }}</label>
                                </div>

                                <!-- Correo Electrónico (1 columna) -->
                                <div class="col-md-6">
                                    @if ($cliente->email)
                                        <label class="form-label small-text-field"><strong>Correo electrónico:</strong> {{ $cliente->email }}</label>
                                    @else
                                        <label class="form-label small-text-field"><strong>Correo electrónico:</strong> No asignado</label>
                                    @endif
                                </div>

                            </div>

                            <div class="row mb-3">
                                <!-- Dirección del Cliente (varias filas si es necesario) -->
                                <div class="col-md-12">
                                    <label class="form-label small-text-field"><strong>Dirección:</strong> {{ $cliente->address }}</label>
                                </div>
                            </div>

                            <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning w-100">Editar Cliente</a>
                                </div>
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
                    <p class="fs-5">No tienes permisos para acceder a este apartado.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4 px-4 py-2">Volver al inicio</a>
                </div>
            </div>
        @endif


    </section>
@endsection
