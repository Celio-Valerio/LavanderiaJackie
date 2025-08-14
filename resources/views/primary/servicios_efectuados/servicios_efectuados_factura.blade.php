@extends('layouts.principal')
@section('title', 'Factura de venta de servicios')
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
                height: 100%;
                font-size: 12px;
            }
            /* Oculta los botones al imprimir */
            .factura .btn {
                display: none !important;
            }
            .factura .header-info {
                font-size: 14px;
            }
            .factura table {
                width: 100%;
                margin-bottom: 10px;
            }
            .factura table th, .factura table td {
                padding: 5px;
            }
        }
    </style>

    <section class="section">
        @if($usuario->rolpermiso->serviciosefectuados_imprimir == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body factura">
                            <!-- Encabezado -->
                            <h1 class="card-title text-center" style="font-size: 25px !important; margin-bottom: -15px;">Lavandería Jackie</h1>
                            <h2 class="card-title text-center" style="font-size: 20px !important; margin-bottom: -15px;">Factura de venta de servicios</h2>

                            <div class="header-info mb-3">
                                <h3 class="text-center" style="font-size: 20px; margin-bottom: 5px;">Prop. Matilde Jackeline Moncada Zelaya</h3>
                                <p class="text-center" style="font-size: 14px; margin: 0;">Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.</p>
                                <p class="text-center" style="font-size: 14px; margin: 0;">R.T.N.: 07031985048849 / Cel: 9608-5567</p>
                                <p class="text-center" style="font-size: 14px; margin: 0;">E-mail: jacky.moncada25@gmail.com</p>
                            </div>

                            <hr>

                            <div class="row mb-12">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>CAI:</strong> #### - #### - #### - ####</label>
                                </div>
                            </div>

                            <!-- Información de la Factura -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Cliente:</strong> {{ $servicioEfectuado->cliente->first_name }} {{ $servicioEfectuado->cliente->last_name }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Fecha del servicio:</strong> {{ ucfirst(\Carbon\Carbon::parse($servicioEfectuado->created_at)->translatedFormat('l d \d\e F, Y')) }}</label>
                                </div>
                            </div>

                            <!-- Detalles del Servicio -->
                            <div class="table-responsive mb-3">
                                <table class="table table-striped table-bordered text-center">
                                    <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Libras</th>
                                        <th>Precio por libra</th>
                                        <th>Promoción</th>
                                        <th>Descuento</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $servicioEfectuado->servicio->nombre }}</td>
                                        <td>{{ $servicioEfectuado->libras }}</td>
                                        <td>L. {{ number_format($servicioEfectuado->total / $servicioEfectuado->libras, 2) }}</td>
                                        <td>{{ $servicioEfectuado->promo->name ?? 'No aplica' }}</td>
                                        <td>{{ $servicioEfectuado->promo->discount ?? '0' }}%</td>
                                        <td>L. {{ number_format($servicioEfectuado->total - ($servicioEfectuado->total * ($servicioEfectuado->promo->discount ?? 0) / 100), 2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total de la Factura -->
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <h4><strong>Total a pagar:</strong> L. {{ number_format(($servicioEfectuado->total - ($servicioEfectuado->total * ($servicioEfectuado->promo->discount ?? 0) / 100)) + ($servicioEfectuado->precio_envio ?? 0), 2) }}</h4>
                                </div>
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.print();
        });
    </script>

@endsection
