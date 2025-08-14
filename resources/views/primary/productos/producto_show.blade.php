@extends('layouts.principal')
@section('title', 'Detalles del Producto')
@section('content')

    <style>
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

        .badge {
            font-size: 0.875rem;
            padding: 0.5rem;
        }
    </style>

    <section class="section">
        @if($usuario->rolpermiso->productos_ver == 1)
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg rounded-lg border-0">
                        <div class="card-body">
                            <!-- Título de la sección -->
                            <h1 class="card-title text-center mb-4">Detalles del producto</h1>
                            <hr>

                            <!-- Información del producto -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Nombre del producto:</strong> {{ $producto->nombre }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Precio:</strong> L.{{ number_format($producto->precio, 2) }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Presentación:</strong> {{ $producto->presentacion }}</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label"><strong>Descripción:</strong> {{ $producto->descripcion }}</label>
                                </div>
                            </div>

                            <!-- Historial de precios -->
                            <h3 class="mt-4 mb-3 text-center">Historial de precios</h3>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Precio</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($historialPrecios as $historial)
                                    <tr>
                                        <td>{{ ucfirst(\Carbon\Carbon::parse($historial->fecha_cambio)->translatedFormat('l d \d\e F, Y')) }}</td>
                                        <td>L.{{ number_format($historial->precio_mostrar, 2) }}
                                            @if(!empty($historial->es_inicial) && $historial->es_inicial)
                                                <strong>( Precio inicial )</strong>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <!-- Botones de acción -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <a href="{{ route('productos.index') }}" class="btn btn-secondary w-100 rounded-pill py-2">
                                        Volver a la lista
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning w-100 rounded-pill py-2">
                                        Editar producto
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
