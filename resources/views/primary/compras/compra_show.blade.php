@extends('layouts.principal')
@section('title', 'Detalles de la Compra')
@section('content')

    <section class="section">
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
                                <label class="form-label small-text-field"><strong>Proveedor:</strong> {{ $compra->proveedor->full_name }}</label>
                            </div>
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
                                    <th style="width: 10%;">Cantidad</th>
                                    <th style="width: 15%;">Precio</th>
                                    <th style="width: 15%;">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($compra->detalles as $detalle)
                                    <tr>
                                        <td class="text-start">{{ $detalle->producto->nombre }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>{!! formatCurrency($detalle->precio) !!}</td>
                                        <td>{!! formatCurrency(($detalle->precio * $detalle->cantidad) - $detalle->descuento) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total de la Compra -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <h4><strong>Total:</strong> {!! formatCurrency($compra->detalles->sum(function($detalle) {
                                return ($detalle->precio * $detalle->cantidad) - $detalle->descuento;
                            })) !!}</h4>
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
    </section>

    @php
        function formatCurrency($amount) {
            // Formatear la cantidad con el formato L. y con espacios para alinear
            $formattedAmount = number_format($amount, 2, '.', ',');
            $spaces = str_repeat('&nbsp;', 12 - strlen($formattedAmount));
            return "<span class='currency'>L.$spaces$formattedAmount</span>";
        }
    @endphp
@endsection
