@extends('layouts.principal')
@section('title', 'Detalles del Cliente')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Detalles del Cliente</h1>
                        <hr>

                        <!-- Información del Cliente -->
                        <div class="row mb-3">
                            <!-- Nombre del Cliente (2 columnas en una fila) -->
                            <div class="col-md-6">
                                <label class="form-label"><strong>Nombre completo:</strong></label>
                                <p>{{ $cliente->first_name }} {{ $cliente->last_name }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><strong>Tipo de cliente:</strong></label>
                                <p>
                                    @if ($cliente->type === 'Credito')
                                        Crédito
                                    @else
                                        Contado
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Teléfono (1 columna) -->
                            <div class="col-md-6">
                                <label class="form-label"><strong>Teléfono:</strong></label>
                                <p>{{ $cliente->phone }}</p>
                            </div>

                            <!-- Correo Electrónico (1 columna) -->
                            <div class="col-md-6">
                                @if ($cliente->email)
                                    <label class="form-label"><strong>Correo Electrónico:</strong></label>
                                    <p> {{ $cliente->email }}</p>
                                @else

                                @endif
                            </div>

                        </div>

                        <div class="row mb-3">
                            <!-- Dirección del Cliente (varias filas si es necesario) -->
                            <div class="col-md-12">
                                <label class="form-label"><strong>Dirección:</strong></label>
                                <p>{{ $cliente->address }}</p>
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
        
    </section>
@endsection
