@extends('layouts.principal')
@section('title', 'Detalles del Proveedor')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Detalles del Proveedor</h1>
                        <hr>

                        <!-- Información del Proveedor -->
                        <div class="row mb-3">
                            <!-- Nombre del Proveedor -->
                            <div class="col-md-8">
                                <label class="form-label"><strong>Nombre del Proveedor:</strong></label>
                                <p>{{ $proveedor->full_name }}</p>
                            </div>

                            <!-- Teléfono del Proveedor -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Teléfono del Proveedor:</strong></label>
                                <p>{{ $proveedor->phone }}</p>
                            </div>
                        </div>

                        <!-- Información de la Empresa -->
                        <div class="row mb-3">
                            <!-- Nombre de la Empresa -->
                            <div class="col-md-8">
                                <label class="form-label"><strong>Nombre de la Empresa:</strong></label>
                                <p>{{ $proveedor->company_name }}</p>
                            </div>

                            <!-- Teléfono de la Empresa -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Teléfono de la Empresa:</strong></label>
                                <p>{{ $proveedor->company_phone }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Correo Electrónico (1 columna) -->
                            <div class="col-md-6">
                                @if ($proveedor->email)
                                    <label class="form-label"><strong>Correo Electrónico:</strong></label>
                                    <p>{{ $proveedor->email }}</p>
                                @else
                                    <label class="form-label"><strong>Correo Electrónico:</strong></label>
                                    <p>No disponible</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Dirección del Proveedor (varias filas si es necesario) -->
                            <div class="col-md-12">
                                <label class="form-label"><strong>Dirección:</strong></label>
                                <p>{{ $proveedor->company_address }}</p>
                            </div>
                        </div>

                        <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning w-100">Editar Proveedor</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
