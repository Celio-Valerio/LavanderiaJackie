@extends('layouts.principal')

@section('title', 'Detalles de la Transacción')

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
        @if($usuario->rolpermiso->transacciones_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Detalles de la Transacción</h1>
                            <hr>

                            <!-- Información de la Transacción -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Banco:</strong> {{ $transaccion->cuentaBanco->banco ?? 'No disponible' }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Número de Cuenta:</strong> {{ $transaccion->cuentaBanco->cuenta ?? 'No disponible' }}</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($transaccion->fecha)->locale('es')->isoFormat('LL') }}
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Tipo de Transacción:</strong> {{ $transaccion->transaccion }}</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Monto:</strong> L. {{ number_format($transaccion->monto, 2) }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Notas:</strong> {{ $transaccion->notas ?? 'Sin notas' }}</label>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('control_cuentas.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('control_cuentas.create') }}" class="btn btn-success w-100">Nueva Transacción</a>
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
