@extends('layouts.principal')

@section('title', 'Detalles de la Transacción')

@section('content')

    <section class="section">
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
    </section>

@endsection
