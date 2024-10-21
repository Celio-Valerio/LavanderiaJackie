@extends('layouts.principal')
@section('title', 'Registrar Proveedor')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar Proveedor</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="proveedorForm" action="{{ route('proveedores.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Proveedor -->
                                <div class="col-md-9">
                                    <label for="full_name" class="form-label">Nombre del Proveedor</label>
                                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" id="full_name" value="{{ old('full_name') }}" placeholder="Ej: Juan Pérez" maxlength="100" required>
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono -->
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" placeholder="Ej: 90123456" maxlength="8" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Nombre de la Empresa -->
                                <div class="col-md-9">
                                    <label for="company_name" class="form-label">Nombre de la Empresa</label>
                                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" id="company_name" value="{{ old('company_name') }}" placeholder="Ej: Proveedor S.A." maxlength="100" required>
                                    @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono de la Empresa -->
                                <div class="col-md-3">
                                    <label for="company_phone" class="form-label">Teléfono de la Empresa</label>
                                    <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" id="company_phone" value="{{ old('company_phone') }}" placeholder="Ej: 90123498" maxlength="8" required>
                                    @error('company_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Ej: proveedor@empresa.com" maxlength="50">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="categoria_id" class="form-label">Categoría</label>
                                    <select name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" required>
                                        <option value="">Selecciona una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->name }} <!-- Asegúrate de que este campo corresponda al modelo Categoria -->
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                    <?php
                                    $municipios = [
                                        "Danlí", "Tegucigalpa", "San Pedro Sula", "Comayagua", "Cortes", "La Ceiba", "Choluteca",
                                        "Santa Rosa de Copán", "Gracias", "Juticalpa", "Puerto Cortes", "La Esperanza", "Olancho",
                                        "Tocoa", "Nacaome", "Guaimaca", "Tegucigalpita", "Intibucá", "Pespire", "Colón",
                                        "El Paraíso", "La Libertad", "San Lorenzo", "Siguatepeque", "Lempira", "Marcala",
                                        "Ocotepeque", "Santa Bárbara", "Valle", "Yoro", "La Paz", "Camasca", "Campamento",
                                        "San Antonio de Flores", "Santa Cruz de Yojoa", "La Paz", "San Manuel de Colohete",
                                        "Potrerillos", "El Porvenir", "Quebrada de Agua", "El Negrito", "Talgua", "Tocoa",
                                        "Manto", "El Paraíso", "San Miguelito", "Cerro Verde", "San Antonio", "San Ignacio",
                                        "Yoro", "Pueblo Nuevo", "Tocoa", "Pespire", "La Fortuna", "La Masica",
                                        // (continúa hasta completar los 298 municipios)
                                    ];
                                    ?>

                                    <!-- Campo de Ciudad para Crear Proveedor -->
                                <div class="col-md-3">
                                    <label for="city" class="form-label">Ciudad</label>
                                    <select name="city" class="form-select @error('city') is-invalid @enderror" id="city" required>
                                        <option value="">Selecciona una ciudad</option>
                                        @foreach($municipios as $municipio)
                                            <option value="{{ $municipio }}" {{ old('city') == $municipio ? 'selected' : '' }}>
                                                {{ $municipio }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Campo de Dirección -->
                            <div class="mb-3">
                                <label for="company_address" class="form-label">Dirección</label>
                                <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror" id="company_address" placeholder="Ej: Calle Principal 123" maxlength="500" rows="3">{{ old('company_address') }}</textarea>
                                @error('company_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('proveedores.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

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
            }

            // Función para restringir la entrada de números y caracteres especiales
            function restrictInput(e) {
                let key = e.key;
                let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]*$/;

                if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                    e.preventDefault();
                }
            }

            // Asignar eventos a los campos full_name
            document.getElementById('full_name').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('full_name').addEventListener('keydown', function(e) {
                restrictInput(e);
            });

            // Función para capitalizar la primera letra del input
            function capitalizeFirstLetter(input) {
                let value = input.value;
                input.value = value.charAt(0).toUpperCase() + value.slice(1);
            }

            // Asignar evento al campo Nombre de Empresa y Dirección para capitalizar la primera letra
            document.getElementById('company_name').addEventListener('input', function(e) {
                capitalizeFirstLetter(e.target);
            });

            document.getElementById('company_address').addEventListener('input', function(e) {
                capitalizeFirstLetter(e.target);
            });
        </script>

        <script>
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('proveedorForm');

                // Limpiar los valores del formulario
                form.reset();

                // Limpiar los campos manualmente para evitar restauración por old()
                // Excluimos los campos ocultos como el token CSRF
                form.querySelectorAll('input:not([type="hidden"]), textarea').forEach(function (input) {
                    input.value = '';  // Borra el valor del campo
                });

                // Limpiar el select de categoría
                document.getElementById('categoria_id').selectedIndex = 0;

                // Limpiar el select de ciudad
                document.getElementById('city').selectedIndex = 0;

                // Remover clases de validación (is-invalid) y ocultar mensajes de error
                const invalidElements = form.querySelectorAll('.is-invalid');
                invalidElements.forEach(function (element) {
                    element.classList.remove('is-invalid');
                });

                const invalidFeedbacks = form.querySelectorAll('.invalid-feedback');
                invalidFeedbacks.forEach(function (feedback) {
                    feedback.style.display = 'none';
                });
            });
        </script>

    </section>
@endsection
