@extends('layouts.principal')
@section('title', 'Detalles del Proveedor')
@section('content')
    <style>
        .card {
            background-image: url('{{ asset('assets/img/laundry-background.jpg') }}');
            background-size: fill;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.76);
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

        .info-label {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .info-value {
            font-size: 20px;
            font-weight: 500;
            color: #333;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 20px;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }
    </style>

    <section class="section">
        @if($usuario->rolpermiso->proveedores_ver == 1)
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
                                    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary w-100">Volver a la lista</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning w-100">Editar proveedor</a>
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
