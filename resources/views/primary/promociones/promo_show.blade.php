@extends('layouts.principal')
@section('title', 'Detalles de la Promoción')
@section('content')

    <section class="section" style="padding: 50px 0;">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg rounded-lg border-0" style="background-image: url('{{ asset('assets/img/laundry-background.jpg') }}'); background-size: cover; background-position: center center; border-radius: 15px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="card-body" style="background-color: rgba(255, 255, 255, 0.85); border-radius: 15px; transition: background-color 0.3s ease;">
                        <!-- Título de la sección -->
                        <h1 class="card-title text-center mb-4" style="font-size: 30px !important; color: #333; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);">Detalles de la Promoción</h1>
                        <hr>

                        <div class="row">
                            <!-- Columna 1: Imagen (ocupa 1 columna) -->
                            <div class="col-md-4">
                                @if ($promocion->image)
                                    <div class="text-center" style="overflow: hidden; border-radius: 15px;">
                                        <img src="{{ asset('assets/img/promociones/' . $promocion->image) }}" alt="Imagen de la promoción" class="img-fluid rounded shadow-lg" style="object-fit: cover; width: 100%; height: 300px; border-radius: 15px;">
                                    </div>
                                @else
                                    <p class="text-center text-muted"><i class="fas fa-image"></i> Imagen no asignada</p>
                                @endif
                            </div>

                            <!-- Columna 2 y 3: Información de la promoción (ocupan 2 columnas) -->
                            <div class="col-md-8" style="padding-top: 20px">
                                <div class="row mb-3">
                                    <label class="form-label"><strong>Nombre de la promoción:</strong> {{ $promocion->name }}</label>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label"><strong>Tipo de promoción:</strong> {{ $promocion->promo }}</label>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label"><strong>Notas:</strong> @if ($promocion->notes)
                                            {{ $promocion->notes }}
                                        @else
                                            <em>No asignadas</em>
                                        @endif</label>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label"><strong>Descuento:</strong> {{ $promocion->discount }}%</label>
                                </div>

                                <!-- Días de la promoción: Ahora en la misma fila -->
                                <div class="row mb-3">
                                    <label class="form-label"><strong>Días de la promoción:</strong></label>
                                    <ul class="list-unstyled d-flex flex-wrap mb-0">
                                        @php
                                            $days = json_decode($promocion->days, true);
                                        @endphp
                                        @if (is_array($days) && count($days) > 0)
                                            @foreach ($days as $day)
                                                <li class="me-3" style="font-size: 16px; display: inline; transition: color 0.3s ease;">
                                                    <i class="fas fa-check-circle text-success"></i> {{ $day }}
                                                </li>
                                            @endforeach
                                        @else
                                            <li style="font-size: 16px; display: inline; transition: color 0.3s ease;">
                                                <i class="fas fa-times-circle text-danger"></i> No hay días asignados.
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('promociones.index') }}" class="btn btn-secondary w-100 rounded-pill py-2" style="transition: background-color 0.3s ease;">
                                    Volver a la Lista
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('promociones.edit', $promocion->id) }}" class="btn btn-warning w-100 rounded-pill py-2" style="transition: background-color 0.3s ease;">
                                    Editar Promoción
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Script para animación de entrada de la imagen -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const image = document.querySelector('.card img');
            image.classList.add('animate__animated', 'animate__fadeIn');
        });
    </script>
@endsection
