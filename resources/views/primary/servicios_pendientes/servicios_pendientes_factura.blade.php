@extends('layouts.principal')
@section('title', 'Factura de Venta de Servicios')
@section('content')

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .factura, .factura * {
                visibility: visible;
            }
            .factura {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            /* Oculta los botones al imprimir */
            .factura .btn {
                display: none !important;
            }
        }
    </style>


    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body factura">
                        <h1 class="card-title" style="font-size: 30px !important;">Factura de Venta de Servicios</h1>
                        <hr>

                        <!-- Información de la Factura -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Cliente:</strong> {{ $servicioEfectuado->cliente->first_name }} {{ $servicioEfectuado->cliente->last_name }}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Fecha del Servicio:</strong> {{ ucfirst(\Carbon\Carbon::parse($servicioEfectuado->created_at)->translatedFormat('l d \d\e F, Y')) }}</label>
                            </div>
                        </div>

                        <!-- Detalles del Servicio -->
                        <div class="table-responsive mb-3">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th>Precio</th>
                                    <th>Promoción</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $servicioEfectuado->servicio->nombre }}</td>
                                    <td>{{ $servicioEfectuado->estado }}</td>
                                    <td>L. {{ number_format($servicioEfectuado->total, 2) }}</td>
                                    <td>{{ $servicioEfectuado->promo->name ?? 'No aplica' }}</td>
                                    <td>{{ $servicioEfectuado->promo->discount ?? '0' }}%</td>
                                    <td>L. {{ number_format($servicioEfectuado->total - ($servicioEfectuado->total * ($servicioEfectuado->promo->discount ?? 0) / 100), 2) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Información de Envío -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Envío:</strong> {{ $servicioEfectuado->envio }}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Pagará el envío:</strong> {{ $servicioEfectuado->pago_envio ?? 'No' }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Precio de envío:</strong> L. {{ number_format($servicioEfectuado->precio_envio ?? 0, 2) }}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Dirección:</strong> {{ $servicioEfectuado->direccion ?? 'El cliente recogerá en la empresa.' }}</label>
                            </div>
                        </div>

                        <!-- Notas -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label"><strong>Notas:</strong> {{ $servicioEfectuado->notas ?? 'No hay notas disponibles.' }}</label>
                            </div>
                        </div>

                        <!-- Total de la Factura -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <h4><strong>Total a Pagar:</strong> L. {{ number_format(($servicioEfectuado->total - ($servicioEfectuado->total * ($servicioEfectuado->promo->discount ?? 0) / 100)) + ($servicioEfectuado->precio_envio ?? 0), 2) }}</h4>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('servicios_efectuados.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('servicios_efectuados.create') }}" class="btn btn-warning w-100">Nuevo Servicio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.print();
        });
    </script>

@endsection
