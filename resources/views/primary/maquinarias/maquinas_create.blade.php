@extends('layouts.principal')
@section('title', 'Registrar máquina')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 30px !important;">Registrar Máquina</h1>
                    <hr>
                    <form id="maquinaForm" action="{{ route('maquinas.store') }}" method="POST" novalidate>
                        @csrf <!-- Este campo ahora refleja ejemplos de máquinas de lavandería -->

                        <div class="row mb-3">
                            <!-- Campo de Nombre -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre de la Máquina</label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Lavadora, Secadora, Plancha" required>
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Modelo -->
                            <div class="col-md-6">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" id="modelo" value="{{ old('modelo') }}" placeholder="Ej: 2021" required maxlength="10">
                                @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Campo de Marca -->
                            <div class="col-md-6">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror" id="marca" value="{{ old('marca') }}" placeholder="Ej: LG" required>
                                @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Descripción -->
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Máquina para lavar ropa" rows="3">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Campo de Año de Compra -->
                            <div class="col-md-6">
                                <label for="anio_compra" class="form-label">Año de Compra</label>
                                <input type="number" name="anio_compra" class="form-control @error('anio_compra') is-invalid @enderror" id="anio_compra" value="{{ old('anio_compra') }}" min="1900" max="{{ date('Y') }}" required maxlength="4" oninput="this.value = this.value.slice(0, 4);"> <!-- Limitar a 4 dígitos -->
                                @error('anio_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Capacidad -->
                            <div class="col-md-6">
                                <label for="capacidad" class="form-label">Capacidad</label>
                                <input type="text" name="capacidad" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" value="{{ old('capacidad') }}" placeholder="Ej: 10 kg" required>
                                @error('capacidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Campo de Tipo -->
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo</label>
                                <input type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror" id="tipo" value="{{ old('tipo') }}" placeholder="Ej: Lavadora de carga frontal" required>
                                @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Estado -->
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" class="form-control @error('estado') is-invalid @enderror" id="estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="nuevo" {{ old('estado') == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="usado" {{ old('estado') == 'usado' ? 'selected' : '' }}>Usado</option>
                                </select>
                                @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Campo de Proveedor -->
                            <div class="col-md-6">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <input type="text" name="proveedor" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" value="{{ old('proveedor') }}" placeholder="Ej: Proveedor XYZ" required>
                                @error('proveedor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

        

                        <div class="row mb-3">
                            <!-- Campo de Serie -->
                            <div class="col-md-6">
                                <label for="serie" class="form-label">Serie</label>
                                <input type="text" name="serie" class="form-control @error('serie') is-invalid @enderror" id="serie" value="{{ old('serie') }}" placeholder="Ej: ABC123456" required maxlength="10">
                                @error('serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary flex-fill me-1">Agregar Máquina</button>
                            <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                            <a href="{{ route('maquinas.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Función para capitalizar la primera letra y la letra después de un espacio
        function capitalizeInput(input) {
            let value = input.value.toLowerCase();
            input.value = value.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });

            function restrictInput(e) {
                let key = e.key;
                let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]*$/;

                if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                    e.preventDefault();
                }
            }
        }

        // Asignar eventos a los campos nombre, modelo, marca y proveedor
        document.getElementById('nombre').addEventListener('input', function(e) {
            capitalizeInput(e.target);
        
        }); 

        document.getElementById('modelo').addEventListener('input', function(e) {
            capitalizeInput(e.target);
        });

        document.getElementById('marca').addEventListener('input', function(e) {
            capitalizeInput(e.target);
        });

        document.getElementById('proveedor').addEventListener('input', function(e) {
            capitalizeInput(e.target);
        });

        document.getElementById('serie').addEventListener('input', restrictInput);


    </script>   

<script>
            // Función para limpiar los campos del formulario y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('maquinaForm');

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
