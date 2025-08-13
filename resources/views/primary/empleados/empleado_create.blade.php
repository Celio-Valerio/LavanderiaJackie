@extends('layouts.principal')
@section('title', 'Registrar empleado')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->empleados_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Registrar empleado</h1>
                            <hr>
                            <!-- Inicio del formulario -->
                            <form id="empleadoForm" action="{{ route('empleados.store') }}" method="POST" novalidate>
                                @csrf

                                <div class="row mb-3">
                                    <!-- Campo de Identidad -->
                                    <div class="col-md-6">
                                        <label for="identity_number" class="form-label">Número de Identidad</label>
                                        <input
                                            type="text"
                                            name="identity_number"
                                            class="form-control @error('identity_number') is-invalid @enderror"
                                            id="identity_number"
                                            value="{{ old('identity_number') }}"
                                            placeholder="Ej: 0801199012345"
                                            maxlength="13"
                                            pattern="\d{13}"
                                            inputmode="numeric"
                                            required>
                                        @error('identity_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Nombre -->
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">Nombre</label>
                                        <input
                                            type="text"
                                            name="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name"
                                            value="{{ old('first_name') }}"
                                            placeholder="Ej: Juan"
                                            maxlength="50"
                                            required>
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Apellido -->
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Apellido</label>
                                        <input
                                            type="text"
                                            name="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            id="last_name"
                                            value="{{ old('last_name') }}"
                                            placeholder="Ej: Pérez"
                                            maxlength="50"
                                            required>
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- Campo de Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Correo electrónico</label>
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="email"
                                            value="{{ old('email') }}"
                                            placeholder="Ej: ejemplo@gmail.com"
                                            maxlength="50"
                                            pattern="^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$"
                                            required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="puesto_id" class="form-label">Puesto</label>
                                        <select name="puesto_id" class="form-select @error('puesto_id') is-invalid @enderror" id="puesto_id" required>
                                            <option value="">Selecciona un puesto</option>
                                            @foreach($puestos as $puesto)
                                                <option value="{{ $puesto->id }}" {{ old('puesto_id') == $puesto->id ? 'selected' : '' }}>
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
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            id="phone"
                                            value="{{ old('phone') }}"
                                            placeholder="Ej: 90123456"
                                            maxlength="8"
                                            inputmode="numeric"
                                            pattern="\d{8}"
                                            required>
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Salario -->
                                    <div class="col-md-3">
                                        <label for="salary" class="form-label">Salario</label>
                                        <input
                                            type="text"
                                            name="salary"
                                            class="form-control @error('salary') is-invalid @enderror"
                                            id="salary"
                                            value="{{ old('salary') }}"
                                            placeholder="Ej: 12345.67"
                                            maxlength="8" {{-- 5 dígitos + punto + 2 --}}
                                            pattern="^\d{1,5}(\.\d{2})?$"
                                            required>
                                        @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Fecha de Ingreso -->
                                    <div class="col-md-3">
                                        <label for="hire_date" class="form-label">Fecha de ingreso</label>
                                        <input type="date" name="hire_date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" value="{{ old('hire_date') }}" required>
                                        @error('hire_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo de Fecha de Salida -->
                                    <div class="col-md-3">
                                        <label for="fecha_salida" class="form-label">Fecha de salida</label>
                                        <input type="date" name="fecha_salida" class="form-control @error('fecha_salida') is-invalid @enderror" id="fecha_salida" value="{{ old('fecha_salida') }}" required>
                                        @error('fecha_salida')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Campo de Dirección -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección</label>
                                    <textarea
                                        name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        id="address"
                                        placeholder="Ej: Calle Principal 123"
                                        maxlength="500"
                                        rows="3">{{ old('address') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                    <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                    <a href="{{ route('empleados.index') }}" class="btn btn-danger flex-fill">Regresar</a>
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

        {{-- Scripts de validación --}}
        <script>
            // --- Utilidades de espacios ---
            function sanitizeSpaces(str) {
                return str.replace(/^\s+/, '').replace(/\s{2,}/g, ' ');
            }

            // --- Nombres/Apellidos: capitalizar por palabra (Unicode), sin dobles espacios ni espacio inicial ---
            function capitalizeWordsInput(el) {
                let v = el.value.toLowerCase();
                v = sanitizeSpaces(v);
                el.value = v.replace(/(^|\s)([a-záéíóúñ])/gu, (m, sp, ch) => sp + ch.toUpperCase());
            }
            function restrictNameKey(e) {
                const key = e.key;
                // letras (incluye tildes) y espacio
                const ok = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]$/.test(key) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Home','End','Delete'].includes(key);
                // Evitar espacio como primer carácter
                if (key === ' ' && e.target.selectionStart === 0) return e.preventDefault();
                if (!ok) e.preventDefault();
            }

            // --- Dirección: capitalizar primera letra, sin dobles espacios ni espacio inicial ---
            function capitalizeFirstLetter(el) {
                let v = sanitizeSpaces(el.value);
                el.value = v.charAt(0).toUpperCase() + v.slice(1);
            }
            function restrictAddressKey(e) {
                const key = e.key;
                const ok = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ,.\-#]$/.test(key) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Home','End','Delete'].includes(key);
                if (key === ' ' && e.target.selectionStart === 0) return e.preventDefault();
                if (!ok) e.preventDefault();
            }

            // --- Teléfono: solo dígitos 0-9 ---
            function restrictPhoneKey(e) {
                const key = e.key;
                const ok = /^[0-9]$/.test(key) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(key);
                if (!ok) e.preventDefault();
            }

            // --- DNI: exactamente 13 dígitos ---
            function restrictDNIKey(e) {
                const key = e.key;
                const ok = /^[0-9]$/.test(key) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(key);
                if (!ok) e.preventDefault();
            }
            function sanitizeDNI(el) {
                // Dejar solo dígitos y cortar a 13
                el.value = (el.value.replace(/\D+/g,'')).slice(0,13);
            }

            // --- Salario: 1-5 dígitos, opcional . y exactamente 2 decimales si hay punto ---
            const SALARY_REGEX = /^\d{1,5}(\.\d{2})?$/;
            function restrictSalaryKey(e) {
                const key = e.key;
                const allowedControl = ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'];
                if (allowedControl.includes(key)) return;

                if (!/^[0-9.]$/.test(key)) return e.preventDefault();

                const v = e.target.value;
                const selStart = e.target.selectionStart;
                const selEnd = e.target.selectionEnd;

                // Simular el valor resultante tras la tecla
                const next = v.slice(0, selStart) + key + v.slice(selEnd);

                // Reglas:
                // - Solo un punto
                if ((key === '.' && v.includes('.'))) return e.preventDefault();
                // - No permitir iniciar con punto
                if (key === '.' && selStart === 0) return e.preventDefault();
                // - Máx 5 dígitos antes del punto
                const parts = next.split('.');
                if (parts[0].length > 5) return e.preventDefault();
                // - Si hay punto, máx 2 decimales
                if (parts.length === 2 && parts[1].length > 2) return e.preventDefault();
            }
            function sanitizeSalary(el) {
                // Dejar solo dígitos y un punto
                let v = el.value.replace(/[^\d.]/g, '');
                // Mantener solo el primer punto
                const firstDot = v.indexOf('.');
                if (firstDot !== -1) {
                    v = v.slice(0, firstDot + 1) + v.slice(firstDot + 1).replace(/\./g, '');
                }
                // Cortar antes del punto a 5 dígitos
                let [intPart, decPart=''] = v.split('.');
                intPart = intPart.slice(0, 5);
                if (decPart) decPart = decPart.slice(0, 2);
                v = decPart.length ? intPart + '.' + decPart : intPart;
                el.value = v;
                // Validar contra el patrón final
                if (v && !SALARY_REGEX.test(v)) {
                    el.setCustomValidity('Formato inválido. Use hasta 5 dígitos y opcionalmente . con 2 decimales (ej: 12345.67)');
                } else {
                    el.setCustomValidity('');
                }
            }

            // --- Email: sin espacios, solo letters/numbers y @ . - _
            function restrictEmailKey(e) {
                const key = e.key;
                const ok = /^[A-Za-z0-9@._-]$/.test(key) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(key);
                if (!ok) e.preventDefault();
                if (key === ' ' ) e.preventDefault();
            }
            function sanitizeEmail(el) {
                el.value = el.value.replace(/\s+/g, '').replace(/[^A-Za-z0-9@._-]/g, '').slice(0, 50);
            }

            // --- Asignación de eventos ---
            // DNI
            const dni = document.getElementById('identity_number');
            dni.addEventListener('keydown', restrictDNIKey);
            dni.addEventListener('input', () => sanitizeDNI(dni));

            // Nombres
            const firstName = document.getElementById('first_name');
            firstName.addEventListener('keydown', restrictNameKey);
            firstName.addEventListener('input', () => capitalizeWordsInput(firstName));

            const lastName = document.getElementById('last_name');
            lastName.addEventListener('keydown', restrictNameKey);
            lastName.addEventListener('input', () => capitalizeWordsInput(lastName));

            // Dirección
            const address = document.getElementById('address');
            address.addEventListener('keydown', restrictAddressKey);
            address.addEventListener('input', () => capitalizeFirstLetter(address));

            // Teléfono
            const phone = document.getElementById('phone');
            phone.addEventListener('keydown', restrictPhoneKey);
            phone.addEventListener('input', () => { phone.value = phone.value.replace(/\D+/g,'').slice(0,8); });

            // Salario
            const salary = document.getElementById('salary');
            salary.addEventListener('keydown', restrictSalaryKey);
            salary.addEventListener('input', () => sanitizeSalary(salary));

            // Email
            const email = document.getElementById('email');
            email.addEventListener('keydown', restrictEmailKey);
            email.addEventListener('input', () => sanitizeEmail(email));

            // Limpiar formulario
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('empleadoForm');
                form.reset();
                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden') input.value = '';
                    input.setCustomValidity && input.setCustomValidity('');
                });
                document.getElementById('puesto_id').selectedIndex = 0;
                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
            });
        </script>

    </section>
@endsection
