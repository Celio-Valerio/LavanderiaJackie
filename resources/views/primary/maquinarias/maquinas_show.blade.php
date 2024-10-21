@extends('layouts.principal')
@section('title', 'Detalles de la máquina')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <h1 class="card-title" style="font-size: 30px !important;">Detalles de la máquina</h1>
                        <hr>

                        <!-- Información de la Máquina -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Nombre:</strong></label>
                                <p>{{ $maquina->nombre }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Modelo:</strong></label>
                                <p>{{ $maquina->modelo }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Capacidad:</strong></label>
                                <p>{{ $maquina->capacidad }}</p>
                            </div>

                            

                            <div class="col-md-4">
                                <label class="form-label"><strong>Marca:</strong></label>
                                <p>{{ $maquina->marca }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Proveedor:</strong></label>
                                <p>{{ $maquina->proveedor }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Fecha de Adquisición:</strong></label>
                                <p>{{ \Carbon\Carbon::parse($maquina->fecha_adquisicion)->locale('es')->translatedFormat('l d \d\e F, Y') }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Estado:</strong></label>
                                <p>{{ $maquina->estado }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Serie:</strong></label>
                                <p>{{ $maquina->serie }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Descripción:</strong></label>
                                <p>{{ $maquina->descripcion }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Tipo:</strong></label>
                                <p>{{ $maquina->tipo }}</p>
                            </div>

                        

                        <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('maquinas.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn btn-warning w-100">Editar Máquina</a>
                            </div>
                            <div class="col-md-4"></div> <!-- Espacio vacío para mantener la alineación -->
                        </div>  

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
