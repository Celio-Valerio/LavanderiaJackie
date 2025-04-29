@extends('layouts.principal')
@section('title', 'Detalles de la Maquinaria')
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
        @if($usuario->rolpermiso->maquinas_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg rounded-lg border-0">
                        <div class="card-body">
                            <!-- Título de la sección -->
                            <h1 class="card-title text-center mb-4">Detalles de la maquinaria</h1>
                            <hr>

                            <div class="row mb-3">
                                <!-- Nombre de la maquinaria -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label small-text-field"><strong>Nombre de la maquinaria:</strong> {{ $maquinaria->name }}</label>
                                </div>

                                <!-- Marca -->
                                <div class="col-md-6">
                                    <label for="brand" class="form-label small-text-field"><strong>Marca:</strong> {{ $maquinaria->brand }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Modelo -->
                                <div class="col-md-6">
                                    <label for="model" class="form-label small-text-field"><strong>Modelo:</strong> {{ $maquinaria->model }}</label>
                                </div>

                                <!-- Fecha de adquisición -->
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Fecha de adquisición:</strong> {{ ucfirst(\Carbon\Carbon::parse($maquinaria->acquisition_date)->translatedFormat('l, d \d\e F, Y') )}}</label>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <!-- Tipo de maquinaria -->
                                <div class="col-md-6">
                                    <label for="type" class="form-label  small-text-field"><strong>Tipo de maquinaria:</strong> {{ $maquinaria->type }}</label>
                                </div>

                                <!-- Estado de la maquinaria -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label small-text-field"><strong>Estado:</strong> {{ $maquinaria->status }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Proveedor -->
                                <div class="col-md-6">
                                    <label for="proveedor" class="form-label small-text-field"><strong>Proveedor:</strong> {{ $maquinaria->proveedor->full_name }}</label>
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
