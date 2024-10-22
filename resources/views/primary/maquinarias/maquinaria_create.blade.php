@extends('layouts.principal')
@section('title', 'Registrar Maquinaria')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar Maquinaria</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="maquinariaForm" action="{{ route('maquinarias.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre de Maquinaria -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nombre de la Maquinaria</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Ej: Lavadora Industrial" maxlength="100" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Marca -->
                                <div class="col-md-6">
                                    <label for="brand" class="form-label">Marca</label>
                                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" id="brand" value="{{ old('brand') }}" placeholder="Ej: Whirlpool" maxlength="50" required>
                                    @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Modelo -->
                                <div class="col-md-6">
                                    <label for="model" class="form-label">Modelo</label>
                                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" id="model" value="{{ old('model') }}" placeholder="Ej: XYZ-123" maxlength="50" required>
                                    @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Fecha de Ingreso -->
                                <div class="col-md-3">
                                    <label for="acquisition_date" class="form-label">Fecha de Adquisición</label>
                                    <input type="date" name="acquisition_date" class="form-control @error('acquisition_date') is-invalid @enderror" id="acquisition_date" value="{{ old('acquisition_date') }}" required>
                                    @error('acquisition_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Estado</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" id="status" required>
                                        <option value="" disabled selected>Seleccione el estado de la maquina</option>
                                        <option value="Operativa" {{ old('status') == 'Operativa' ? 'selected' : '' }}>Operativa</option>
                                        <option value="En mantenimiento" {{ old('status') == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                        <option value="Dada de baja" {{ old('status') == 'Dada de baja' ? 'selected' : '' }}>Dada de baja</option>
                                        <option value="Pendiente de revisión" {{ old('status') == 'Pendiente de revisión' ? 'selected' : '' }}>Pendiente de revisión</option>
                                        <option value="En reparación" {{ old('status') == 'En reparación' ? 'selected' : '' }}>En reparación</option>
                                        <option value="Requiere repuestos" {{ old('status') == 'Requiere repuestos' ? 'selected' : '' }}>Requiere repuestos</option>
                                        <option value="En espera de piezas" {{ old('status') == 'En espera de piezas' ? 'selected' : '' }}>En espera de piezas</option>
                                        <option value="Programada para actualización" {{ old('status') == 'Programada para actualización' ? 'selected' : '' }}>Programada para actualización</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Proveedor -->
                                <div class="col-md-6">
                                    <label for="proveedor_id" class="form-label">Proveedor</label>
                                    <select name="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" id="proveedor_id" required>
                                        <option value="">Selecciona un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->full_name }} <!-- Asegúrate de que este campo corresponda al modelo Puesto -->
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Tipo -->
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Tipo de Maquinaria</label>
                                    <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" id="type" value="{{ old('type') }}" placeholder="Ej: Industrial" maxlength="50" required>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('maquinarias.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
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
            // Función para limpiar los campos del formulario y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('maquinariaForm');
                form.reset();

                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden') {
                        input.value = '';
                    }
                });

                document.getElementById('supplier_id').selectedIndex = 0;

                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
            });
        </script>

    </section>
@endsection
