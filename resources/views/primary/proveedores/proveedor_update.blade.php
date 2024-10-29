@extends('layouts.principal')
@section('title', 'Editar Proveedor')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Actualizar proveedor</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="proveedorForm" action="{{ route('proveedores.update', $proveedor->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <!-- Campo de Nombre de la Empresa -->
                                <div class="col-md-4">
                                    <label for="company_name" class="form-label">Nombre de la empresa</label>
                                    <input type="text" name="company_name" class="form-control small-text-field @error('company_name') is-invalid @enderror" id="company_name" value="{{ old('company_name', $proveedor->company_name) }}" placeholder="Ej: Proveedor S.A." maxlength="100" required>
                                    @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono de la Empresa -->
                                <div class="col-md-4">
                                    <label for="company_phone" class="form-label">Teléfono de la empresa</label>
                                    <input type="text" name="company_phone" class="form-control small-text-field @error('company_phone') is-invalid @enderror" id="company_phone" value="{{ old('company_phone', $proveedor->company_phone) }}" placeholder="Ej: 90123498" maxlength="8" required>
                                    @error('company_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Email -->
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control small-text-field @error('email') is-invalid @enderror" id="email" value="{{ old('email', $proveedor->email) }}" placeholder="Ej: proveedor@empresa.com" maxlength="50">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Proveedor -->
                                <div class="col-md-4">
                                    <label for="full_name" class="form-label">Nombre del vendedor</label>
                                    <input type="text" name="full_name" class="form-control small-text-field @error('full_name') is-invalid @enderror" id="full_name" value="{{ old('full_name', $proveedor->full_name) }}" placeholder="Ej: Juan Pérez" maxlength="100" required>
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono -->
                                <div class="col-md-4">
                                    <label for="phone" class="form-label">Teléfono del vendedor</label>
                                    <input type="text" name="phone" class="form-control small-text-field @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $proveedor->phone) }}" placeholder="Ej: 90123456" maxlength="8" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Categoría -->
                                <div class="col-md-4">
                                    <label for="categoria_id" class="form-label">Categoría</label>
                                    <select name="categoria_id" class="form-select small-text-field @error('categoria_id') is-invalid @enderror" id="categoria_id" required>
                                        <option value="">Selecciona una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                {{ old('categoria_id', $proveedor->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Ciudad -->
                                    <?php
                                        $departamentos = [
                                            "Atlántida", "Colón", "Comayagua", "Copán", "Cortés", "Choluteca", "El Paraíso", "Francisco Morazán",
                                            "Gracias a Dios", "Intibucá", "Islas de la Bahía", "La Paz", "Lempira", "Ocotepeque", "Olancho", "Santa Bárbara",
                                            "Valle", "Yoro"
                                        ];
                                    ?>

                                    <!-- Campo de Ciudad -->
                                    <div class="col-md-4">
                                    <label for="city" class="form-label">Departamento</label>
                                    <select name="city" class="form-select small-text-field @error('city') is-invalid @enderror" id="city" required>
                                        <option value="">Selecciona un departamento</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento }}" {{ old('city', $proveedor->city) == $departamento ? 'selected' : '' }}>
                                                {{ $departamento }}
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
                                <textarea name="company_address" class="form-control small-text-field @error('company_address') is-invalid @enderror" id="company_address" placeholder="Ej: Calle Principal 123" maxlength="500" rows="3">{{ old('company_address', $proveedor->company_address) }}</textarea>
                                @error('company_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
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
            document.getElementById('reloadButton').addEventListener('click', function () {
                const proveedorId = "{{ $proveedor->id }}"; // Obtener el ID del cliente

                // Hacer una solicitud AJAX para obtener los datos más recientes del cliente
                fetch(`/proveedores/${proveedorId}/reload`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar los valores del formulario con los datos del servidor
                        document.getElementById('full_name').value = data.full_name;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('company_name').value = data.company_name;
                        document.getElementById('company_phone').value = data.company_phone;
                        document.getElementById('email').value = data.email;
                        document.getElementById('company_address').value = data.company_address;

                        // Actualizar el select de categoría
                        const categoriaSelect = document.getElementById('categoria_id');
                        categoriaSelect.value = data.categoria_id; // Asignar el valor actual de la categoría

                        // Actualizar el select de categoría
                        const ciudadSelect = document.getElementById('city');
                        ciudadSelect.value = data.city; // Asignar el valor actual de la categoría

                    })
            });
        </script>

    </section>
@endsection
