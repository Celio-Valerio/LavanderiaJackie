@extends('layouts.principal')
@section('title', 'Detalles del Presupuesto')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Detalles del presupuesto de {{ \Carbon\Carbon::parse($presupuesto->fecha)->translatedFormat('F Y') }}</h1>
                        <hr>
                        <div class="row mb-3">
                            <!-- Proveedor y Descripción de la Compra -->
                            <div class="col-md-12">
                                <label class="form-label small-text-field"><strong>Descripción:</strong> {{ $presupuesto->descripcion ?? 'No especificada' }}</label>
                            </div>
                        </div>

                        <!-- Información de la Compra -->
                        <div class="row mb-3">
                            <!-- Número de Factura y Fecha de Compra -->
                            <div class="col-md-3">
                                <label class="form-label small-text-field"><strong>Monto inicial:</strong>L. {{number_format($presupuesto->cantidad, 2, '.', ',')}}</label>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small-text-field"><strong>Monto gastado:</strong>L. {{number_format($presupuesto->gastado, 2, '.', ',')}}</label>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small-text-field"><strong>Monto disponible:</strong>L. {{number_format($presupuesto->cantidad - $presupuesto->gastado, 2, '.', ',')}}</label>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small-text-field"><strong>Fecha de registro:</strong> {{ ucfirst(\Carbon\Carbon::parse($presupuesto->fecha)->translatedFormat('l d \d\e F, Y')) }}</label>
                            </div>
                        </div>


                        <h4 class="card-title" style="font-size: 20px !important;">Compras realizadas en {{ \Carbon\Carbon::parse($presupuesto->fecha)->translatedFormat('F Y') }}</h4>
                        <hr>
                        <!-- Tabla de Detalles de la Compra -->
                        <div class="table-responsive mb-3">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th style="width: 45%;">Producto</th>
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
                                @forelse ($presupuesto->compras as $compra)
                                    @foreach ($compra->detalles as $detalle)
                                    <tr>
                                        @php
                                            $suma = $suma + ($detalle->precio * $detalle->cantidad) - ($detalle->precio * $detalle->cantidad * ($detalle->descuento / 100));
                                        @endphp
                                        <td class="text-start">{{ $detalle->producto->nombre }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>L. {{ number_format($detalle->precio ?? 0, 2) }}</td>
                                        <td>{{ number_format($detalle->descuento ?? 0, 2) }}%</td>
                                        <td>L. {{number_format(($detalle->precio * $detalle->cantidad) - ($detalle->precio * $detalle->cantidad * ($detalle->descuento / 100)), 2, '.', ',')}}</td>
                                    </tr>
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay compras para mostrar</td>
                                </tr>
                                @endforelse
                                @if ($presupuesto->compras->count() > 0)
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Total:</strong></td>
                                    <td> L. {{ number_format($suma ?? 0, 2) }}</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('presupuestos.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection