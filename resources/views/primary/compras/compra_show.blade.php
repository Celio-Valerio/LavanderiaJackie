@extends('layouts.principal')
@section('title', 'Detalles de la Factura')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="card-title text-left mb-4" style="font-size: 20px;">Detalles de la Factura</h1>
                        <hr>

                        <!-- Información de la Factura -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-box small-text-field">
                                    <strong>Número de Factura:</strong>
                                    <p class="info-text small-text-field">{{ $compra->numero_factura }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box small-text-field">
                                    <strong>Fecha de Compra:</strong>
                                    <p class="info-text small-text-field">{{ ucfirst(\Carbon\Carbon::parse($compra->fecha_compra)->translatedFormat('l d \d\e F, Y')) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box small-text-field">
                                    <strong>Proveedor:</strong>
                                    <p class="info-text small-text-field">{{ $compra->proveedor->full_name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción de la Compra -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="info-box small-text-field">
                                    <strong>Descripción:</strong>
                                    <p class="info-text small-text-field">{{ $compra->descripcion }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de Detalles de la Compra -->
                        <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>DETALLES DE LA COMPRA</strong></h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered small-text-field">
                                <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($compra->detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->producto->nombre }}</td>
                                        <td class="text-right">{{ $detalle->cantidad }}</td>
                                        <td class="text-right">{!! formatCurrency($detalle->precio) !!}</td>
                                        <td class="text-right">{!! formatCurrency($detalle->descuento) !!}</td>
                                        <td class="text-right">{!! formatCurrency(($detalle->precio * $detalle->cantidad) - $detalle->descuento) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total de la Factura -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <h5>
                                    <strong>{!! formatCurrency($compra->detalles->sum(function($detalle) {
                                    return ($detalle->precio * $detalle->cantidad) - $detalle->descuento;
                                })) !!}</strong>
                                </h5>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <a href="{{ route('compras.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning w-100">Editar Factura</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .info-text {
            margin: 0;
            font-size: 16px;
            color: #495057;
        }
        .text-right {
            text-align: right;
        }
        .currency {
            display: flex;
            justify-content: flex-end;
            font-family: monospace; /* Usamos una fuente monoespaciada para mejor alineación */
        }
        .currency .symbol {
            margin-right: 5px; /* Espacio entre el símbolo y el número */
        }
    </style>

    @php
        function formatCurrency($amount) {
            return '<span class="currency"><span class="symbol">L.</span>' . number_format($amount, 2, ',', '.') . '</span>';
        }
    @endphp

@endsection
