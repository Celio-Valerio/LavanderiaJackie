@extends('layouts.principal')
@section('title', 'Editar Producto')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Editar Producto</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="productoForm" action="{{ route('productos.update', $producto->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT') <!-- Método PUT para actualizar -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Producto -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre del producto</label>
                                    <input type="text" name="nombre" class="form-control small-text-field @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre', $producto->nombre) }}" placeholder="Ej: Jabón Líquido" maxlength="50" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Presentación -->
                                <div class="col-md-6">
                                    <label for="presentacion" class="form-label">Presentación</label>
                                    <select name="presentacion" class="form-select small-text-field @error('presentacion') is-invalid @enderror" id="presentacion" required>
                                        <option value="Litros" {{ old('presentacion', $producto->presentacion) === 'Litros' ? 'selected' : '' }}>Litros</option>
                                        <option value="Kilogramos" {{ old('presentacion', $producto->presentacion) === 'Kilogramos' ? 'selected' : '' }}>Kilogramos</option>
                                        <option value="Bolsas" {{ old('presentacion', $producto->presentacion) === 'Bolsas' ? 'selected' : '' }}>Bolsas</option>
                                    </select>
                                    @error('presentacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Campo de Precio -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="text" name="precio" class="form-control small-text-field @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio', $producto->precio) }}" placeholder="Ej: 99.99" required>
                                    @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Descripción -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control small-text-field @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Descripción del producto" maxlength="500" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                    @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo oculto para categoría -->
                            <input type="hidden" name="categoria_id" value="2">

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                <a href="{{ route('productos.index') }}" class="btn btn-danger flex-fill">Cancelar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('productoForm');
                const reloadButton = document.getElementById('reloadButton');

                // Valores originales para restablecer el formulario
                const originalData = {
                    nombre: "{{ old('nombre', $producto->nombre) }}",
                    precio: "{{ old('precio', $producto->precio) }}",
                    presentacion: "{{ old('presentacion', $producto->presentacion) }}",
                    descripcion: `{{ old('descripcion', $producto->descripcion) }}`
                };

                // Función para restablecer el formulario
                const resetForm = () => {
                    document.getElementById('nombre').value = originalData.nombre;
                    document.getElementById('precio').value = originalData.precio;
                    document.getElementById('descripcion').value = originalData.descripcion;

                    // Restablecer select de presentación
                    const presentacionSelect = document.getElementById('presentacion');
                    Array.from(presentacionSelect.options).forEach(option => {
                        option.selected = option.value === originalData.presentacion;
                    });
                };

                reloadButton.addEventListener('click', resetForm);

                // Validación del campo de precio
                const precioInput = document.getElementById('precio');
                precioInput.addEventListener('input', () => {
                    const value = precioInput.value.replace(/[^\d.]/g, ''); // Eliminar caracteres no numéricos
                    const parts = value.split('.');

                    if (parts.length > 2) {
                        precioInput.value = parts[0] + '.' + parts[1]; // Solo permitir un punto decimal
                    } else if (parts.length === 2) {
                        parts[1] = parts[1].slice(0, 2); // Limitar a dos decimales
                        precioInput.value = parts.join('.');
                    } else {
                        precioInput.value = parts[0].slice(0, 4); // Limitar a 4 dígitos antes del punto
                    }
                });
            });
        </script>
    </section>
@endsection
