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
    </style>

    <section class="section">
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
                                <label class="form-label"><strong>Proveedor:</strong> {{ $producto->proveedor->full_name }}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Presentación:</strong> {{ $producto->presentacion }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label"><strong>Descripción:</strong> {{ $producto->descripcion }}</label>
                            </div>
                        </div>



                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary w-100 rounded-pill py-2">
                                    Volver a la Lista
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning w-100 rounded-pill py-2">
                                    Editar Producto
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
