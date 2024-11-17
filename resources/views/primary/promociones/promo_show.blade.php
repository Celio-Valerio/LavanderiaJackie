@extends('layouts.principal')
@section('title', 'Detalles de la Promoción')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <!-- Título de la sección -->
                        <h1 class="card-title text-center mb-4" style="font-size: 30px !important;">Detalles de la Promoción</h1>
                        <hr>

                        <div class="row">
                            <!-- Columna 1: Imagen (ocupa 1 columna) -->
                            <div class="col-md-4">
                                @if ($promocion->image)
                                    <div class="text-center">
                                        <img src="{{ asset('assets/img/promociones/' . $promocion->image) }}" alt="Imagen de la promoción" class="img-fluid rounded shadow" style="object-fit: cover; width: 100%; height: 100%; max-height: 300px; border: 3px solid #ddd; background-color: #f8f9fa;">
                                    </div>
                                @else
                                    <p><i class="fas fa-image text-muted"></i> No asignada</p>
                                @endif
                            </div>

                            <!-- Columna 2 y 3: Información de la promoción (ocupan 2 columnas) -->
                            <div class="col-md-8">
                                <!-- Nombre de la promoción -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Nombre de la promoción:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">{{ $promocion->name }}</p>
                                    </div>
                                </div>

                                <!-- Tipo de promoción -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Tipo de promoción:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">{{ $promocion->promo }}</p>
                                    </div>
                                </div>

                                <!-- Notas -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Notas:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">
                                            @if ($promocion->notes)
                                                {{ $promocion->notes }}
                                            @else
                                                <em>No asignadas</em>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Descuento -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Descuento:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">{{ $promocion->discount }}%</p>
                                    </div>
                                </div>

                                <!-- Días de la promoción -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Días de la promoción:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled d-flex flex-wrap mb-0">
                                            @php
                                                $days = json_decode($promocion->days, true);
                                            @endphp
                                            @if (is_array($days) && count($days) > 0)
                                                @foreach ($days as $day)
                                                    <li class="me-3"><i class="fas fa-check-circle text-success"></i> {{ $day }}</li>
                                                @endforeach
                                            @else
                                                <li><i class="fas fa-times-circle text-danger"></i> No hay días asignados.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('promociones.index') }}" class="btn btn-secondary w-100">
                                    Volver a la Lista
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('promociones.edit', $promocion->id) }}" class="btn btn-warning w-100">
                                    Editar Promoción
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
