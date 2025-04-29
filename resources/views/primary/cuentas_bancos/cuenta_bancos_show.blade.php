@extends('layouts.principal')
@section('title', 'Detalles de la Cuenta Bancaria')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->bancos_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Detalles de la Cuenta Bancaria</h1>
                            <hr>

                            <!-- Información de la Cuenta -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Nombre del Banco:</strong> {{ $cuenta->banco }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Número de Cuenta:</strong> {{ $cuenta->cuenta }}</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Saldo Actual:</strong> <span class="text-primary">L. {{ number_format($cuenta->saldo, 2) }}</span></label>
                                </div>
                            </div>

                            <!-- Tabla de Movimientos -->
                            <div class="table-responsive mb-3">
                                <table class="table table-striped table-bordered text-center">
                                    <thead class="table-dark">
                                    <tr>
                                        <th style="width: 20%;">Fecha</th>
                                        <th style="width: 20%;">Tipo de Transacción</th>
                                        <th style="width: 20%;">Monto (L.)</th>
                                        <th style="width: 40%;">Notas</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cuenta->transacciones->sortByDesc('fecha') as $transaccion)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y') }}</td>
                                            <td>
                                            <span class="badge @if($transaccion->transaccion == 'Retiro') bg-danger @elseif($transaccion->transaccion == 'Deposito') bg-success @else bg-primary @endif">
                                                {{ $transaccion->transaccion }}
                                            </span>
                                            </td>
                                            <td>
                                            <span class="@if($transaccion->transaccion == 'Retiro') text-danger @elseif($transaccion->transaccion == 'Deposito') text-success @else text-primary @endif">
                                                L. {{ number_format($transaccion->monto, 2) }}
                                            </span>
                                            </td>
                                            <td>{{ $transaccion->notas ?? 'Sin notas' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Botón para Volver -->
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('cuenta_bancos.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
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
