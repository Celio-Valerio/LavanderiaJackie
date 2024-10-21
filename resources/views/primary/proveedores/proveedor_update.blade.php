@extends('layouts.principal')
@section('title', 'Editar Proveedor')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Actualizar Proveedor</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="proveedorForm" action="{{ route('proveedores.update', $proveedor->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Proveedor -->
                                <div class="col-md-9">
                                    <label for="full_name" class="form-label">Nombre del Proveedor</label>
                                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" id="full_name" value="{{ old('full_name', $proveedor->full_name) }}" placeholder="Ej: Juan Pérez" maxlength="100" required>
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono -->
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $proveedor->phone) }}" placeholder="Ej: 90123456" maxlength="8" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Nombre de la Empresa -->
                                <div class="col-md-9">
                                    <label for="company_name" class="form-label">Nombre de la Empresa</label>
                                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" id="company_name" value="{{ old('company_name', $proveedor->company_name) }}" placeholder="Ej: Proveedor S.A." maxlength="100" required>
                                    @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono de la Empresa -->
                                <div class="col-md-3">
                                    <label for="company_phone" class="form-label">Teléfono de la Empresa</label>
                                    <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" id="company_phone" value="{{ old('company_phone', $proveedor->company_phone) }}" placeholder="Ej: 90123498" maxlength="8" required>
                                    @error('company_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $proveedor->email) }}" placeholder="Ej: proveedor@empresa.com" maxlength="50">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Categoría -->
                                <div class="col-md-3">
                                    <label for="categoria_id" class="form-label">Categoría (Insumo)</label>
                                    <select name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" required>
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

                                <!-- Campo de Ciudad -->
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
                                            "Yoro", "Pueblo Nuevo", "Tocoa", "Pespire", "La Fortuna", "La Masica", "Santa Rosa",
                                            // (continúa hasta completar los 298 municipios)
                                        ];
                                    ?>

                                    <!-- Campo de Ciudad -->
                                    <div class="col-md-3">
                                    <label for="city" class="form-label">Ciudad</label>
                                    <select name="city" class="form-select @error('city') is-invalid @enderror" id="city" required>
                                        <option value="">Selecciona una ciudad</option>
                                        @foreach($municipios as $municipio)
                                            <option value="{{ $municipio }}" {{ old('city', $proveedor->city) == $municipio ? 'selected' : '' }}>
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
                                <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror" id="company_address" placeholder="Ej: Calle Principal 123" maxlength="500" rows="3">{{ old('company_address', $proveedor->company_address) }}</textarea>
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
            
            // Almacena los valores iniciales del formulario
            const form = document.getElementById('proveedorForm');
            const initialValues = new FormData(form);

            document.getElementById('reloadButton').addEventListener('click', function() {
                // Restaura los valores anteriores
                for (const [key, value] of initialValues.entries()) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = value; // Restaura el valor
                    }
                }
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
