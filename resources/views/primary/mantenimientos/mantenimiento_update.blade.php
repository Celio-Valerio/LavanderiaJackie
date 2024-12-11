@extends('layouts.principal')
@section('title', 'Editar Mantenimiento')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Editar mantenimiento</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="mantenimientoForm" action="{{ route('mantenimientos.update', $mantenimiento->id) }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->
                            @method('PUT') <!-- Método PUT para actualización -->

                            <div class="row mb-3">

                                <!-- Campo de Maquinaria -->
                                <div class="col-md-6">
                                    <label for="maquinaria_id" class="form-label">Maquinaria</label>
                                    <select name="maquinaria_id" class="form-select @error('maquinaria_id') is-invalid @enderror" id="maquinaria_id" required disabled>
                                        <option value="">Selecciona una maquinaria</option>
                                        @foreach($maquinarias as $maquinaria)
                                            <option value="{{ $maquinaria->id }}" {{ old('maquinaria_id', $mantenimiento->maquinaria_id) == $maquinaria->id ? 'selected' : '' }}>
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
                                    <select name="maintenance_type" class="form-select @error('maintenance_type') is-invalid @enderror" id="maintenance_type" required disabled>
                                        <option value="">Selecciona un tipo</option>
                                        <option value="Preventivo" {{ old('maintenance_type', $mantenimiento->maintenance_type) == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                                        <option value="Correctivo" {{ old('maintenance_type', $mantenimiento->maintenance_type) == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
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
                                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price', $mantenimiento->price) }}" placeholder="Ej: 2000" maxlength="9" required>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Campo de Fecha -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Fecha del mantenimiento</label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date', $mantenimiento->date) }}" required disabled>
                                    @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Descripción -->
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Descripción del mantenimiento</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Descripción del mantenimiento" maxlength="500" rows="3">{{ old('description', $mantenimiento->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="resetButton">Reestablecer</button>
                                <a href="{{ route('mantenimientos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Función para reestablecer los valores del formulario
            document.getElementById('resetButton').addEventListener('click', function () {
                const form = document.getElementById('mantenimientoForm');

                // Reestablecer los valores a los iniciales (antes de la edición)
                form.reset();

                // Remover clases de validación (is-invalid) y ocultar mensajes de error
                const invalidElements = form.querySelectorAll('.is-invalid');
                invalidElements.forEach(function (element) {
                    element.classList.remove('is-invalid');
                });

                // Limpiar el campo de descripción (en caso de que se haya modificado)
                document.getElementById('description').value = '{{ old('description', $mantenimiento->description) }}';

                // Limpiar el campo de precio
                document.getElementById('price').value = '{{ old('price', $mantenimiento->price) }}';

                // Limpiar el campo de maquinaria (si es necesario)
                document.getElementById('maquinaria_id').value = '{{ old('maquinaria_id', $mantenimiento->maquinaria_id) }}';

                // Limpiar el select de tipo de mantenimiento
                document.getElementById('maintenance_type').value = '{{ old('maintenance_type', $mantenimiento->maintenance_type) }}';

                // Limpiar el campo de fecha
                document.getElementById('date').value = '{{ old('date', $mantenimiento->date) }}';
            });
        </script>

        <script>
            document.getElementById('price').addEventListener('input', function (event) {
                const input = event.target;
                let value = input.value.replace(/,/g, ''); // Eliminar comas temporalmente para procesar el número crudo

                // Validar número con hasta 5 dígitos antes del punto, un punto, y hasta 2 dígitos después
                const regex = /^\d{0,5}(\.\d{0,2})?$/;

                if (regex.test(value)) {
                    // Formatear con comas en la parte entera
                    const [integerPart, decimalPart] = value.split('.');
                    input.value = parseInt(integerPart || '0', 10).toLocaleString() + (decimalPart !== undefined ? '.' + decimalPart : '');
                } else {
                    // Si no es válido, revertir al valor anterior
                    input.value = input.value.slice(0, -1);
                }

                // Limitar la longitud total a 9 caracteres (incluyendo comas y punto)
                if (input.value.length > 9) {
                    input.value = input.value.slice(0, 9);
                }
            });

            // Antes de enviar el formulario, eliminar las comas para almacenar solo datos numéricos
            document.getElementById('mantenimientoForm').addEventListener('submit', function () {
                const priceInput = document.getElementById('price');
                priceInput.value = priceInput.value.replace(/,/g, ''); // Eliminar comas
            });
        </script>

    </section>
@endsection
