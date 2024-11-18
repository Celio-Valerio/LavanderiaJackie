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
            flex: 1 1 auto; /* Establece que los elementos tengan un tamaño flexible */
            min-width: 180px; /* Puedes ajustar el mínimo según el tamaño deseado */
            box-sizing: border-box;
        }
    </style>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <!-- Título de la sección -->
                        <h1 class="card-title text-center mb-4" style="font-size: 30px !important;">Detalles del Servicio</h1>
                        <hr>

                        <div class="row">
                            <!-- Columna 1: Imagen (ocupa 1 columna) -->
                            <div class="col-md-4" style="display: none;">
                                @php
                                    // Generar un número aleatorio entre 1 y 5
                                    $imageNumber = rand(1, 5);
                                @endphp
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/servicios/servicios (' . $imageNumber . ').jpg') }}" alt="Imagen del servicio" class="img-fluid rounded shadow" style="object-fit: cover; width: 100%; height: 100%; max-height: 300px; border: 3px solid #ddd; background-color: #f8f9fa;">
                                </div>
                            </div>

                            <!-- Columna 2 y 3: Información del servicio (ocupan 2 columnas) -->
                            <div class="col-md-12">
                                <!-- Nombre del servicio -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Nombre del servicio:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">{{ $servicio->nombre }}</p>
                                    </div>
                                </div>

                                <!-- Descripción del servicio -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Descripción:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">{{ $servicio->descripcion }}</p>
                                    </div>
                                </div>

                                <!-- Precio del servicio -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Precio:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">${{ number_format($servicio->precio, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Duración estimada del servicio -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Duración estimada:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">
                                            @if(is_null($servicio->duracion_estimada) || $servicio->duracion_estimada <= 0)
                                                No definido
                                            @elseif($servicio->duracion_estimada > 60 && $servicio->duracion_estimada < 1440)
                                                {{ floor($servicio->duracion_estimada / 60) }} horas y {{ $servicio->duracion_estimada % 60 }} minutos
                                            @elseif($servicio->duracion_estimada >= 1440)
                                                {{ floor($servicio->duracion_estimada / 1440) }} días y {{ floor(($servicio->duracion_estimada % 1440) / 60) }} horas
                                            @else
                                                {{ $servicio->duracion_estimada }} minutos
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Estado del servicio -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Estado:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-text mb-0">
                                            @if($servicio->estado == 1)
                                                Activo
                                            @else
                                                Inactivo
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Artículos de la promoción -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Artículos de la promoción:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled d-flex flex-wrap mb-0">
                                            @php
                                                $articulos = json_decode($servicio->articulos, true);
                                            @endphp
                                            @if (is_array($articulos) && count($articulos) > 0)
                                                @foreach ($articulos as $articulo)
                                                    <li class="form-text mb-0"><i class="fas fa-check-circle text-success"></i> {{ $articulo }} </li>
                                                @endforeach
                                            @else
                                                <li><i class="fas fa-times-circle text-danger"></i> No hay artículos asignados.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <!-- Extras de la promoción -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Extras de la promoción:</strong></label>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled d-flex flex-wrap mb-0">
                                            @php
                                                $extras = json_decode($servicio->extras, true);
                                            @endphp
                                            @if (is_array($extras) && count($extras) > 0)
                                                @foreach ($extras as $extra)
                                                    <li class="form-text mb-0"><i class="fas fa-check-circle text-primary"></i> {{ $extra }}</li>
                                                @endforeach
                                            @else
                                                <li><i class="fas fa-times-circle text-danger"></i> No hay extras asignados.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('servicios.index') }}" class="btn btn-secondary w-100">
                                    Volver a la Lista
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-warning w-100">
                                    Editar Servicio
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

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

    </section>

@endsection
