@extends('layouts.principal')
@section('title', 'Registrar Servicio')
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar servicio</h1>
                        <hr>

                        <!-- Inicio del formulario -->
                        <form id="servicioForm" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row  small-text-field">
                                <!-- Columnas de contenido -->
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <!-- Campo de Nombre del Servicio -->
                                        <div class="col-md-9">
                                            <label for="nombre" class="form-label">Nombre del servicio</label>
                                            <input type="text" name="nombre" class="form-control small-text-field @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Lavado, Planchado" maxlength="100" required>
                                            @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Campo de Precio -->
                                        <div class="col-md-3">
                                            <label for="precio" class="form-label">Precio en libras</label>
                                            <input type="text" name="precio" class="form-control small-text-field @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio') }}" placeholder="Ej: 100.00" required step="0.01">
                                            @error('precio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <!-- Campo de Descripción -->
                                        <div class="col-md-12">
                                            <label for="descripcion" class="form-label">Descripción del servicio</label>
                                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Servicio de lavado y planchado" maxlength="500" rows="3">{{ old('descripcion') }}</textarea>
                                            @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Columna de Artículos -->
                                        <div class="col-md-6">
                                            <label class="form-label">Artículos de la promoción</label>
                                            <div class="col-md-12 d-flex flex-column">
                                                @foreach(['Ropa casual', 'Ropa de cama', 'Peluches', 'Zapatos', 'Edredones', 'Almohadas', 'Manteles', 'Cojines', 'Alfombras', 'Tenis'] as $articulo)
                                                    <div class="custom-checkbox-wrapper">
                                                        <input class="custom-checkbox-input" type="checkbox" name="articulos[]" value="{{ $articulo }}" id="articulo_{{ $articulo }}" {{ in_array($articulo, old('articulos', [])) ? 'checked' : '' }}>
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
                                            <label class="form-label">Servicios extras de la promoción</label>
                                            <div class="col-md-12 d-flex flex-column">
                                                @foreach(['Detergente', 'Suavizante', 'Quitamanchas', 'Planchado', 'Secado', 'Recogida y entrega', 'Lavado'] as $extra)
                                                    <div class="custom-checkbox-wrapper">
                                                        <input class="custom-checkbox-input" type="checkbox" name="extras[]" value="{{ $extra }}" id="extra_{{ $extra }}" {{ in_array($extra, old('extras', [])) ? 'checked' : '' }}>
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
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('servicios.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Elementos del formulario
                const form = document.getElementById('servicioForm');
                const clearButton = document.getElementById('clearButton');

                // Función para capitalizar la primera letra de los inputs
                const capitalizeFirstLetter = (e) => {
                    e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
                };

                // Capitalizar en campos específicos (nombre, descripción, etc.)
                ['nombre', 'descripcion'].forEach((id) => {
                    document.getElementById(id).addEventListener('input', capitalizeFirstLetter);
                });

                // Validar el campo de precio para permitir solo números y decimales
                document.getElementById('precio').addEventListener('input', (e) => {
                    let valor = e.target.value;

                    // Elimina caracteres no permitidos (todo excepto números y un único punto)
                    valor = valor.replace(/[^0-9.]/g, '');

                    // Asegúrate de que solo haya un punto
                    if ((valor.match(/\./g) || []).length > 1) {
                        valor = valor.replace(/\.+$/, ''); // Elimina el último punto agregado
                    }

                    // Verifica la longitud máxima dependiendo de si contiene un punto o no
                    if (valor.includes('.')) {
                        e.target.value = valor.slice(0, 5); // Máximo 5 caracteres si hay un punto
                    } else {
                        e.target.value = valor.slice(0, 4); // Máximo 4 caracteres si no hay un punto
                    }
                });

                // Función para limpiar el formulario
                const clearForm = () => {
                    form.reset(); // Restablecer formulario

                    // Limpiar campos de texto
                    form.querySelectorAll('input, textarea, select').forEach((input) => {
                        if (input.type !== 'hidden') input.value = '';
                    });

                    // Reiniciar checkboxes
                    form.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => checkbox.checked = false);

                    // Eliminar clases de error
                    form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));

                    // Eliminar los mensajes de error
                    form.querySelectorAll('.invalid-feedback').forEach((el) => el.classList.remove('d-block'));
                };

                // Limpiar el formulario al hacer clic en el botón de "Limpiar"
                clearButton.addEventListener('click', clearForm);
            });
        </script>

    </section>
@endsection
