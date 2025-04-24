@extends('layouts.principal')
@section('title', 'Registrar usuario')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar usuario</h1>
                        <hr>
                        <form id="usuarioForm" action="{{ route('usuarios.store') }}" method="POST" novalidate enctype="multipart/form-data">
                            @csrf

                            <div>
                                <div>
                                    <h4 style="font-weight: bold;">Datos del empleado</h4>

                                    <div class="row mb-3">
                                        <!-- Seleccionar empleado -->
                                        <div class="col-md-6">
                                            <label for="empleado_id" class="form-label">Empleado</label>
                                            <div class="d-flex align-items-start">
                                                <!-- Select de cliente -->
                                                <select name="empleado_id" id="empleado_id" class="form-control select2 @error('empleado_id') is-invalid @enderror" required>
                                                    <option value="">Seleccione un empleado</option>
                                                    @foreach($empleados as $empleado)
                                                        <option value="{{ $empleado->id }}"
                                                                data-nombre="{{ $empleado->first_name }} {{ $empleado->last_name }}"
                                                                data-direccion="{{ $empleado->address }}"
                                                                data-email="{{ $empleado->email }}"
                                                                data-telefono="{{ $empleado->phone }}"
                                                                data-puesto="{{ $empleado->puesto->name }}"
                                                            {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                                            {{ $empleado->first_name }} {{ $empleado->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('empleado_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!--  Nombre completo -->
                                        <div class="col-md-6">
                                            <label for="names" class="form-label">Nombre completo</label>
                                            <input type="text" name="names" class="form-control small-text-field @error('names') is-invalid @enderror"
                                                   id="names" value="{{ old('names') }}" placeholder="Ej: Juan Pérez" maxlength="100" readonly>
                                            @error('names')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="puesto" class="form-label">Puesto</label>
                                            <input type="text" name="puesto" class="form-control small-text-field @error('puesto') is-invalid @enderror"
                                                   id="puesto" value="{{ old('puesto') }}" placeholder="Ej: Administrador" maxlength="50" readonly>
                                            @error('puesto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" name="telefono" class="form-control small-text-field @error('telefono') is-invalid @enderror"
                                                   id="telefono" value="{{ old('telefono') }}" placeholder="Ej: 90123456" maxlength="8" readonly>
                                            @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="email" name="email" class="form-control small-text-field @error('email') is-invalid @enderror"
                                                   id="email" value="{{ old('email') }}" placeholder="Ej: usuario@mail.com" maxlength="50" readonly>
                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <textarea name="direccion" class="form-control small-text-field @error('direccion') is-invalid @enderror"
                                                  id="direccion" placeholder="Ej: Calle Principal 123" maxlength="500" rows="2" readonly>{{ old('direccion') }}</textarea>
                                        @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div>
                                <div>
                                    <h4 style="font-weight: bold;">Datos del usuario</h4>

                                    <div class="row g-3 mb-4 align-items-start">
                                        <!-- Columna izquierda: todos los inputs de texto -->
                                        <div class="col-md-8">
                                            <!-- Nombre de usuario -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nombre de usuario</label>
                                                <input type="text" name="name" id="name"
                                                       class="form-control small-text-field @error('name') is-invalid @enderror"
                                                       value="{{ old('name') }}" placeholder="Ej: Juan Pérez" maxlength="100" required>
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <!-- Pregunta de seguridad -->
                                            <div class="mb-3">
                                                <label for="security_question" class="form-label">Pregunta de seguridad</label>
                                                <select name="security_question" id="security_question"
                                                        class="form-select @error('security_question') is-invalid @enderror" required>
                                                    <option value="">Seleccione una pregunta...</option>
                                                    <option value="¿Cuál es el nombre de tu primera mascota?" {{ old('security_question')=='¿Cuál es el nombre de tu primera mascota?'?'selected':'' }}>
                                                        ¿Cuál es el nombre de tu primera mascota?
                                                    </option>
                                                    <option value="¿En qué ciudad naciste?" {{ old('security_question')=='¿En qué ciudad naciste?'?'selected':'' }}>
                                                        ¿En qué ciudad naciste?
                                                    </option>
                                                    <option value="¿Cuál es tu comida favorita?" {{ old('security_question')=='¿Cuál es tu comida favorita?'?'selected':'' }}>
                                                        ¿Cuál es tu comida favorita?
                                                    </option>
                                                    <option value="¿Cómo se llamaba tu colegio primario?" {{ old('security_question')=='¿Cómo se llamaba tu colegio primario?'?'selected':'' }}>
                                                        ¿Cómo se llamaba tu colegio primario?
                                                    </option>
                                                    <option value="¿Cuál es el nombre de tu mejor amigo de la infancia?" {{ old('security_question')=='¿Cuál es el nombre de tu mejor amigo de la infancia?'?'selected':'' }}>
                                                        ¿Cuál es el nombre de tu mejor amigo de la infancia?
                                                    </option>
                                                </select>
                                                @error('security_question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <!-- Respuesta de seguridad -->
                                            <div class="mb-3">
                                                <label for="security_answer" class="form-label">Respuesta de seguridad</label>
                                                <input type="text" name="security_answer" id="security_answer"
                                                       class="form-control small-text-field @error('security_answer') is-invalid @enderror"
                                                       value="{{ old('security_answer') }}" placeholder="Escribe tu respuesta"
                                                       minlength="3" maxlength="100" required>
                                                @error('security_answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <!-- Contraseña y Confirmación -->
                                            <div class="row g-2 mb-3">
                                                <div class="col-md-6">
                                                    <label for="password" class="form-label">Contraseña</label>
                                                    <input type="password" name="password" id="password"
                                                           class="form-control small-text-field @error('password') is-invalid @enderror"
                                                           maxlength="50" required autocomplete="new-password">
                                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                                           class="form-control small-text-field @error('password_confirmation') is-invalid @enderror"
                                                           maxlength="50" required autocomplete="new-password">
                                                    @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Columna derecha: imagen de usuario, alineada al tope -->
                                        <div class="col-md-4 text-center">
                                            <label for="image" class="form-label">Imagen de Usuario</label>
                                            <div class="image-preview-wrapper mb-3" style="position: relative; width: 100%; max-width: 300px; height: 200px; margin: 0 auto;">
                                                <div class="image-preview-border"
                                                     style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                  border: 3px dashed #b0b0b0; border-radius: 5px; pointer-events: none;"></div>
                                                <div id="imagePreviewContainer"
                                                     class="image-preview-container"
                                                     style="width: 100%; height: 100%; background-color: #f0f0f0;
                  border-radius: 5px; overflow: hidden;
                  display: flex; justify-content: center; align-items: center;">
                                                    <img id="imagePreview"
                                                         src="{{ old('image') ? asset('storage/' . old('image')) : '#' }}"
                                                         alt="Vista previa de la imagen"
                                                         style="max-width: 100%; max-height: 100%; display: {{ old('image') ? 'block' : 'none' }};">
                                                </div>
                                            </div>
                                            <input type="file" name="image" id="image"
                                                   class="form-control @error('image') is-invalid @enderror"
                                                   accept="image/*">
                                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                            @if(old('image'))
                                                <small class="text-muted d-block mt-1">Archivo: {{ basename(old('image')) }}</small>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between gap-2">  <!-- Espaciado uniforme -->
                                <button type="submit" class="btn btn-primary flex-fill">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill" id="clearButton">Limpiar</button>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
