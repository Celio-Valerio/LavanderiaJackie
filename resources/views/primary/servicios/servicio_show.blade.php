@extends('layouts.principal')
@section('title', 'Detalles del Servicio')
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
        @if($usuario->rolpermiso->servicios_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg rounded-lg border-0">
                        <div class="card-body">
                            <!-- Título de la sección -->
                            <h1 class="card-title text-center mb-4">Detalles del servicio</h1>
                            <hr>

                            <!-- Información del servicio -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Nombre del servicio:</strong> {{ $servicio->nombre }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Precio:</strong> L.{{ number_format($servicio->precio, 2) }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label"><strong>Descripción:</strong> {{ $servicio->descripcion }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Artículos de la promoción:</strong></label>
                                    <ul class="list-unstyled">
                                        @php
                                            $articulos = json_decode($servicio->articulos, true);
                                        @endphp
                                        @if (is_array($articulos) && count($articulos) > 0)
                                            @foreach ($articulos as $articulo)
                                                <li><i class="fas fa-check-circle text-success"></i> {{ $articulo }}</li>
                                            @endforeach
                                        @else
                                            <li><i class="fas fa-times-circle text-danger"></i> No hay artículos asignados.</li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Extras de la promoción:</strong></label>
                                    <ul class="list-unstyled">
                                        @php
                                            $extras = json_decode($servicio->extras, true);
                                        @endphp
                                        @if (is_array($extras) && count($extras) > 0)
                                            @foreach ($extras as $extra)
                                                <li><i class="fas fa-check-circle text-primary"></i> {{ $extra }}</li>
                                            @endforeach
                                        @else
                                            <li><i class="fas fa-times-circle text-danger"></i> No hay extras asignados.</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary w-100 rounded-pill py-2">
                                        Volver a la Lista
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-warning w-100 rounded-pill py-2">
                                        Editar Servicio
                                    </a>
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
