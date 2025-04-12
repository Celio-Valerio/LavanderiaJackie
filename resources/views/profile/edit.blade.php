@extends('layouts.principal')
@section('title', 'Configuración de cuenta')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Agregar este estilo en la sección de estilos -->
    <style>
        .password-input-group {
            position: relative;
            margin-bottom: 0.5rem;
        }

        .btn-toggle-password {
            position: absolute;
            right: 30px; /* Aumentamos el espacio a la derecha */
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0;
            z-index: 5;
            cursor: pointer;
        }

        /* Añadir padding para el ícono de error de Bootstrap */
        .form-control.is-invalid {
            padding-right: 2.5rem;
            background-position: right calc(0.375em + 0.1875rem) center;
        }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Configuración de cuenta</h1>
                        <hr>
                        <form id="usuarioForm"
                              action="{{ route('profile.update') }}"
                              method="POST"
                              novalidate
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div>
                                <div>
                                    <h4 style="font-weight: bold;">Datos del usuario</h4>

                                    <div class="row g-0 mb-3">
                                        <div class="col-md-7 me-md-3">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nombre de usuario</label>
                                                <input type="text" name="name" class="form-control small-text-field @error('name') is-invalid @enderror"
                                                       id="name" value="{{ $usuario->name }}" placeholder="Ej: Juan Pérez" maxlength="100" required>
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <!-- Campos de contraseña -->
                                            <div class="row g-2 mb-3">
                                                <div class="col-md-6">
                                                    <label for="current_password" class="form-label">Contraseña actual</label>
                                                    <div class="password-input-group">
                                                        <input type="password" name="current_password"
                                                               class="form-control small-text-field @error('current_password') is-invalid @enderror"
                                                               id="current_password" placeholder="" autocomplete="current-password">
                                                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('current_password')">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                    @error('current_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="new_password" class="form-label">Nueva contraseña</label>
                                                    <div class="password-input-group">
                                                        <input type="password" name="new_password"
                                                               class="form-control small-text-field @error('new_password') is-invalid @enderror"
                                                               id="new_password" placeholder="" autocomplete="new-password">
                                                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('new_password')">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                    @error('new_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="new_password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                                                    <div class="password-input-group">
                                                        <input type="password" name="new_password_confirmation"
                                                               class="form-control small-text-field"
                                                               id="new_password_confirmation" placeholder="" autocomplete="new-password">
                                                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('new_password_confirmation')">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sección de imagen -->
                                        <div class="col-md-4 d-flex flex-column">
                                            <div class="mb-3" style="width: 100%; text-align: center;">
                                                <label for="image" class="form-label">Imagen de Usuario</label>
                                                <div class="mb-3 image-preview-wrapper" style="position: relative; width: 100%; max-width: 300px; height: 200px;">
                                                    <div class="image-preview-border" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 3px dashed #b0b0b0; border-radius: 5px; pointer-events: none;"></div>
                                                    <div id="imagePreviewContainer" class="image-preview-container" style="width: 100%; height: 100%; background-color: #f0f0f0; border-radius: 5px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                        <img id="imagePreview" src="{{ asset('assets/img/perfiles/'.$usuario->image) }}" alt="Vista previa de la imagen" style="max-width: 100%; max-height: 100%;">
                                                    </div>
                                                </div>
                                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                                                @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <div>
                                    <h4 style="font-weight: bold;">Datos del empleado</h4>

                                    <div class="row mb-3">
                                        <!-- Seleccionar empleado -->
                                        <div class="col-md-6">
                                            <label class="form-label">Empleado asignado</label>
                                            <div class="form-control" style="background-color: #e9ecef;">
                                                {{ $usuario->empleado->first_name }} {{ $usuario->empleado->last_name }}
                                                <input type="hidden" name="empleado_id" value="{{ $usuario->empleado_id }}">
                                            </div>
                                        </div>

                                        <!-- Nombre completo -->
                                        <div class="col-md-6">
                                            <label for="names" class="form-label">Nombre completo</label>
                                            <input type="text" name="names" class="form-control small-text-field @error('names') is-invalid @enderror"
                                                   id="names" value="{{ $usuario->empleado->first_name }} {{ $usuario->empleado->last_name }}" placeholder="Ej: Juan Pérez" maxlength="100" readonly>
                                            @error('names')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="puesto" class="form-label">Puesto</label>
                                            <input type="text" name="puesto" class="form-control small-text-field @error('puesto') is-invalid @enderror"
                                                   id="puesto" value="{{ $usuario->empleado->puesto->name }}" placeholder="Ej: Administrador" maxlength="50" readonly>
                                            @error('puesto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" name="telefono" class="form-control small-text-field @error('telefono') is-invalid @enderror"
                                                   id="telefono" value="{{ $usuario->empleado->phone }}" placeholder="Ej: 90123456" maxlength="8" readonly>
                                            @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="email" name="email" class="form-control small-text-field @error('email') is-invalid @enderror"
                                                   id="email" value="{{ $usuario->empleado->email }}" placeholder="Ej: usuario@mail.com" maxlength="50" readonly>
                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <textarea name="direccion" class="form-control small-text-field @error('direccion') is-invalid @enderror"
                                                  id="direccion" placeholder="Ej: Calle Principal 123" maxlength="500" rows="2" readonly>{{ $usuario->empleado->address }}</textarea>
                                        @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">Actualizar</button>
                                <button type="reset" class="btn btn-warning flex-fill">Reestablecer</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Manejar el evento reset del formulario
                document.getElementById('usuarioForm').addEventListener('reset', function(e) {
                    // Restaurar imagen original
                    document.getElementById('imagePreview').src = originalValues.image;

                    // Limpiar clases de validación
                    const inputs = document.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid');
                    });

                    // Ocultar mensajes de error
                    document.querySelectorAll('.invalid-feedback').forEach(element => {
                        element.style.display = 'none';
                    });

                    // Restaurar valores de los campos
                    document.getElementById('name').value = originalValues.name;
                    document.getElementById('empleado_id').value = originalValues.empleado_id;

                    // Limpiar campos de contraseña
                    document.getElementById('current_password').value = '';
                    document.getElementById('new_password').value = '';
                    document.getElementById('new_password_confirmation').value = '';
                });
            });
        </script>

        <script>
            function togglePasswordVisibility(inputId) {
                const passwordInput = document.getElementById(inputId);
                const toggleButton = passwordInput.nextElementSibling.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleButton.classList.replace('fa-eye-slash', 'fa-eye');
                } else {
                    passwordInput.type = 'password';
                    toggleButton.classList.replace('fa-eye', 'fa-eye-slash');
                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Función para limpiar, normalizar y validar la estructura del nombre
                function sanitizeAndNormalizeInput(inputElement) {
                    if (inputElement.value.length > 50) {
                        inputElement.value = inputElement.value.substring(0, 50);
                    }

                    // Limpia y normaliza los espacios
                    var sanitizedInput = inputElement.value.replace(/^\s+/, '').replace(/\s+/g, ' ');

                    // Solo permite letras y hasta tres espacios en blanco
                    var lettersAndSpacesOnly = sanitizedInput.replace(/[^a-zA-Z ]/g, "");
                    var wordArray = lettersAndSpacesOnly.split(' ');

                    // Aplica las reglas de la cantidad máxima de palabras (4 palabras como máximo)
                    if (wordArray.length > 5) {
                        wordArray = wordArray.slice(0, 5);
                    }

                    // Normaliza cada palabra para que tenga la primera letra en mayúscula y las demás en minúscula
                    var normalizedWords = wordArray.map(function(word) {
                        if (word.length > 0) {
                            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                        }
                        return '';
                    });

                    // Une las palabras con un solo espacio y actualiza el valor del input
                    inputElement.value = normalizedWords.join(' ');
                }

                var nameInput = document.getElementById('name');

                nameInput.addEventListener('input', function () {
                    sanitizeAndNormalizeInput(this);
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Función para validar el número de teléfono
                const validarPhone = (id) => {
                    document.getElementById('telefono').addEventListener('input', function (e) {
                        let valor = e.target.value;
                        // Asegura que solo se ingresen números
                        valor = valor.replace(/[^0-9]/g, '');

                        // Verifica que el primer dígito sea 2, 3, 8, o 9
                        if (valor.length > 0 && !['2', '3', '8', '9'].includes(valor[0])) {
                            e.target.value = ''; // Limpia el valor si el primer dígito no es válido
                            return; // Sale de la función para evitar más comprobaciones
                        }

                        // Restringe la longitud a un máximo de 8 dígitos
                        if (valor.length > 8) {
                            e.target.value = valor.slice(0, 8);
                            return; // Sale de la función para evitar más comprobaciones
                        }

                        e.target.value = valor; // Actualiza el valor con las modificaciones
                    });
                };

                // Aplica la validación para el campo de teléfono
                validarPhone('telefono');
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Función para validar y formatear la entrada de texto con una longitud máxima dada
                function validarYFormatearEntrada(id, longitudMaxima) {
                    const inputElement = document.getElementById(id);
                    inputElement.addEventListener('input', function () {
                        let valor = inputElement.value;

                        // Elimina espacios iniciales, números y símbolos al inicio del texto
                        valor = valor.replace(/^[^a-zA-Z]+/, '');

                        // Transforma múltiples espacios seguidos en un solo espacio
                        valor = valor.replace(/\s\s+/g, ' ');

                        // Limita la longitud del texto a la cantidad especificada
                        valor = valor.slice(0, longitudMaxima);

                        // Transforma la primera letra en mayúscula sin alterar el resto del texto
                        if (valor.length > 0) {
                            valor = valor.charAt(0).toUpperCase() + valor.slice(1);
                        }

                        // Actualiza el valor del campo con las modificaciones
                        inputElement.value = valor;
                    });
                }

                // Aplica la validación y formateo para el campo de dirección con una longitud máxima de 300
                validarYFormatearEntrada('direccion', 300);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Función para validar y formatear la entrada de texto con una longitud máxima dada
                function validarYFormatearEntrada(id, longitudMaxima) {
                    const inputElement = document.getElementById(id);
                    inputElement.addEventListener('input', function () {
                        let valor = inputElement.value;
                        // Transforma múltiples espacios seguidos en un solo espacio
                        valor = valor.replace(/\s+/g, '');

                        // Limita la longitud del texto a la cantidad especificada
                        valor = valor.slice(0, longitudMaxima);

                        // Actualiza el valor del campo con las modificaciones
                        inputElement.value = valor;
                    });
                }

                // Aplica la validación y formateo para el campo de dirección con una longitud máxima de 300
                validarYFormatearEntrada('password', 15);
                validarYFormatearEntrada('password_confirmation', 15);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var emailInput = document.getElementById('email'); // Asegúrate de que este es el ID correcto de tu campo de correo electrónico

                emailInput.addEventListener('input', function () {
                    // Eliminar espacios en blanco
                    var value = this.value.replace(/\s+/g, '');

                    // Limitar a 50 caracteres
                    value = value.substring(0, 50);

                    // Autocompletar el dominio del correo
                    var atIndex = value.indexOf('@');
                    if (atIndex !== -1) {
                        var afterAt = value.charAt(atIndex + 1);
                        switch (afterAt) {
                            case 'g':
                                value = value.substring(0, atIndex) + '@gmail.com';
                                break;
                            case 'h':
                                value = value.substring(0, atIndex) + '@hotmail.com';
                                break;
                            case 'o':
                                value = value.substring(0, atIndex) + '@outlook.com';
                                break;
                            case 'y':
                                value = value.substring(0, atIndex) + '@yahoo.com';
                                break;
                            default:
                                if (atIndex + 1 < value.length) { // Si hay caracteres después del @ y no es ninguno de los permitidos, borrarlos
                                    value = value.substring(0, atIndex + 1);
                                }
                                break;
                        }
                    }
                    this.value = value;
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const clearButton = document.getElementById('clearButton');
                const form = document.getElementById('usuarioForm');
                const imageInput = document.getElementById('image');
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const selectEmpleado = document.getElementById('empleado_id');  // El select del empleado
                const telefonoInput = document.getElementById('telefono');
                const emailInput = document.getElementById('email');
                const nameInput = document.getElementById('name');
                const namesInput = document.getElementById('names');
                const addressInput = document.getElementById('direccion');

                clearButton.addEventListener('click', function () {
                    // Resetear el formulario
                    form.reset();

                    // Limpiar la vista previa de la imagen
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                    imagePreviewContainer.style.backgroundColor = '#f0f0f0';

                    // Limpiar el input de archivo
                    imageInput.value = '';

                    telefonoInput.value = '';
                    emailInput.value = '';
                    addressInput.value = '';
                    nameInput.value = '';
                    namesInput.value = '';

                    // Resetear el select de empleado al primer índice (índice 0)
                    selectEmpleado.selectedIndex = 0;

                    // Remover clases de validación (is-invalid) de todos los campos
                    const inputs = form.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid');
                    });

                    // Remover mensajes de error
                    const errorMessages = form.querySelectorAll('.invalid-feedback');
                    errorMessages.forEach(message => {
                        message.style.display = 'none';
                    });

                    // También asegurarse de quitar cualquier error de validación que podría haberse añadido por error
                    const errorContainers = form.querySelectorAll('.error-container');
                    errorContainers.forEach(container => {
                        container.innerHTML = ''; // Limpiar contenido de contenedores de error
                    });
                });
            });

        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const colorThief = new ColorThief();

                // Función para cambiar el fondo al color dominante de la imagen
                const updateContainerBackground = () => {
                    if (imagePreview.src && imagePreview.src !== '#') {
                        const dominantColor = colorThief.getColor(imagePreview);
                        imagePreviewContainer.style.backgroundColor = `rgb(${dominantColor.join(',')})`;
                    }
                };

                // Mostrar vista previa de la imagen seleccionada y cambiar fondo
                document.getElementById('image').addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            updateContainerBackground();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.src = '#';
                        imagePreview.style.display = 'none';
                        imagePreviewContainer.style.backgroundColor = '#f0f0f0';
                    }
                });

                // Actualizar el fondo al cargar la imagen
                imagePreview.addEventListener('load', updateContainerBackground);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const selectEmpleado = document.getElementById('empleado_id');
                const inputNombres = document.getElementById('names');
                const inputNombre = document.getElementById('name');
                const inputDireccion = document.getElementById('direccion');
                const inputEmail = document.getElementById('email');
                const inputTelefono = document.getElementById('telefono');
                const inputPuesto = document.getElementById('puesto');

                selectEmpleado.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];

                    if (selectedOption.value) {
                        inputNombres.value = selectedOption.getAttribute('data-nombre') || '';
                        inputDireccion.value = selectedOption.getAttribute('data-direccion') || '';
                        inputEmail.value = selectedOption.getAttribute('data-email') || '';
                        inputTelefono.value = selectedOption.getAttribute('data-telefono') || '';
                        inputPuesto.value = selectedOption.getAttribute('data-puesto') || '';
                    } else {
                        inputNombres.value = '';
                        inputDireccion.value = '';
                        inputEmail.value = '';
                        inputTelefono.value = '';
                        inputPuesto.value = '';
                    }
                });

                // Disparar el evento change si hay un valor previamente seleccionado
                if (selectEmpleado.value) {
                    selectEmpleado.dispatchEvent(new Event('change'));
                }

            });

        </script>


    </section>
@endsection
