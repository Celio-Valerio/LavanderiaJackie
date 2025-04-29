@extends('layouts.principal')
    @section('title', 'Actualizar Maquinaria')
    @section('content')

        <section class="section">

            <div class="row">
                @if($usuario->rolpermiso->maquinas_editar == 1)
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title" style="font-size: 30px !important;">Actualizar maquinaria</h1>
                                <hr>
                                <!-- Inicio del formulario -->
                                <form id="maquinariaForm" action="{{ route('maquinarias.update', $maquinaria->id) }}" method="POST" novalidate>
                                    @csrf
                                    @method('PUT') <!-- Método PUT para la actualización -->

                                    <div class="row mb-3">
                                        <!-- Campo de Nombre de Maquinaria -->
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nombre de la maquinaria</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $maquinaria->name) }}" placeholder="Ej: Lavadora Industrial" maxlength="50 " required> <!-- Cambiado a 20 caracteres -->
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Campo de Marca -->
                                        <div class="col-md-6">
                                            <label for="brand" class="form-label">Marca</label>
                                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" id="brand" value="{{ old('brand', $maquinaria->brand) }}" placeholder="Ej: Whirlpool" maxlength="20" required> <!-- Cambiado a 10 caracteres -->
                                            @error('brand')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Campo de Modelo -->
                                        <div class="col-md-6">
                                            <label for="model" class="form-label">Modelo</label>
                                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" id="model" value="{{ old('model', $maquinaria->model) }}" placeholder="Ej: XYZ-123" maxlength="30" required> <!-- Cambiado a 10 caracteres -->
                                            @error('model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Campo de Fecha de Ingreso -->
                                        <div class="col-md-3">
                                            <label for="acquisition_date" class="form-label">Fecha de adquisición</label>
                                            <input type="date" name="acquisition_date" class="form-control @error('acquisition_date') is-invalid @enderror" id="acquisition_date" value="{{ old('acquisition_date', $maquinaria->acquisition_date) }}" required>
                                            @error('acquisition_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="status" class="form-label">Estado</label>
                                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status" required>
                                                <option value="" disabled>Seleccione el estado de la maquina</option>
                                                <option value="Nuevo" {{ old('status', $maquinaria->status) == 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                                                <option value="Usado" {{ old('status', $maquinaria->status) == 'Usado' ? 'selected' : '' }}>Usado</option>
                                                <option value="En mantenimiento" {{ old('status', $maquinaria->status) == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                                @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        </select>
                                        </select>

                                        <p></p>
                                        <!-- Campo de Proveedor -->
                                        <div class="col-md-6">
                                            <label for="proveedor_id" class="form-label">Proveedor</label>
                                            <input type="text" class="form-control" id="proveedor_id" value="{{ old('proveedor_id', $maquinaria->proveedor->full_name) }}" readonly>
                                            @error('proveedor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <p></p>

                                    <div class="row mb-3">
                                        <!-- Campo de Tipo -->
                                        <div class="col-md-6">
                                            <label for="type" class="form-label">Tipo de maquinaria</label>
                                            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" id="type" value="{{ old('type', $maquinaria->type) }}" placeholder="Ej: Industrial" maxlength="20" required> <!-- Cambiado a 20 caracteres -->
                                            @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                        <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                        <a href="{{ route('maquinarias.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                                    </div>
                                </form>
                                <!-- Fin del formulario -->

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
            </div>

            <script>
                // Función para capitalizar la primera letra
                function capitalizeFirstLetter(input) {
                    let value = input.value.toLowerCase();
                    input.value = value.replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
                }

                // Función para restringir la entrada de caracteres especiales
                function restrictInput(e) {
                    let key = e.key;
                    let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s]*$/;

                    if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                        e.preventDefault();
                    }
                }

                // Asignar eventos para los campos de texto
                document.getElementById('name').addEventListener('input', function(e) {
                    capitalizeFirstLetter(e.target);
                });

                document.getElementById('name').addEventListener('keydown', function(e) {
                    restrictInput(e);
                });

                document.getElementById('brand').addEventListener('input', function(e) {
                    capitalizeFirstLetter(e.target);
                });

                document.getElementById('brand').addEventListener('keydown', function(e) {
                    restrictInput(e);
                });
            </script>

            <script>
                document.getElementById('reloadButton').addEventListener('click', function () {
                    const maquinariaId = "{{ $maquinaria->id }}"; // Obtener el ID de la maquinaria

                    // Hacer una solicitud AJAX para obtener los datos más recientes de la maquinaria
                    fetch(`/maquinarias/${maquinariaId}/reload`)
                        .then(response => response.json())
                        .then(data => {
                            // Actualizar los valores del formulario con los datos del servidor
                            document.getElementById('name').value = data.name;
                            document.getElementById('brand').value = data.brand;
                            document.getElementById('model').value = data.model;
                            document.getElementById('acquisition_date').value = data.acquisition_date;
                            document.getElementById('type').value = data.type;
                            document.getElementById('status').value = data.status;

                            // Actualizar el select de proveedor
                            const proveedorSelect = document.getElementById('proveedor_id');
                            proveedorSelect.value = data.proveedor_id; // Asignar el valor actual del proveedor
                        })
                        .catch(error => {
                            console.error('Error al recargar los datos de la maquinaria:', error);
                        });

                });

                // Nueva función para restablecer los datos del formulario
                document.getElementById('reloadButton').addEventListener('click', function () {
                    // Restablecer los valores del formulario a los originales
                    document.getElementById('name').value = "{{ old('name', $maquinaria->name) }}";
                    document.getElementById('brand').value = "{{ old('brand', $maquinaria->brand) }}";
                    document.getElementById('model').value = "{{ old('model', $maquinaria->model) }}";
                    document.getElementById('acquisition_date').value = "{{ old('acquisition_date', $maquinaria->acquisition_date) }}";
                    document.getElementById('type').value = "{{ old('type', $maquinaria->type) }}";
                    document.getElementById('status').value = "{{ old('status', $maquinaria->status) }}";
                    document.getElementById('proveedor_id').value = "{{ old('proveedor_id', $maquinaria->proveedor->full_name) }}"; // Restablecer proveedor
                });
            </script>
        </section>
    @endsection
