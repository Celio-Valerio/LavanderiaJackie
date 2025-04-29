@extends('layouts.principal')
@section('title', 'Detalles de la Compra')
@section('content')

    <section class="section">
    @if($usuario->rolpermiso->compras_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Detalles de la compra</h1>
                            <hr>

                            <!-- Información de la Compra -->
                            <div class="row mb-3">
                                <!-- Número de Factura y Fecha de Compra -->
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Número de factura:</strong> {{ $compra->numero_factura }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Fecha de compra:</strong> {{ ucfirst(\Carbon\Carbon::parse($compra->fecha_compra)->translatedFormat('l d \d\e F, Y')) }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Proveedor y Descripción de la Compra -->
                                <div class="col-md-6">
                                    <label class="form-label small-text-field"><strong>Descripción:</strong> {{ $compra->descripcion ?? 'No especificada' }}</label>
                                </div>
                            </div>

                            <!-- Tabla de Detalles de la Compra -->
                            <div class="table-responsive mb-3">
                                <table class="table table-striped table-bordered text-center">
                                    <thead>
                                    <tr>
                                        <th style="width: 60%;">Producto</th>
                                        <th style="width: 60%;">Proveedor</th>
                                        <th style="width: 10%;">Cantidad</th>
                                        <th style="width: 15%;">Precio</th>
                                        <th style="width: 15%;">Descuento</th>
                                        <th style="width: 15%;">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $suma = 0
                                    @endphp
                                    @foreach ($compra->detalles as $detalle)
                                        <tr>
                                            @php
                                                $suma = $suma + ($detalle->precio * $detalle->cantidad) - $detalle->descuento;
                                            @endphp
                                            <td class="text-start">{{ $detalle->producto->nombre }}</td>
                                            <td class="small-text-field">{{ $detalle->producto->proveedor->full_name ?? 'Sin proveedor' }}</td>
                                            <td>{{ $detalle->cantidad }}</td>
                                            <td>{{ number_format($detalle->precio ?? 0, 2) }}</td>
                                            <td>{{ number_format($detalle->descuento ?? 0, 2) }}%</td>
                                            <td>{{ number_format(($detalle->precio * $detalle->cantidad) - $detalle->descuento) ?? 0, 2 }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total de la Compra -->
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <h4><strong>Total:</strong>{{ number_format($suma ?? 0, 2) }} </h4>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('compras.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('compras.create', $compra->id) }}" class="btn btn-warning w-100">Nueva Compra</a>
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
