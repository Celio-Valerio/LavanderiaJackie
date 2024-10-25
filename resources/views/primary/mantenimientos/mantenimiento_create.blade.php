@extends('layouts.principal')
@section('title', 'Registrar Mantenimiento')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar Mantenimiento</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="mantenimientoForm" action="{{ route('mantenimientos.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">

                                <!-- Campo de Maquinaria -->
                                <div class="col-md-6">
                                    <label for="maquinaria_id" class="form-label">Maquinaria</label>
                                    <select name="maquinaria_id" class="form-select @error('maquinaria_id') is-invalid @enderror" id="maquinaria_id" required>
                                        <option value="">Selecciona una maquinaria</option>
                                        @foreach($maquinarias as $maquinaria)
                                            <option value="{{ $maquinaria->id }}" {{ old('maquinaria_id') == $maquinaria->id ? 'selected' : '' }}>
                                                {{ $maquinaria->name }} <!-- Asegúrate de que este campo corresponda al modelo Maquinaria -->
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('maquinaria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Tipo de Mantenimiento -->
                                <div class="col-md-6">
                                    <label for="maintenance_type" class="form-label">Tipo de Mantenimiento</label>
                                    <select name="maintenance_type" class="form-select @error('maintenance_type') is-invalid @enderror" id="maintenance_type" required>
                                        <option value="">Selecciona un tipo</option>
                                        <option value="Preventivo" {{ old('maintenance_type') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                                        <option value="Correctivo" {{ old('maintenance_type') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                                        <option value="Emergencia" {{ old('maintenance_type') == 'Emergencia' ? 'selected' : '' }}>Emergencia</option>
                                    </select>
                                    @error('maintenance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Precio -->
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Precio (Lempiras)</label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}" placeholder="Ej: 2000" min="1" max="100000" step="0.01" required>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Fecha -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Fecha del Mantenimiento</label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date') }}" required>
                                    @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Descripción -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Descripción del Mantenimiento</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Descripción del mantenimiento" maxlength="500" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('mantenimientos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Función para obtener la fecha actual en formato 'YYYY-MM-DD'
            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = ('0' + (today.getMonth() + 1)).slice(-2); // Añade un cero si es necesario
                const day = ('0' + today.getDate()).slice(-2); // Añade un cero si es necesario
                return `${year}-${month}-${day}`;
            }

            // Establecer la fecha actual al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('date').value = getCurrentDate();
            });
        </script>

        <script>
            // Función para limpiar el formulario
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('mantenimientoForm');

                // Limpiar los valores del formulario
                form.reset();

                // Remover clases de validación (is-invalid) y ocultar mensajes de error
                const invalidElements = form.querySelectorAll('.is-invalid');
                invalidElements.forEach(function (element) {
                    element.classList.remove('is-invalid');
                });

                // Limpiar el select de maquinaria
                document.getElementById('maquinaria_id').selectedIndex = 0;

                // Limpiar el select de tipo de mantenimiento
                document.getElementById('maintenance_type').selectedIndex = 0;

                // Limpiar el campo de descripción
                document.getElementById('description').value = '';

                // Limpiar el campo de fecha
                document.getElementById('date').value = '';

                const invalidFeedbacks = form.querySelectorAll('.invalid-feedback');
                invalidFeedbacks.forEach(function (feedback) {
                    feedback.style.display = 'none';
                });
            });
        </script>
    </section>
@endsection
