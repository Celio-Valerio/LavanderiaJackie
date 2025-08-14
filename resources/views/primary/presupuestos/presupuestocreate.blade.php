@extends('layouts.principal')
@section('title', 'Registrar Presupuesto')
@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'es');
        Carbon::setUTF8(true);
    @endphp
    <section class="section">
        @if($usuario->rolpermiso->presupuesto_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registro de presupuesto del mes de {{ ucfirst(Carbon::now()->locale('es')->monthName) }}</h1>
                        <hr>
                        <form id="presupuestoForm" action="{{ route('presupuestos.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <textarea name="descripcion" id="descripcion" maxlength="200" class="form-control @error('descripcion') is-invalid @enderror" required>{{  old('descripcion') }}</textarea>
                                        @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monto">Monto:</label>
                                        <input type="text" name="monto" id="monto" class="form-control @error('monto') is-invalid @enderror" maxlength="5" value="{{old('monto')}}" oninput="validarSoloNumeros(this)">
                                        @error('monto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha:</label>
                                        <input type="date" class="form-control" readonly value="{{ isset($yourVariable) ? $yourVariable->fecha : date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('presupuestos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>

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
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Función para permitir solo números decimales válidos
                window.validarSoloNumeros = function (input) {
                    input.value = input.value
                        .replace(/[^0-9.]/g, "") // Permite solo números y un punto decimal
                        .replace(/^\./, "") // Elimina el punto si está al inicio
                        .replace(/^0+(?!\.|$)/g, "") // Elimina ceros iniciales innecesarios
                        .replace(/(\.)(?=.*\.)/g, ""); // Permite solo un punto decimal
                };
            });
        </script>

        <script>
            // Función para limpiar los campos del formulario y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('presupuestoForm');

                // Limpiar los valores del formulario
                form.reset();

                // Limpiar los campos manualmente para evitar restauración por old()
                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden') { // No limpiar campos ocultos
                        input.value = '';
                    }
                });

                // También puedes eliminar las clases de error de validación
                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
            });
        </script>


    </section>
@endsection
