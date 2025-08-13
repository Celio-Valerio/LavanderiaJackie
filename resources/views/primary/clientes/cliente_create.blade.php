@extends('layouts.principal')
@section('title', 'Registrar cliente')
@section('content')

<section class="section">
        @if($usuario->rolpermiso->clientes_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Registrar cliente</h1>
                            <hr>
                            <!-- Inicio del formulario -->
                            <form id="clienteForm" action="{{ route('clientes.store') }}" method="POST" novalidate>
                                @csrf <!-- Protección contra CSRF -->
                                <input type="hidden" name="redirect_to" value="{{ old('redirect_to', url()->previous()) }}">

                                <div class="row mb-3">
                                    <!-- Campo de Nombre -->
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">Nombre</label>
                                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" placeholder="Ej: Gladys" maxlength="50" required>
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Apellido -->
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Apellido</label>
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" placeholder="Ej: Nolasco" maxlength="50" required>
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- Campo de Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Ej: ejemplo@gmail.com" maxlength="50" required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Teléfono -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" placeholder="Ej: 90123456" maxlength="8" required>
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
                                            <option value="" disabled selected>Seleccione el tipo de cliente</option>
                                            <option value="Contado" {{ old('type') == 'Contado' ? 'selected' : '' }}>Contado</option>
                                            <option value="Credito" {{ old('type') == 'Credito' ? 'selected' : '' }}>Crédito</option>
                                        </select>
                                        @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Campo de Dirección -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Ej: Calle Principal 123" maxlength="500" rows="3">{{ old('address') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                    <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger flex-fill">Regresar</a>
                                </div>
                            </form>
                            <!-- Fin del formulario -->

                        </div>
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

            <script>
                // Función para capitalizar la primera letra de cada palabra (soporta tildes)
                function capitalizeInput(input) {
                    let value = input.value.toLowerCase();

                    // Evitar espacios al inicio y dobles espacios
                    value = value.replace(/^\s+/, "").replace(/\s{2,}/g, " ");

                    // Capitalizar primera letra de cada palabra
                    input.value = value.replace(/(^|\s)([a-záéíóúñ])/gu, function(match, space, char) {
                        return space + char.toUpperCase();
                    });
                }

                // Función para restringir nombres y apellidos
                function restrictNameInput(e) {
                    let key = e.key;
                    let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]$/;

                    if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                        e.preventDefault();
                    }
                }

                // Función para capitalizar solo la primera letra (dirección)
                function capitalizeFirstLetter(input) {
                    let value = input.value;

                    // Evitar espacios al inicio y dobles espacios
                    value = value.replace(/^\s+/, "").replace(/\s{2,}/g, " ");

                    input.value = value.charAt(0).toUpperCase() + value.slice(1);
                }

                // Función para restringir caracteres en dirección
                function restrictAddressInput(e) {
                    let key = e.key;
                    let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s,.]$/;

                    if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                        e.preventDefault();
                    }
                }

                // Función para restringir teléfono solo a números 0-9
                function restrictPhoneInput(e) {
                    let key = e.key;
                    let regex = /^[0-9]$/;

                    if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                        e.preventDefault();
                    }
                }

                // Eventos para first_name y last_name
                document.getElementById('first_name').addEventListener('input', function(e) {
                    capitalizeInput(e.target);
                });
                document.getElementById('first_name').addEventListener('keydown', function(e) {
                    restrictNameInput(e);
                });

                document.getElementById('last_name').addEventListener('input', function(e) {
                    capitalizeInput(e.target);
                });
                document.getElementById('last_name').addEventListener('keydown', function(e) {
                    restrictNameInput(e);
                });

                // Eventos para address
                document.getElementById('address').addEventListener('input', function(e) {
                    capitalizeFirstLetter(e.target);
                });
                document.getElementById('address').addEventListener('keydown', function(e) {
                    restrictAddressInput(e);
                });

                // Eventos para phone (solo números)
                document.getElementById('phone').addEventListener('keydown', function(e) {
                    restrictPhoneInput(e);
                });
            </script>


            <script>
            // Función para limpiar los campos del formulario y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('clienteForm');

                // Limpiar los valores del formulario
                form.reset();

                // Limpiar los campos manualmente para evitar restauración por old()
                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden') { // No limpiar campos ocultos
                        input.value = '';
                    }
                });

                // También puedes eliminar las clases de error de validación
                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
            });
        </script>
    </section>
@endsection
