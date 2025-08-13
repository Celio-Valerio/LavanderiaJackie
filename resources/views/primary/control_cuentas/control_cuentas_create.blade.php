@extends('layouts.principal')
@section('title', 'Registrar control de cuenta')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->transacciones_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Registrar transacción</h1>
                            <hr>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-message">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Formulario Principal -->
                            <form action="{{ route('control_cuentas.store') }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <!-- Selección de Cuenta Bancaria -->
                                    <div class="col-md-6">
                                        <label for="cuenta_banco_id" class="form-label">Cuenta Bancaria</label>
                                        <div class="input-group">
                                            <select name="cuenta_banco_id" id="cuenta_banco_id" class="form-select" required>
                                                <option value="">Seleccione una cuenta</option>
                                                @foreach($cuentasBancos as $cuenta)
                                                    <option value="{{ $cuenta->id }}" {{ old('cuenta_banco_id') == $cuenta->id ? 'selected' : '' }}>
                                                        {{ $cuenta->banco }} - {{ $cuenta->cuenta }} (L. {{ $cuenta->saldo }})
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCuentaModal">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Campo de Fecha -->
                                    <div class="col-md-6">
                                        <label for="fecha" class="form-label">Fecha</label>
                                        <!-- Campo visible con formato bonito -->
                                        <input id="fecha_display" type="text" class="form-control"
                                               value="{{ \Carbon\Carbon::now('America/Tegucigalpa')->translatedFormat('j \d\e F, Y h:i A') }}"
                                               readonly>


                                        <!-- Campo oculto con formato compatible con la base de datos -->
                                        <input type="hidden" name="fecha"
                                               value="{{ \Carbon\Carbon::now('America/Tegucigalpa')->format('Y-m-d H:i:s') }}">

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- Tipo de Transacción -->
                                    <div class="col-md-6">
                                        <label for="transaccion" class="form-label">Tipo de Transacción</label>
                                        <select name="transaccion" class="form-select" required>
                                            <option value="">Seleccione tipo</option>
                                            <option value="Retiro" {{ old('transaccion') == 'Retiro' ? 'selected' : '' }}>Retiro</option>
                                            <option value="Deposito" {{ old('transaccion') == 'Deposito' ? 'selected' : '' }}>Depósito</option>
                                        </select>
                                    </div>

                                    <!-- Monto -->
                                    <div class="col-md-6">
                                        <label for="monto" class="form-label">Monto</label>
                                        <input type="number" step="0.01" min="0.01" max="99999.99" name="monto" class="form-control" value="{{ old('monto') }}" required>
                                    </div>
                                </div>

                                <!-- Notas -->
                                <div class="mb-3">
                                    <label for="notas" class="form-label">Notas</label>
                                    <textarea name="notas" class="form-control @error('notas') is-invalid @enderror" id="notas" placeholder="Escribe tus notas aquí..." maxlength="500" rows="3">{{ old('notas') }}</textarea>
                                    @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botones -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">Guardar Transacción</button>
                                    <button type="button" class="btn btn-warning flex-fill" id="limpiarFormulario">Limpiar</button>
                                    <a href="{{ route('control_cuentas.index') }}" class="btn btn-secondary flex-fill">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para Agregar Nueva Cuenta Bancaria -->
            <div class="modal fade" id="agregarCuentaModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar Nueva Cuenta Bancaria</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form id="formCuentaBanco" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="banco" class="form-label">Banco</label>
                                    <input type="text" name="banco" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cuenta" class="form-label">Número de Cuenta</label>
                                    <input type="text" name="cuenta" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="saldo" class="form-label">Saldo Inicial</label>
                                    <input type="number" step="0.01" name="saldo" class="form-control" value="0.00" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cuenta</button>
                            </div>
                        </form>
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

    </section>

    <script>
        // Manejar el envío del formulario del modal con AJAX
        document.getElementById('formCuentaBanco').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch("{{ route('cuenta_bancos.store') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(this)
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Agregar la nueva opción al select
                        const select = document.getElementById('cuenta_banco_id');
                        const newOption = new Option(data.cuenta.banco + ' - ' + data.cuenta.cuenta, data.cuenta.id);
                        select.add(newOption, undefined);
                        select.value = data.cuenta.id;

                        // Cerrar el modal y resetear el formulario
                        const modal = bootstrap.Modal.getInstance(document.getElementById('agregarCuentaModal'));
                        modal.hide();
                        this.reset();
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const successAlert = document.getElementById('success-message');
            const errorAlert = document.getElementById('error-message');

            if (successAlert) {
                setTimeout(() => {
                    successAlert.classList.remove('show');
                    successAlert.style.display = 'none';
                }, 5000);
            }

            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.classList.remove('show');
                    errorAlert.style.display = 'none';
                }, 5000);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Selección de elementos del formulario
            const montoInput = document.querySelector('input[name="monto"]');
            const saldoInput = document.querySelector('input[name="saldo"]');
            const notasTextarea = document.querySelector('textarea[name="notas"]');
            const bancoInput = document.querySelector('input[name="banco"]');
            const cuentaInput = document.querySelector('input[name="cuenta"]');

            // Función para validar números con un máximo de 7 dígitos y un punto decimal
            function validarNumeroConPunto(input) {
                input.addEventListener('input', function () {
                    let valor = input.value;

                    // Permitir solo números y un solo punto decimal
                    valor = valor.replace(/[^0-9.]/g, '');

                    // Asegurar que haya solo un punto decimal
                    const partes = valor.split('.');
                    if (partes.length > 2) {
                        valor = partes[0] + '.' + partes.slice(1).join('');
                    }

                    // Limitar a 7 números antes del punto y 2 después
                    const regex = /^(\d{0,7})(\.\d{0,2})?$/;
                    if (!regex.test(valor)) {
                        valor = valor.slice(0, -1);
                    }

                    input.value = valor;
                });
            }

            validarNumeroConPunto(montoInput);
            validarNumeroConPunto(saldoInput);

            // Validar notas: Primera letra en mayúscula y máximo 255 caracteres
            notasTextarea.addEventListener('input', function () {
                let texto = notasTextarea.value;

                // Limitar a 255 caracteres
                if (texto.length > 255) {
                    texto = texto.substring(0, 255);
                }

                // Transformar la primera letra en mayúscula
                if (texto.length > 0) {
                    texto = texto.charAt(0).toUpperCase() + texto.slice(1);
                }

                notasTextarea.value = texto;
            });

            // Validar nombre del banco
            bancoInput.addEventListener('input', function () {
                let valor = bancoInput.value;

                // Permitir solo letras, números y un solo espacio entre palabras
                valor = valor.replace(/[^a-zA-Z0-9 ]/g, '');

                // Eliminar espacios dobles
                valor = valor.replace(/\s{2,}/g, ' ');

                // Limitar a 50 caracteres
                if (valor.length > 50) {
                    valor = valor.substring(0, 50);
                }

                // Transformar la primera letra en mayúscula
                if (valor.length > 0) {
                    valor = valor.charAt(0).toUpperCase() + valor.slice(1);
                }

                bancoInput.value = valor;
            });

            // Validar número de cuenta (máximo 15 dígitos, solo números)
            cuentaInput.addEventListener('input', function () {
                let valor = cuentaInput.value;

                // Permitir solo números
                valor = valor.replace(/[^0-9]/g, '');

                // Limitar a 15 caracteres
                if (valor.length > 15) {
                    valor = valor.substring(0, 15);
                }

                cuentaInput.value = valor;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Asegura que sea el formulario principal (el que hace POST a control_cuentas.store)
            const formularioPrincipal = document.querySelector('form[action="{{ route('control_cuentas.store') }}"]');
            const limpiarBtn = document.getElementById('limpiarFormulario');

            if (!formularioPrincipal || !limpiarBtn) return;

            // --- 1) Crear snapshot del estado inicial ---
            const snapshot = [];

            // Incluye todos los campos del form (inputs, selects, textareas)
            const elementos = formularioPrincipal.querySelectorAll('input, select, textarea');

            elementos.forEach(el => {
                const item = { ref: null, type: el.tagName.toLowerCase(), attr: {}, value: null };

                // Referencia por 'name' si existe; si no, por 'id'
                if (el.name) {
                    item.ref = { by: 'name', key: el.name };
                } else if (el.id) {
                    item.ref = { by: 'id', key: el.id };
                } else {
                    // Último recurso: índice dentro del formulario (estable pero menos ideal)
                    item.ref = { by: 'index', key: Array.from(elementos).indexOf(el) };
                }

                // Según tipo
                if (el.tagName.toLowerCase() === 'select') {
                    if (el.multiple) {
                        item.value = Array.from(el.options).map(o => o.selected);
                    } else {
                        item.value = el.value;
                    }
                } else if (el.type === 'checkbox' || el.type === 'radio') {
                    item.value = el.checked;
                } else {
                    item.value = el.value;
                }

                snapshot.push(item);
            });

            // Campo de fecha “bonito” (readonly sin name) — lo capturamos aparte
            const fechaDisplay = document.getElementById('fecha_display');
            const fechaDisplayValor = fechaDisplay ? fechaDisplay.value : null;

            // --- 2) Restaurar snapshot al pulsar Limpiar ---
            limpiarBtn.addEventListener('click', function () {
                snapshot.forEach(item => {
                    let el = null;
                    if (item.ref.by === 'name') {
                        el = formularioPrincipal.querySelector(`[name="${CSS.escape(item.ref.key)}"]`);
                    } else if (item.ref.by === 'id') {
                        el = formularioPrincipal.querySelector(`#${CSS.escape(item.ref.key)}`);
                    } else {
                        el = elementos[item.ref.key]; // fallback por índice
                    }
                    if (!el) return;

                    if (el.tagName.toLowerCase() === 'select') {
                        if (el.multiple && Array.isArray(item.value)) {
                            Array.from(el.options).forEach((opt, i) => {
                                opt.selected = !!item.value[i];
                            });
                        } else {
                            el.value = item.value ?? '';
                        }
                        // Dispara change por si hay lógica enganchada
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    } else if (el.type === 'checkbox' || el.type === 'radio') {
                        el.checked = !!item.value;
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    } else {
                        el.value = item.value ?? '';
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });

                // Restaurar la fecha visible si existe
                if (fechaDisplay && fechaDisplayValor !== null) {
                    fechaDisplay.value = fechaDisplayValor;
                }
            });
        });
    </script>


@endsection
