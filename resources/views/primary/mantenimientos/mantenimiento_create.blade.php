@extends('layouts.principal')
@section('title', 'Registrar Mantenimiento')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->mantenimiendo_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Registrar mantenimiento</h1>
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
                                                    {{ $maquinaria->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('maquinaria_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Tipo de Mantenimiento -->
                                    <div class="col-md-6">
                                        <label for="maintenance_type" class="form-label">Tipo de mantenimiento</label>
                                        <select name="maintenance_type" class="form-select @error('maintenance_type') is-invalid @enderror" id="maintenance_type" required>
                                            <option value="">Selecciona un tipo</option>
                                            <option value="Preventivo" {{ old('maintenance_type') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                                            <option value="Correctivo" {{ old('maintenance_type') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
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
                                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}" placeholder="Ej: 2000.00" required>
                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Fecha -->
                                    <div class="col-md-6">
                                        <label for="date" class="form-label">Fecha del mantenimiento</label>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date') }}" required>
                                        @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Campo de Descripción -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción del mantenimiento</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Descripción del mantenimiento" maxlength="500" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            // Establecer la fecha actual al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('date').value = new Date().toISOString().split('T')[0];
            });

            // Formatear descripción para iniciar con mayúscula
            document.getElementById('description').addEventListener('input', function(event) {
                const input = event.target;
                input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
            });

            // Función para limpiar el formulario
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('mantenimientoForm');
                form.reset();
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            });

            // Validación y formateo del campo de precio
            document.getElementById('price').addEventListener('input', function(event) {
                const input = event.target;
                let value = input.value.replace(/,/g, ''); // Eliminar comas temporalmente para procesar el número crudo

                // Validar número con hasta 5 dígitos antes del punto, un punto, y hasta 2 dígitos después
                const regex = /^\d{0,5}(\.\d{0,2})?$/;

                if (regex.test(value)) {
                    const [integerPart, decimalPart] = value.split('.');
                    input.value = parseInt(integerPart || '0', 10).toLocaleString() + (decimalPart !== undefined ? '.' + decimalPart : '');
                } else {
                    input.value = input.value.slice(0, -1);
                }

                // Limitar la longitud total a 9 caracteres (incluyendo comas y punto)
                if (input.value.length > 9) {
                    input.value = input.value.slice(0, 9);
                }
            });

            // Eliminar las comas antes de enviar el formulario
            document.getElementById('mantenimientoForm').addEventListener('submit', function() {
                const priceInput = document.getElementById('price');
                priceInput.value = priceInput.value.replace(/,/g, '');
            });
        </script>
    </section>
@endsection
