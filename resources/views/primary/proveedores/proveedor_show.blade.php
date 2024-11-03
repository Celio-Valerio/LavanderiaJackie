@extends('layouts.principal')
@section('title', 'Detalles del Proveedor')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Detalles del proveedor</h1>
                        <hr>

                        <!-- Información de la Empresa -->
                        <div class="row mb-3">
                            <!-- Nombre de la Empresa -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Nombre de la empresa:</strong> {{ $proveedor->company_name }}</label>
                            </div>

                            <!-- Teléfono de la Empresa -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Teléfono de la empresa:</strong> {{ $proveedor->company_phone }}</label>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="col-md-4">
                                @if ($proveedor->email)
                                    <label class="form-label small-text-field"><strong>Correo electrónico:</strong> {{ $proveedor->email }}</label>
                                @else
                                    <label class="form-label small-text-field"><strong>Correo electrónico:</strong> No disponible</label>
                                @endif
                            </div>
                        </div>

                        <!-- Información del Proveedor -->
                        <div class="row mb-3">
                            <!-- Nombre del Proveedor -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Nombre del vendedor:</strong> {{ $proveedor->full_name }}</label>
                            </div>

                            <!-- Teléfono del Proveedor -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Teléfono del vendedor:</strong> {{ $proveedor->phone }}</label>
                            </div>

                            <!-- Categoria -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Categoria:</strong> {{ $proveedor->categoria->name ?? 'No asignada' }}</label>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <!-- Departamento -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Departamento:</strong> {{ $proveedor->city ?? 'No asignada' }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Dirección del Proveedor (varias filas si es necesario) -->
                            <div class="col-md-12">
                                <label class="form-label small-text-field"><strong>Dirección:</strong> {{ $proveedor->company_address }}.</label>
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
