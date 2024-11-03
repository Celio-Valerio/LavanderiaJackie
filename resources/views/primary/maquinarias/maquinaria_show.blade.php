@extends('layouts.principal')
@section('title', 'Detalles de la Maquinaria')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Detalles de la maquinaria</h1>
                        <hr>
                        <div class="row mb-3">
                            <!-- Nombre de la maquinaria -->
                            <div class="col-md-6">
                                <label for="name" class="form-label small-text-field"><strong>Nombre de la maquinaria</strong> {{ $maquinaria->name }}</label>
                            </div>

                            <!-- Marca -->
                            <div class="col-md-6">
                                <label for="brand" class="form-label small-text-field"><strong>Marca</strong> {{ $maquinaria->brand }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Modelo -->
                            <div class="col-md-6">
                                <label for="model" class="form-label small-text-field"><strong>Modelo</strong> {{ $maquinaria->model }}</label>
                            </div>

                            <!-- Fecha de adquisición -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Fecha de adquisición:</strong> {{ ucfirst(\Carbon\Carbon::parse($maquinaria->acquisition_date)->translatedFormat('l, d \d\e F, Y') )}}</label>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <!-- Tipo de maquinaria -->
                            <div class="col-md-6">
                                <label for="type" class="form-label  small-text-field"><strong>Tipo de maquinaria</strong> {{ $maquinaria->type }}</label>
                            </div>

                            <!-- Estado de la maquinaria -->
                            <div class="col-md-6">
                                <label for="status" class="form-label small-text-field"><strong>Estado</strong> {{ $maquinaria->status }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Proveedor -->
                            <div class="col-md-6">
                                <label for="proveedor" class="form-label small-text-field"><strong>Proveedor</strong> {{ $maquinaria->proveedor->full_name }}</label>
                            </div>
                        </div>

                        <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                        <div class="row">
                            <div class="col-md-6 small-text-field">
                                <a href="{{ route('maquinarias.index') }}" class="btn btn-secondary w-100">Volver a la lista</a>
                            </div>
                            <div class="col-md-6 small-text-field">
                                <a href="{{ route('maquinarias.edit', $maquinaria->id) }}" class="btn btn-warning w-100">Editar maquinaria</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
