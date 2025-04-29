@extends('layouts.principal')
@section('title', 'Detalles del Mantenimiento')
@section('content')

    <style>
        .list-unstyled {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .list-unstyled li {
            flex: 1 1 auto;
            min-width: 180px;
            box-sizing: border-box;
        }

        .card {
            background-image: url('{{ asset('assets/img/laundry-background.jpg') }}');
            background-size: cover;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            transition: background-color 0.3s ease;
        }

        .card-title {
            font-size: 30px !important;
            color: #333;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>

    <section class="section">
        @if($usuario->rolpermiso->mantenimiendo_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg rounded-lg border-0">
                        <div class="card-body">
                            <!-- Título de la sección -->
                            <h1 class="card-title text-center mb-4">Detalles del mantenimiento</h1>
                            <hr>

                            <div class="row mb-3">
                                <!-- Fecha de mantenimiento -->
                                <div class="col-md-6">
                                    <label for="maintenance_date" class="form-label small-text-field"><strong>Fecha del mantenimiento:</strong> {{ ucfirst(\Carbon\Carbon::parse($mantenimiento->date)->translatedFormat('l, d \d\e F, Y') )}}</label>
                                </div>

                                <!-- Tipo de mantenimiento -->
                                <div class="col-md-6">
                                    <label for="maintenance_type" class="form-label small-text-field"><strong>Tipo de mantenimiento:</strong> {{ $mantenimiento->maintenance_type }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Costo -->
                                <div class="col-md-6">
                                    <label for="cost" class="form-label small-text-field"><strong>Costo:</strong> L. {{ number_format($mantenimiento->price, 2) }}</label>
                                </div>

                                <!-- Responsable -->
                                <div class="col-md-6">
                                    <label for="responsible" class="form-label small-text-field"><strong>Maquinaria:</strong> {{ $mantenimiento->maquinaria->name }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Descripción -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label small-text-field"><strong>Descripción:</strong>
                                        @if($mantenimiento->description)
                                            <span>{{ $mantenimiento->description }}</span>
                                        @else
                                            <span>No hay descripción disponible.</span>
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                            <div class="row">
                                <div class="col-md-6 small-text-field">
                                    <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary w-100">Volver a la lista</a>
                                </div>
                                <div class="col-md-6 small-text-field">
                                    <a href="{{ route('mantenimientos.edit', $mantenimiento->id) }}" class="btn btn-warning w-100">Editar mantenimiento</a>
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
