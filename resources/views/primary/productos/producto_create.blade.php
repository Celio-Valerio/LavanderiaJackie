@extends('layouts.principal')
@section('title', 'Registrar Producto')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar producto</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="productoForm" action="{{ route('productos.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Producto -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre del producto</label>
                                    <input type="text" name="nombre" class="form-control small-text-field @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Jabón Líquido" maxlength="50" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                    <?php
                                    $presentacion = [
                                        "Litros", "Kilogramos","Bolsas"
                                    ];
                                    ?>
                                    <!-- Campo de presentación -->
                                <div class="col-md-6">
                                    <label for="presentacion" class="form-label">Presentación</label>
                                    <select name="presentacion" class="form-select small-text-field @error('presentacion') is-invalid @enderror" id="presentacion" required>
                                        <option value="">Selecciona una presentación</option>
                                        @foreach($presentacion as $opcion)
                                            <option value="{{ $opcion }}" {{ old('presentacion') == $opcion ? 'selected' : '' }}>
                                                {{ $opcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('presentacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Precio -->
                                <div class="col-md-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="text" name="precio" class="form-control small-text-field @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio') }}" placeholder="Ej: 99.99" required>
                                    @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Proveedor -->
                                <div class="col-md-6">
                                    <label for="proveedor_id" class="form-label">Proveedor</label>
                                    <select name="proveedor_id" class="form-select small-text-field @error('proveedor_id') is-invalid @enderror" id="proveedor_id" required>
                                        <option value="">Selecciona un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->full_name }} - {{ $proveedor->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Descripción -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control small-text-field @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Descripción del producto" maxlength="500" rows="3">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo oculto para categoría -->
                            <input type="hidden" name="categoria_id" value="2"> <!-- Establecer la categoría siempre en 2 (Producto) -->

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('productos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Validación del precio (solo 7 dígitos y dos decimales después del punto)
            document.getElementById('precio').addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');  // Limita a un punto decimal
                if (e.target.value.includes('.')) {
                    const [integer, decimal] = e.target.value.split('.');
                    e.target.value = integer.slice(0, 4) + '.' + (decimal ? decimal.slice(0, 2) : '');
                } else {
                    e.target.value = e.target.value.slice(0, 4);
                }
            });

            // Capitalizar primera letra del nombre
            document.getElementById('nombre').addEventListener('input', function (e) {
                e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            });

            // Capitalizar primera letra del nombre
            document.getElementById('descripcion').addEventListener('input', function (e) {
                e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            });

            // Validar el campo de porcentaje de descuento
            document.getElementById('discount').addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 5);
            });
        </script>

        <script>
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('productoForm');

                // Limpiar los valores del formulario
                form.reset();

                // Limpiar los campos manualmente para evitar restauración por old()
                form.querySelectorAll('input:not([type="hidden"]), textarea').forEach(function (input) {
                    input.value = '';  // Borra el valor del campo
                });

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
