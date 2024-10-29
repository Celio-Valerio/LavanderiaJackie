@extends('layouts.principal')
@section('title', 'Editar cliente')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Actualizar cliente</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="clienteForm" action="{{ route('clientes.update', $cliente->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <!-- Campo de Nombre -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">Nombre</label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name', $cliente->first_name) }}" maxlength="50" required>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Apellido -->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Apellido</label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name', $cliente->last_name) }}" maxlength="50" required>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $cliente->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Teléfono -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $cliente->phone) }}" maxlength="8" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Tipo de Cliente -->
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Tipo de Cliente</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror" id="type" required>
                                        <option value="Contado" {{ old('type', $cliente->type) === 'Contado' ? 'selected' : '' }}>Contado</option>
                                        <option value="Credito" {{ old('type', $cliente->type) === 'Credito' ? 'selected' : '' }}>Crédito</option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Dirección -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Dirección</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" maxlength="500" rows="3">{{ old('address', $cliente->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                <a href="{{ route('clientes.index') }}" class="btn btn-danger flex-fill">Regresar</a>
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
        </script>

        <script>
            // Función para capitalizar solo la primera letra de la primera palabra
            function capitalizeFirstLetter(input) {
                let value = input.value;
                input.value = value.charAt(0).toUpperCase() + value.slice(1);
            }

            // Función para restringir caracteres si es necesario
            function restrictInput(e) {
                let key = e.key;
                let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s,.]*$/;

                if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                    e.preventDefault();
                }
            }

            // Asignar eventos al campo address
            document.getElementById('address').addEventListener('input', function(e) {
                capitalizeFirstLetter(e.target);
            });
            document.getElementById('address').addEventListener('keydown', function(e) {
                restrictInput(e);
            });
        </script>

        <script>
            document.getElementById('reloadButton').addEventListener('click', function () {
                const clienteId = "{{ $cliente->id }}"; // Obtener el ID del cliente

                // Hacer una solicitud AJAX para obtener los datos más recientes del cliente
                fetch(`/clientes/${clienteId}/reload`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar los valores del formulario con los datos del servidor
                        document.getElementById('first_name').value = data.first_name;
                        document.getElementById('last_name').value = data.last_name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('address').value = data.address;
                        document.getElementById('type').value = data.type;
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>

    </section>
@endsection
