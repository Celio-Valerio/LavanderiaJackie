@extends('layouts.principal')
@section('title', 'Registrar Proveedor')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->proveedores_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Registrar proveedor</h1>
                            <hr>

                            <!-- Inicio del formulario -->
                            <form id="proveedorForm" action="{{ route('proveedores.store') }}" method="POST" novalidate>
                                @csrf

                                <div class="row mb-3">
                                    <!-- Nombre de la Empresa -->
                                    <div class="col-md-4">
                                        <label for="company_name" class="form-label">Nombre de la empresa</label>
                                        <input
                                            type="text"
                                            name="company_name"
                                            class="form-control small-text-field @error('company_name') is-invalid @enderror"
                                            id="company_name"
                                            value="{{ old('company_name') }}"
                                            placeholder="Ej: Proveedor S.A."
                                            maxlength="100"
                                            pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9.]+( [A-Za-zÁÉÍÓÚáéíóúÑñ0-9.]+)*$"
                                            required>
                                        @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Teléfono de la Empresa -->
                                    <div class="col-md-4">
                                        <label for="company_phone" class="form-label">Teléfono de la empresa</label>
                                        <input
                                            type="text"
                                            name="company_phone"
                                            class="form-control small-text-field @error('company_phone') is-invalid @enderror"
                                            id="company_phone"
                                            value="{{ old('company_phone') }}"
                                            placeholder="Ej: 90123498"
                                            maxlength="8"
                                            inputmode="numeric"
                                            pattern="^[2389][0-9]{7}$"
                                            required>
                                        @error('company_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Correo electrónico</label>
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control small-text-field @error('email') is-invalid @enderror"
                                            id="email"
                                            value="{{ old('email') }}"
                                            placeholder="Ej: proveedor@empresa.com"
                                            maxlength="50"
                                            pattern="^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- Nombre del vendedor -->
                                    <div class="col-md-4">
                                        <label for="full_name" class="form-label">Nombre del vendedor</label>
                                        <input
                                            type="text"
                                            name="full_name"
                                            class="form-control small-text-field @error('full_name') is-invalid @enderror"
                                            id="full_name"
                                            value="{{ old('full_name') }}"
                                            placeholder="Ej: Juan Pérez"
                                            maxlength="100"
                                            pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$"
                                            required>
                                        @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Teléfono del vendedor -->
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Teléfono del vendedor</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control small-text-field @error('phone') is-invalid @enderror"
                                            id="phone"
                                            value="{{ old('phone') }}"
                                            placeholder="Ej: 90123456"
                                            maxlength="8"
                                            inputmode="numeric"
                                            pattern="^[2389][0-9]{7}$"
                                            required>
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Categoría -->
                                    <div class="col-md-4">
                                        <label for="categoria_id" class="form-label">Categoría</label>
                                        <select name="categoria_id" class="form-select small-text-field @error('categoria_id') is-invalid @enderror" id="categoria_id" required>
                                            <option value="">Selecciona una categoría</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                                        <?php
                                        $departamentos = [
                                            "Atlántida", "Colón", "Comayagua", "Copán", "Cortés", "Choluteca", "El Paraíso", "Francisco Morazán",
                                            "Gracias a Dios", "Intibucá", "Islas de la Bahía", "La Paz", "Lempira", "Ocotepeque", "Olancho", "Santa Bárbara",
                                            "Valle", "Yoro"
                                        ];
                                        ?>
                                        <!-- Departamento -->
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">Departamento</label>
                                        <select name="city" class="form-select small-text-field @error('city') is-invalid @enderror" id="city" required>
                                            <option value="">Selecciona un departamento</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{ $departamento }}" {{ old('city') == $departamento ? 'selected' : '' }}>
                                                    {{ $departamento }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Dirección -->
                                <div class="mb-3">
                                    <label for="company_address" class="form-label">Dirección</label>
                                    <textarea
                                        name="company_address"
                                        class="form-control small-text-field @error('company_address') is-invalid @enderror"
                                        id="company_address"
                                        placeholder="Ej: Calle Principal 123"
                                        maxlength="500"
                                        rows="3"></textarea>
                                    @error('company_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botones -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                    <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                    <a href="{{ route('proveedores.index') }}" class="btn btn-danger flex-fill">Regresar</a>
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
            // Utilidades de espacios
            function sanitizeSpaces(str) {
                return str.replace(/^\s+/, '').replace(/\s{2,}/g, ' ');
            }

            // Capitalizar por palabra (Unicode) para nombres
            function capitalizeWords(el) {
                let v = el.value.toLowerCase();
                v = sanitizeSpaces(v);
                el.value = v.replace(/(^|\s)([a-záéíóúñ])/giu, (m, sp, ch) => sp + ch.toUpperCase());
            }
            // Capitalizar primera letra para campos de texto generales
            function capitalizeFirst(el) {
                let v = sanitizeSpaces(el.value);
                el.value = v.charAt(0).toUpperCase() + v.slice(1);
            }

            // Restricciones de teclado
            function allowNameKeys(e) {
                const k = e.key;
                const ok = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]$/.test(k) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(k);
                if (k === ' ' && e.target.selectionStart === 0) return e.preventDefault(); // sin espacio inicial
                if (!ok) e.preventDefault();
            }
            function allowCompanyNameKeys(e) {
                const k = e.key;
                const ok = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9. ]$/.test(k) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(k);
                if (k === ' ' && e.target.selectionStart === 0) return e.preventDefault();
                if (!ok) e.preventDefault();
            }
            function allowAddressKeys(e) {
                const k = e.key;
                const ok = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ,.\-#]$/.test(k) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(k);
                if (k === ' ' && e.target.selectionStart === 0) return e.preventDefault();
                if (!ok) e.preventDefault();
            }
            function allowPhoneKeys(e) {
                const k = e.key;
                const ok = /^[0-9]$/.test(k) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(k);
                if (!ok) e.preventDefault();
            }
            function allowEmailKeys(e) {
                const k = e.key;
                const ok = /^[A-Za-z0-9@._-]$/.test(k) || ['Backspace','Tab','Enter','ArrowLeft','ArrowRight','Home','End','Delete'].includes(k);
                if (!ok) e.preventDefault();
                if (k === ' ') e.preventDefault(); // sin espacios
            }

            // Saneos en tiempo real
            function cleanPhone(el) {
                el.value = el.value.replace(/\D+/g,'').slice(0,8);
            }
            function cleanCompanyPhone(el) {
                el.value = el.value.replace(/\D+/g,'').slice(0,8);
            }
            function cleanEmail(el) {
                el.value = el.value.replace(/\s+/g,'').replace(/[^A-Za-z0-9@._-]/g,'').slice(0,50);
            }
            function cleanCompanyName(el) {
                let v = sanitizeSpaces(el.value);
                // Solo permitir letras/números/espacios y punto
                v = v.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9. ]+/g, '');
                el.value = v.slice(0,100);
                capitalizeFirst(el);
            }
            function cleanAddress(el) {
                let v = sanitizeSpaces(el.value);
                // Permitir letras/números/espacios , . - #
                v = v.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ,.\-#]+/g, '');
                el.value = v.slice(0,500);
                capitalizeFirst(el);
            }

            // Asignaciones
            const fullName = document.getElementById('full_name');
            fullName.addEventListener('keydown', allowNameKeys);
            fullName.addEventListener('input', () => capitalizeWords(fullName));

            const companyName = document.getElementById('company_name');
            companyName.addEventListener('keydown', allowCompanyNameKeys);
            companyName.addEventListener('input', () => cleanCompanyName(companyName));

            const companyAddress = document.getElementById('company_address');
            companyAddress.addEventListener('keydown', allowAddressKeys);
            companyAddress.addEventListener('input', () => cleanAddress(companyAddress));

            const phone = document.getElementById('phone');
            phone.addEventListener('keydown', allowPhoneKeys);
            phone.addEventListener('input', () => cleanPhone(phone));

            const companyPhone = document.getElementById('company_phone');
            companyPhone.addEventListener('keydown', allowPhoneKeys);
            companyPhone.addEventListener('input', () => cleanCompanyPhone(companyPhone));

            const email = document.getElementById('email');
            email.addEventListener('keydown', allowEmailKeys);
            email.addEventListener('input', () => cleanEmail(email));

            // Botón limpiar
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('proveedorForm');
                form.reset();
                form.querySelectorAll('input:not([type="hidden"]), textarea').forEach(i => i.value = '');
                document.getElementById('categoria_id').selectedIndex = 0;
                document.getElementById('city').selectedIndex = 0;

                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(fb => fb.style.display = 'none');
            });
        </script>
    </section>
@endsection
