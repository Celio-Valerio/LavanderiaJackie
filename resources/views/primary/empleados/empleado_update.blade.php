@extends('layouts.principal')
@section('title', 'Actualizar empleado')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Actualizar Empleado</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="empleadoForm" action="{{ route('empleados.update', $empleado->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT') <!-- Enviar método PUT para la actualización -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">Nombre</label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name', $empleado->first_name) }}" placeholder="Ej: Juan" maxlength="50" required>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Apellido -->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Apellido</label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name', $empleado->last_name) }}" placeholder="Ej: Pérez" maxlength="50" required>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $empleado->email) }}" placeholder="Ej: ejemplo@gmail.com" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Puesto -->
                                <div class="col-md-6">
                                    <label for="puesto_id" class="form-label">Puesto</label>
                                    <select name="puesto_id" class="form-select @error('puesto_id') is-invalid @enderror" id="puesto_id" required>
                                        <option value="">Selecciona un puesto</option>
                                        @foreach($puestos as $puesto)
                                            <option value="{{ $puesto->id }}" {{ (old('puesto_id') == $puesto->id || $empleado->puesto_id == $puesto->id) ? 'selected' : '' }}>
                                                {{ $puesto->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('puesto_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Teléfono -->
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $empleado->phone) }}" placeholder="Ej: 90123456" maxlength="8" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Fecha de Ingreso -->
                                <div class="col-md-3">
                                    <label for="hire_date" class="form-label">Fecha de Ingreso</label>
                                    <input type="date" name="hire_date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" value="{{ old('hire_date', $empleado->hire_date) }}" required>
                                    @error('hire_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Salario -->
                                <div class="col-md-3">
                                    <label for="salary" class="form-label">Salario</label>
                                    <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" id="salary" value="{{ old('salary', $empleado->salary) }}" placeholder="Ej: 2000" min="1500" max="5000" step="0.01" required>
                                    @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Dirección -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Dirección</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Ej: Calle Principal 123" maxlength="500" rows="3">{{ old('address', $empleado->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                <a href="{{ route('empleados.index') }}" class="btn btn-danger flex-fill">Regresar</a>
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

            // Asignar eventos a los campos first_name y last_name
            document.getElementById('first_name').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('first_name').addEventListener('keydown', function(e) {
                restrictInput(e);
            });

            document.getElementById('last_name').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('last_name').addEventListener('keydown', function(e) {
                restrictInput(e);
            });

            // Guardar los valores iniciales
            const initialValues = {
                firstName: "{{ old('first_name', $empleado->first_name) }}",
                lastName: "{{ old('last_name', $empleado->last_name) }}",
                email: "{{ old('email', $empleado->email) }}",
                phone: "{{ old('phone', $empleado->phone) }}",
                address: "{{ old('address', $empleado->address) }}",
                salary: "{{ old('salary', $empleado->salary) }}",
                puesto_id: "{{ old('puesto_id', $empleado->puesto_id) }}"
            };

            // Recargar los valores originales al hacer clic en el botón Recargar
            document.getElementById('reloadButton').addEventListener('click', function () {
                const form = document.getElementById('empleadoForm');
                form.first_name.value = initialValues.firstName;
                form.last_name.value = initialValues.lastName;
                form.email.value = initialValues.email;
                form.phone.value = initialValues.phone;
                form.address.value = initialValues.address;
                form.salary.value = initialValues.salary;
                form.puesto_id.value = initialValues.puesto_id;
            });
        </script>

    </section>

@endsection
