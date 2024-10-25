@extends('layouts.principal')
@section('title', 'Detalles de la Maquinaria')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Detalles de la Maquinaria</h1>
                        <hr>
                        <div class="row mb-3">
                            <!-- Nombre de la maquinaria -->
                            <div class="col-md-6">
                                <label for="name" class="form-label"><strong>Nombre de la Maquinaria</strong></label>
                                <p class="form-control-static small-text-field" >{{ $maquinaria->name }}</p>
                            </div>

                            <!-- Marca -->
                            <div class="col-md-6">
                                <label for="brand" class="form-label"><strong>Marca</strong></label>
                                <p class="form-control-static small-text-field" >{{ $maquinaria->brand }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Modelo -->
                            <div class="col-md-6">
                                <label for="model" class="form-label"><strong>Modelo</strong></label>
                                <p class="form-control-static small-text-field" >{{ $maquinaria->model }}</p>
                            </div>

                            <!-- Fecha de adquisición -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Fecha de Adquisición:</strong></label>
                                <p class="small-text-field" >{{ ucfirst(\Carbon\Carbon::parse($maquinaria->acquisition_date)->translatedFormat('l, d \d\e F, Y') )}}</p>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <!-- Tipo de maquinaria -->
                            <div class="col-md-6">
                                <label for="type" class="form-label"><strong>Tipo de Maquinaria</strong></label>
                                <p class="form-control-static small-text-field" >{{ $maquinaria->type }}</p>
                            </div>

                            <!-- Estado de la maquinaria -->
                            <div class="col-md-6">
                                <label for="status" class="form-label"><strong>Estado</strong></label>
                                <p class="form-control-static small-text-field" >{{ $maquinaria->status }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Proveedor -->
                            <div class="col-md-6">
                                <label for="proveedor" class="form-label"><strong>Proveedor</strong></label>
                                <p class="form-control-static small-text-field">{{ $maquinaria->proveedor->full_name }}</p>
                            </div>
                        </div>

                        <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                        <div class="row">
                            <div class="col-md-6 small-text-field">
                                <a href="{{ route('maquinarias.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-6 small-text-field">
                                <a href="{{ route('maquinarias.edit', $maquinaria->id) }}" class="btn btn-warning w-100">Editar Maquinaria</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
