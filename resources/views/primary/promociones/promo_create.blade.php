@extends('layouts.principal')
@section('title', 'Registrar Promoción')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar promoción</h1>
                        <hr>

                        <!-- Inicio del formulario -->
                        <form id="promoForm" action="{{ route('promociones.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row  small-text-field">
                                <!-- Columnas de contenido -->
                                <div class="col-md-8">
                                    <div class="row mb-3">
                                        <!-- Campo de Nombre de la Promoción -->
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Nombre de la promoción</label>
                                            <input type="text" name="name" class="form-control small-text-field @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Ej: Promoción especial" maxlength="50" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Campo de Descuento -->
                                        <div class="col-md-6">
                                            <label for="discount" class="form-label">Descuento (%)</label>
                                            <input type="text" name="discount" class="form-control small-text-field @error('discount') is-invalid @enderror" id="discount" value="{{ old('discount') }}" placeholder="Ej: 20" required>
                                            @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                            <?php
                                            $promos = [
                                                "Ropa habitual de 21 a 49 libras",
                                                "Lavado y secado -20 libras",
                                                "Sabanas, cubrecolchón y sobrefundas",
                                                "Lavados y secados +50 libras",
                                                "Peluches, almohadas y cojines",
                                                "Edredones"
                                            ];
                                            ?>

                                            <!-- Campo de departamento -->
                                        <div class="col-md-6">
                                            <label for="promo" class="form-label">Promoción</label>
                                            <select name="promo" class="form-select small-text-field @error('promo') is-invalid @enderror" id="promo" required>
                                                <option value="">Selecciona una promoción</option>
                                                @foreach($promos as $promo)
                                                    <option value="{{ $promo }}" {{ old('promo') == $promo ? 'selected' : '' }}>
                                                        {{ $promo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('promo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Campo de Dirección -->
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Notas</label>
                                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="notes" placeholder="Ej: Notas básicas al respecto" maxlength="500" rows="3">{{ old('notes') }}</textarea>
                                        @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Columna de la Imagen -->
                                <div class="col-md-4 d-flex flex-column align-items-center">
                                    <div class="mb-3" style="width: 100%; text-align: center;">
                                        <label for="image" class="form-label">Imagen de la Promoción</label>
                                        <!-- Div de imagen en gris, centrado -->
                                        <div class="mb-3 image-preview-wrapper" style="position: relative; width: 100%; max-width: 300px; height: 200px;">
                                            <div class="image-preview-border" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 3px dashed #b0b0b0; border-radius: 5px; pointer-events: none;"></div>
                                            <div id="imagePreviewContainer" class="image-preview-container" style="width: 100%; height: 100%; background-color: #f0f0f0; border-radius: 5px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                <img id="imagePreview" src="{{ old('image') ? asset('storage/' . old('image')) : '#' }}" alt="Vista previa de la imagen" style="max-width: 100%; max-height: 100%; display: {{ old('image') ? 'block' : 'none' }};">
                                            </div>
                                        </div>

                                        <!-- Botón para seleccionar imagen -->
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Mostrar nombre del archivo si existe -->
                                        @if(old('image'))
                                            <small class="text-muted">Archivo: {{ basename(old('image')) }}</small>
                                        @endif
                                    </div>
                                </div>

                                <!-- Campo de Días de la Promoción -->
                                <div class="row mb-3">
                                    <label class="form-label">Días de la promoción</label>
                                    <div class="col-md-12 d-flex flex-wrap">
                                        <!-- Todos los días en una sola fila -->
                                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" name="days[]" value="{{ $day }}" id="day_{{ $day }}" {{ in_array($day, old('days', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label small-text-field" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('days')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('promociones.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const colorThief = new ColorThief();

                // Cambiar el fondo del contenedor cuando se carga una imagen
                if (imagePreview.src !== '#') {
                    imagePreview.addEventListener('load', function() {
                        // Obtener el color dominante de la imagen
                        const dominantColor = colorThief.getColor(imagePreview);
                        // Cambiar el fondo del contenedor al color dominante
                        imagePreviewContainer.style.backgroundColor = `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;
                    });

                    // También establecer el fondo inicial si ya hay una imagen
                    imagePreview.addEventListener('load', function() {
                        const dominantColor = colorThief.getColor(imagePreview);
                        imagePreviewContainer.style.backgroundColor = `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;
                    });
                }
            });
        </script>

        <script>
            // Capitalizar primera letra del nombre
            document.getElementById('name').addEventListener('input', function (e) {
                e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            });

            document.getElementById('notes').addEventListener('input', function (e) {
                e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            });

            // Validación de porcentaje (solo dos dígitos del 1 al 9)
            document.getElementById('discount').addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 2);
            });

            // Mostrar vista previa de la imagen seleccionada
            document.getElementById('image').addEventListener('change', function (event) {
                const file = event.target.files[0];
                const preview = document.getElementById('imagePreview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                    preview.src = '#';
                }
            });

            // Limpiar el formulario
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('promoForm');
                form.reset();
                document.getElementById('imagePreview').style.display = 'none';

                // Remover clases de validación
                form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach((el) => el.style.display = 'none');
            });
        </script>

        <script>
            // Función para limpiar los campos del formulario de promoción y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('promoForm');

                // Limpiar los valores del formulario
                form.reset();

                // Limpiar los campos manualmente para evitar restauración por old()
                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden') { // No limpiar campos ocultos
                        input.value = '';
                    }
                });

                // Limpiar el select de promoción
                document.getElementById('promo').selectedIndex = 0;

                // Limpiar los checkboxes de días de la promoción
                form.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                    checkbox.checked = false;
                });

                // Limpiar vista previa de la imagen
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
                document.getElementById('imagePreviewContainer').style.backgroundColor = '#f0f0f0';

                // También puedes eliminar las clases de error de validación
                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
            });
        </script>

    </section>
@endsection
