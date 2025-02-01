@extends('layouts.principal')
@section('title', 'Detalles del Servicio Pendiente')
@section('content')

    <style>
        .list-unstyled {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .list-unstyled li {
            flex: 1 1 auto;
            min-width: 180px;
            box-sizing: border-box;
        }

        .card {
            background-image: url('{{ asset('assets/img/laundry-background.jpg') }}');
            background-size: cover;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.85);
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
    </style>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body">
                        <!-- Título de la sección -->
                        <h1 class="card-title text-center mb-4">Detalles del servicio pendiente</h1>
                        <hr>

                        <!-- Información del cliente -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Cliente:</strong> {{ $servicioEfectuado->cliente->first_name }} {{ $servicioEfectuado->cliente->last_name }}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Servicio:</strong> {{ $servicioEfectuado->servicio->nombre }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Envio:</strong> {{ $servicioEfectuado->envio }}</label>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><strong>Estado:</strong> {{ $servicioEfectuado->estado }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <strong>Pagará el envío:</strong>
                                    @if($servicioEfectuado->pago_envio !== null)
                                        {{ $servicioEfectuado->pago_envio }}
                                    @else
                                        No se pagrá envió
                                    @endif
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <strong>Precio de envio:</strong>
                                    @if($servicioEfectuado->precio_envio !== null)
                                        L. {{ number_format($servicioEfectuado->precio_envio, 2) }}
                                    @else
                                        No se pagrá envió
                                    @endif
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <strong>Promoción:</strong>
                                    @if($servicioEfectuado->promo && $servicioEfectuado->promo->name)
                                        {{ $servicioEfectuado->promo->name }} ({{ $servicioEfectuado->promo->promo }})
                                    @else
                                        No se le aplicó promoción.
                                    @endif
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <strong>Descuento:</strong>
                                    @if($servicioEfectuado->promo && $servicioEfectuado->promo->discount)
                                        {{ $servicioEfectuado->promo->discount }}%
                                    @else
                                        No se le aplicó descuento.
                                    @endif
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Total:</strong> L. {{ number_format($servicioEfectuado->total, 2) }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label"><strong>Notas:</strong> {{ $servicioEfectuado->notas ?? 'No hay notas disponibles.' }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label"><strong>Dirección:</strong> {{ $servicioEfectuado->direccion ?? 'El cliente recogerá, en la empresa.' }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('servicios_pendientes.index') }}" class="btn btn-secondary w-100 rounded-pill py-2">
                                    Volver a la Lista
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            var maxWidth = 0;
            $('ul.list-unstyled li').each(function() {
                var itemWidth = $(this).outerWidth();
                if (itemWidth > maxWidth) {
                    maxWidth = itemWidth;
                }
            });

            // Establece el mismo ancho a todos los elementos
            $('ul.list-unstyled li').each(function() {
                $(this).css('width', maxWidth + 'px');
            });
        });
    </script>

@endsection
