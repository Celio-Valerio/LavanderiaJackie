@extends('layouts.principal')
@section('title', 'Actualizar Servicio')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <style>
        .custom-checkbox-wrapper {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: start;
            margin-bottom: 10px;
        }

        .custom-checkbox-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .custom-checkbox-label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        /* Estilo para Artículos (Azul) */
        .custom-checkbox-label.articulo::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #007bff;
            border-radius: 5px;
            transform: translateY(-50%);
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label.articulo::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Estilo para Extras (Verde) */
        .custom-checkbox-label.extra::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #28a745;
            border-radius: 5px;
            transform: translateY(-50%);
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label.extra::before {
            background-color: #28a745;
            border-color: #28a745;
        }

        .custom-checkbox-label::after {
            content: '✔';
            position: absolute;
            top: 50%;
            left: 5px;
            font-size: 14px;
            color: #fff;
            opacity: 0;
            transform: translateY(-50%);
            transition: opacity 0.3s;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label::after {
            opacity: 1;
        }
    </style>

    <section class="section">
        @if($usuario->rolpermiso->servicios_editar == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Editar servicio</h1>
                            <hr>

                            <!-- Inicio del formulario -->
                            <form id="servicioForm" action="{{ route('servicios.update', $servicio->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="row  small-text-field">
                                    <!-- Columnas de contenido -->
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <!-- Campo de Nombre del Producto -->
                                            <div class="col-md-6">
                                                <label for="nombre" class="form-label">Nombre del servicio</label>
                                                <input type="text" name="nombre" class="form-control small-text-field @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre', $servicio->nombre) }}" placeholder="Ej: Jabón Líquido" maxlength="50" required>
                                                @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Campo de Precio -->
                                            <div class="col-md-3">
                                                <label for="precio" class="form-label">Precio en libras</label>
                                                <input type="text" name="precio" class="form-control small-text-field @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio', $servicio->precio) }}" placeholder="Ej: 100.00" required step="0.01">
                                                @error('precio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <!-- Campo de Descripción -->
                                            <div class="col-md-12">
                                                <label for="descripcion" class="form-label">Descripción del servicio</label>
                                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Servicio de lavado y planchado" maxlength="500" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                                                @error('descripcion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            @php
                                                $articulosSeleccionados = old('articulos', json_decode($servicio->articulos, true) ?? []);
                                                $extrasSeleccionados = old('extras', json_decode($servicio->extras, true) ?? []);
                                            @endphp


                                                <!-- Columna de Artículos -->
                                            <div class="col-md-6">
                                                <label class="form-label">Servicios</label>
                                                <div class="col-md-12 d-flex flex-column">
                                                    @php
                                                        $articulosSeleccionados = is_array($servicio->articulos)
                                                            ? $servicio->articulos
                                                            : json_decode($servicio->articulos, true) ?? [];
                                                    @endphp
                                                    @foreach(['Ropa casual', 'Ropa de cama', 'Peluches', 'Zapatos', 'Edredones', 'Almohadas', 'Manteles', 'Cojines', 'Alfombras', 'Tenis', 'Camisas', 'Pantalones', 'Sábanas'] as $articulo)
                                                        <div class="custom-checkbox-wrapper">
                                                            <input class="custom-checkbox-input"
                                                                   type="checkbox"
                                                                   name="articulos[]"
                                                                   value="{{ $articulo }}"
                                                                   id="articulo_{{ $articulo }}"
                                                                {{ in_array($articulo, old('articulos', $articulosSeleccionados)) ? 'checked' : '' }}>
                                                            <label class="custom-checkbox-label articulo" for="articulo_{{ $articulo }}">{{ $articulo }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('articulos')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Columna de Extras -->
                                            <div class="col-md-6">
                                                <label class="form-label">Servicios extras</label>
                                                <div class="col-md-12 d-flex flex-column">
                                                    @php
                                                        $extrasSeleccionados = is_array($servicio->extras)
                                                            ? $servicio->extras
                                                            : json_decode($servicio->extras, true) ?? [];
                                                    @endphp
                                                    @foreach(['Detergente', 'Suavizante', 'Quitamanchas', 'Planchado', 'Secado', 'Recogida y entrega', 'Lavado'] as $extra)
                                                        <div class="custom-checkbox-wrapper">
                                                            <input class="custom-checkbox-input"
                                                                   type="checkbox"
                                                                   name="extras[]"
                                                                   value="{{ $extra }}"
                                                                   id="extra_{{ $extra }}"
                                                                {{ in_array($extra, old('extras', $extrasSeleccionados)) ? 'checked' : '' }}>
                                                            <label class="custom-checkbox-label extra" for="extra_{{ $extra }}">{{ $extra }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('extras')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                    <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                    <a href="{{ route('servicios.index') }}" class="btn btn-danger flex-fill">Cancelar</a>
                                </div>
                            </form>
                            <!-- Fin del formulario -->

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
            document.addEventListener('DOMContentLoaded', function () {
                const reloadButton = document.getElementById('reloadButton');
                const form = document.getElementById('servicioForm');

                // Valores originales del formulario
                const originalData = {
                    nombre: "{{ $servicio->nombre }}",
                    precio: "{{ $servicio->precio }}",
                    descripcion: `{{ $servicio->descripcion }}`,
                    articulos: @json(json_decode($servicio->articulos, true) ?? []),
                    extras: @json(json_decode($servicio->extras, true) ?? [])
                };

                // Función para limpiar validaciones
                const resetValidation = () => {
                    const inputs = form.querySelectorAll('.is-invalid');
                    inputs.forEach(input => input.classList.remove('is-invalid'));

                    const invalidFeedbacks = form.querySelectorAll('.invalid-feedback');
                    invalidFeedbacks.forEach(feedback => feedback.innerHTML = '');
                };

                // Función para restablecer el formulario
                const resetForm = () => {
                    resetValidation();
                    // Restablecer campos de texto
                    document.getElementById('nombre').value = originalData.nombre;
                    document.getElementById('precio').value = originalData.precio;
                    document.getElementById('descripcion').value = originalData.descripcion;

                    // Restablecer checkboxes de artículos
                    const allArticulos = ['Ropa casual', 'Ropa de cama', 'Peluches', 'Zapatos', 'Edredones', 'Almohadas', 'Manteles', 'Cojines', 'Alfombras', 'Tenis', 'Camisas', 'Pantalones', 'Sábanas'];
                    allArticulos.forEach(articulo => {
                        const checkbox = document.getElementById(`articulo_${articulo}`);
                        if (checkbox) {
                            checkbox.checked = originalData.articulos.includes(articulo);
                        }
                    });

                    // Restablecer checkboxes de extras
                    const allExtras = ['Detergente', 'Suavizante', 'Quitamanchas', 'Planchado', 'Secado', 'Recogida y entrega', 'Lavado'];
                    allExtras.forEach(extra => {
                        const checkbox = document.getElementById(`extra_${extra}`);
                        if (checkbox) {
                            checkbox.checked = originalData.extras.includes(extra);
                        }
                    });
                };

                // Asignar función de restablecer al botón
                if (reloadButton) {
                    reloadButton.addEventListener('click', resetForm);
                }

                // Validar campo de precio: solo números y un punto decimal
                const precioInput = document.getElementById('precio');
                if (precioInput) {
                    precioInput.addEventListener('input', (e) => {
                        e.target.value = e.target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
                    });
                }
            });

        </script>
    </section>
@endsection
