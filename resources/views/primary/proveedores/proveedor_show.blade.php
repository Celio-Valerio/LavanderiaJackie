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

                        <!-- Información de la Empresa -->
                        <div class="row mb-3">
                            <!-- Nombre de la Empresa -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Nombre de la Empresa:</strong></label>
                                <p class="small-text-field">{{ $proveedor->company_name }}</p>
                            </div>

                            <!-- Teléfono de la Empresa -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Teléfono:</strong></label>
                                <p class="small-text-field">{{ $proveedor->company_phone }}</p>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="col-md-4">
                                @if ($proveedor->email)
                                    <label class="form-label"><strong>Correo Electrónico:</strong></label>
                                    <p class="small-text-field">{{ $proveedor->email }}</p>
                                @else
                                    <label class="form-label"><strong>Correo Electrónico:</strong></label>
                                    <p>No disponible</p>
                                @endif
                            </div>
                        </div>

                        <!-- Información del Proveedor -->
                        <div class="row mb-3">
                            <!-- Nombre del Proveedor -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Nombre del Vendedor:</strong></label>
                                <p class="small-text-field">{{ $proveedor->full_name }}</p>
                            </div>

                            <!-- Teléfono del Proveedor -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Teléfono:</strong></label>
                                <p class="small-text-field">{{ $proveedor->phone }}</p>
                            </div>

                            <!-- Categoria -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Categoria:</strong></label>
                                <p class="small-text-field">{{ $proveedor->categoria->name ?? 'No asignada' }}</p> <!-- Muestra el nombre de la categoria, si está asignado -->
                            </div>
                        </div>


                        <div class="row mb-3">
                            <!-- Departamento -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Departamento:</strong></label>
                                <p class="small-text-field">{{ $proveedor->city ?? 'No asignada' }}</p> <!-- Muestra el nombre de la categoria, si está asignado -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Dirección del Proveedor (varias filas si es necesario) -->
                            <div class="col-md-12">
                                <label class="form-label"><strong>Dirección:</strong></label>
                                <p class="small-text-field">{{ $proveedor->company_address }}, {{ $proveedor->city }}.</p>
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
