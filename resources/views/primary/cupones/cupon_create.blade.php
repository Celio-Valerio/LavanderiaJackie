@extends('layouts.principal')
@section('title', 'Registrar Cupón')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar Cupón</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="cuponForm" action="{{ route('cupones.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Cupón -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre del Cupón</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Descuento especial" maxlength="100" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Tipo de Cupón -->
                                <div class="col-md-3">
                                    <label for="tipo" class="form-label">Tipo de Cupón</label>
                                    <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" id="tipo" required>
                                        <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Seleccione el tipo</option>
                                        <option value="Valor" {{ old('tipo') == 'Valor' ? 'selected' : '' }}>Valor</option>
                                        <option value="Descuento" {{ old('tipo') == 'Descuento' ? 'selected' : '' }}>Descuento</option>
                                        <option value="Cantidad" {{ old('tipo') == 'Cantidad' ? 'selected' : '' }}>Cantidad</option>
                                    </select>
                                    @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Valor del Cupón -->
                                <div class="col-md-3">
                                    <label for="valor" class="form-label" id="valorLabel">Valor del Cupón</label>
                                    <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror" id="valor" value="{{ old('valor') }}" placeholder="Ej: 100">
                                    @error('valor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Descripción del cupón." maxlength="500" rows="3">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <!-- Fecha Desde -->
                                <div class="col-md-6">
                                    <label for="fecha_desde" class="form-label">Desde</label>
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control @error('fecha_desde') is-invalid @enderror" required value="{{ old('fecha_desde') }}">
                                    @error('fecha_desde')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fecha Hasta -->
                                <div class="col-md-6">
                                    <label for="fecha_hasta" class="form-label">Hasta</label>
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control @error('fecha_hasta') is-invalid @enderror" required value="{{ old('fecha_hasta') }}">
                                    @error('fecha_hasta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <script>
                                    document.getElementById('fecha_desde').addEventListener('change', function() {
                                        let fecha = this.value; // Formato yyyy-mm-dd
                                        // No se cambia el valor del input 'fecha_desde', pero se puede mostrar la nueva fecha si se desea
                                        let partes = fecha.split('-');
                                        let nuevaFecha = partes[2] + '/' + partes[1] + '/' + partes[0]; // Formato dd/mm/yyyy
                                        console.log(nuevaFecha); // Imprimir la fecha en el nuevo formato
                                        // Puedes usar esta fecha para mostrarla en otro lugar o enviarla con otro formato
                                    });

                                    document.getElementById('fecha_hasta').addEventListener('change', function() {
                                        let fecha = this.value; // Formato yyyy-mm-dd
                                        // No se cambia el valor del input 'fecha_hasta', pero se puede mostrar la nueva fecha si se desea
                                        let partes = fecha.split('-');
                                        let nuevaFecha = partes[2] + '/' + partes[1] + '/' + partes[0]; // Formato dd/mm/yyyy
                                        console.log(nuevaFecha); // Imprimir la fecha en el nuevo formato
                                        // Puedes usar esta fecha para mostrarla en otro lugar o enviarla con otro formato
                                    });
                                </script>

                            </div>

                            <div class="row mb-3">
                                <!-- Tabla de Clientes Disponibles -->
                                <div class="col-md-6">
                                    <label class="form-label">Clientes Disponibles</label>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" id="availableClientsTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Visitas Disponibles</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $availableClients = $clientes->reject(fn($c) => in_array($c->id, old('clientes', [])));
                                            @endphp
                                            @forelse($availableClients as $cliente)
                                                <tr data-cliente-id="{{ $cliente->id }}">
                                                    <td>{{ $cliente->first_name }} {{ $cliente->last_name }}</td>
                                                    <td>{{ $cliente->visitas_disponibles }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm moveCliente">
                                                            <i class="bi bi-arrow-right"></i> Mover
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="no-data">
                                                    <td colspan="3" class="text-center">No hay clientes disponibles</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tabla de Clientes Seleccionados -->
                                <div class="col-md-6">
                                    <label class="form-label">Clientes Seleccionados</label>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" id="selectedClientsTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Visitas Disponibles</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse(old('clientes', []) as $clienteId)
                                                @php $cliente = $clientes->find($clienteId); @endphp
                                                @if($cliente)
                                                    <tr data-cliente-id="{{ $cliente->id }}">
                                                        <td>{{ $cliente->first_name }} {{ $cliente->last_name }}</td>
                                                        <td>{{ $cliente->visitas_disponibles }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm removeCliente">
                                                                <i class="bi bi-arrow-left"></i> Quitar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr class="no-data">
                                                    <td colspan="3" class="text-center">No hay clientes seleccionados</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="clientesHiddenInputs">
                                @foreach (old('clientes', []) as $clienteId)
                                    <input type="hidden" name="clientes[]" value="{{ $clienteId }}">
                                @endforeach
                            </div>

                            <!-- Template oculto para restaurar clientes -->
                            <div id="availableClientsTemplate" style="display: none;">
                                @foreach ($clientes as $cliente)
                                    <tr data-cliente-id="{{ $cliente->id }}">
                                        <td>{{ $cliente->first_name }} {{ $cliente->last_name }}</td>
                                        <td>{{ $cliente->visitas_disponibles }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm moveCliente">
                                                <i class="bi bi-arrow-right"></i> Mover
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </div>


                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill" id="clearButton">Limpiar</button>
                                <a href="{{ route('cupones.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Función para capitalizar solo la primera letra de la primera palabra
            function capitalizeFirstLetter(input) {
                let value = input.value.trimStart(); // Evita espacios iniciales
                input.value = value.charAt(0).toUpperCase() + value.slice(1);
            }

            // Función para restringir caracteres y evitar dos espacios seguidos
            function restrictInput(e) {
                let key = e.key;
                let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s,.]*$/;

                if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                    e.preventDefault();
                }
            }

            // Función para evitar dos espacios seguidos
            function preventDoubleSpaces(input) {
                input.value = input.value.replace(/\s{2,}/g, ' ');
            }

            // Asignar eventos a los campos nombre y descripción
            ['nombre', 'descripcion'].forEach(id => {
                let element = document.getElementById(id);

                element.addEventListener('input', function(e) {
                    capitalizeFirstLetter(e.target);
                    preventDoubleSpaces(e.target);
                });

                element.addEventListener('keydown', function(e) {
                    restrictInput(e);
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Almacenar estado inicial para el botón limpiar
                const initialAvailable = document.getElementById('availableClientsTable').innerHTML;
                const initialSelected = document.getElementById('selectedClientsTable').innerHTML;
                const initialHidden = document.getElementById('clientesHiddenInputs').innerHTML;

                // Función para gestionar mensajes de tablas vacías
                const checkEmptyTables = () => {
                    const processTable = (tableId, message) => {
                        const tbody = document.querySelector(`#${tableId} tbody`);
                        const existingNoData = tbody.querySelector('.no-data');
                        const hasData = tbody.querySelector('tr[data-cliente-id]');

                        if (hasData && existingNoData) {
                            existingNoData.remove();
                        }

                        if (!hasData && !existingNoData) {
                            tbody.insertAdjacentHTML('beforeend',
                                `<tr class="no-data">
                            <td colspan="3" class="text-center">${message}</td>
                        </tr>`
                            );
                        }
                    };

                    processTable('availableClientsTable', 'No hay clientes disponibles');
                    processTable('selectedClientsTable', 'No hay clientes seleccionados');
                };

                // Mover cliente a seleccionados
                document.getElementById('availableClientsTable').addEventListener('click', function(e) {
                    if (e.target.closest('.moveCliente')) {
                        const row = e.target.closest('tr');
                        const clienteId = row.dataset.clienteId;
                        const targetTbody = document.querySelector('#selectedClientsTable tbody');

                        // Eliminar mensaje de tabla vacía si existe
                        targetTbody.querySelector('.no-data')?.remove();

                        // Clonar y modificar fila
                        const newRow = row.cloneNode(true);
                        newRow.querySelector('button').outerHTML = `
                    <button type="button" class="btn btn-danger btn-sm removeCliente">
                        <i class="bi bi-arrow-left"></i> Quitar
                    </button>`;

                        // Agregar a seleccionados
                        targetTbody.appendChild(newRow);
                        row.remove();

                        // Agregar input hidden
                        document.getElementById('clientesHiddenInputs').insertAdjacentHTML('beforeend',
                            `<input type="hidden" name="clientes[]" value="${clienteId}">`
                        );

                        checkEmptyTables();
                    }
                });

                // Remover cliente a disponibles
                document.getElementById('selectedClientsTable').addEventListener('click', function(e) {
                    if (e.target.closest('.removeCliente')) {
                        const row = e.target.closest('tr');
                        const clienteId = row.dataset.clienteId;
                        const targetTbody = document.querySelector('#availableClientsTable tbody');

                        // Eliminar mensaje de tabla vacía si existe
                        targetTbody.querySelector('.no-data')?.remove();

                        // Clonar y modificar fila
                        const newRow = row.cloneNode(true);
                        newRow.querySelector('button').outerHTML = `
                    <button type="button" class="btn btn-primary btn-sm moveCliente">
                        <i class="bi bi-arrow-right"></i> Mover
                    </button>`;

                        // Agregar a disponibles
                        targetTbody.appendChild(newRow);
                        row.remove();

                        // Eliminar input hidden
                        document.querySelector(`#clientesHiddenInputs input[value="${clienteId}"]`)?.remove();

                        checkEmptyTables();
                    }
                });

                // Botón limpiar
                document.getElementById('clearButton').addEventListener('click', function() {
                    // Restaurar estado inicial
                    document.getElementById('availableClientsTable').innerHTML = initialAvailable;
                    document.getElementById('selectedClientsTable').innerHTML = initialSelected;
                    document.getElementById('clientesHiddenInputs').innerHTML = initialHidden;

                    // Restablecer otros campos
                    document.getElementById('cuponForm').reset();
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                    checkEmptyTables();
                });

                // Verificar estado inicial al cargar
                checkEmptyTables();
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // -------------------------------
                // Configuración General
                // -------------------------------
                const config = {
                    elementos: {
                        form: document.getElementById('cuponForm'),
                        nombre: document.getElementById('nombre'),
                        descripcion: document.getElementById('descripcion'),
                        valor: document.getElementById('valor'),
                        tipo: document.getElementById('tipo'),
                        valorLabel: document.getElementById('valorLabel'),
                        clearBtn: document.getElementById('clearButton'),
                        fechaDesde: document.getElementById('fecha_desde'),
                        fechaHasta: document.getElementById('fecha_hasta')
                    },

                    validacion: {
                        nombre: {
                            regex: /^[A-ZÁÉÍÓÚÑÜ][a-záéíóúñü0-9 .,!?¿¡-]*$/,
                            maxLength: 50
                        },
                        descripcion: {
                            regex: /^[A-ZÁÉÍÓÚÑÜ][a-záéíóúñü0-9 .,!?¿¡-]*$/,
                            maxLength: 255
                        },
                        valor: {
                            patterns: {
                                Descuento: { regex: /^(100|\d{0,2})$/, maxLength: 3 },
                                Valor: { regex: /^\d{0,5}(\.\d{0,2})?$/, maxLength: 8 },
                                Cantidad: { regex: /^\d{0,3}$/, maxLength: 3 }
                            }
                        }
                    }
                };

                // -------------------------------
                // Funcionalidad del Formulario
                // -------------------------------

                /**
                 * Valida y formatea los campos del formulario en tiempo real
                 * @param {HTMLInputElement} input - Elemento de entrada a validar
                 */
                function validarEntrada(input) {
                    const tipo = config.elementos.tipo.value;
                    let value = input.value;
                    let lastValid = input.dataset.lastValid || '';

                    switch(input.id) {
                        case 'valor':
                            const pattern = config.validacion.valor.patterns[tipo];

                            // Validación específica por tipo
                            if (tipo === 'Descuento' && parseInt(value) > 100) value = '100';
                            if (!pattern.regex.test(value)) {
                                input.value = lastValid;
                                return;
                            }

                            // Manejo de decimales para Valor
                            if (tipo === 'Valor') {
                                const partes = value.split('.');
                                if (partes[1] && partes[1].length > 2) {
                                    value = partes[0] + '.' + partes[1].slice(0,2);
                                }
                            }

                            // Limitar longitud máxima
                            value = value.slice(0, pattern.maxLength);
                            break;
                    }

                    input.value = value;
                    input.dataset.lastValid = value;
                }

                /**
                 * Actualiza la interfaz según el tipo de cupón seleccionado
                 */
                function actualizarTipoCupon() {
                    const tipo = config.elementos.tipo.value;
                    const configValor = {
                        Valor: { texto: 'Valor en lempiras', placeholder: 'Ej: 1000.00', maxlength: 8 },
                        Descuento: { texto: 'Porcentaje', placeholder: 'Ej: 15', maxlength: 2 },
                        Cantidad: { texto: 'Cantidad', placeholder: 'Ej: 5', maxlength: 5 }
                    };

                    config.elementos.valorLabel.textContent = configValor[tipo].texto;
                    config.elementos.valor.placeholder = configValor[tipo].placeholder;
                    config.elementos.valor.maxLength = configValor[tipo].maxlength;
                }

                // -------------------------------
                // Manejo de Eventos
                // -------------------------------

                // Eventos de entrada
                config.elementos.nombre.addEventListener('input', (e) => validarEntrada(e.target));
                config.elementos.descripcion.addEventListener('input', (e) => validarEntrada(e.target));
                config.elementos.valor.addEventListener('input', (e) => validarEntrada(e.target));

                // Cambio de tipo de cupón
                config.elementos.tipo.addEventListener('change', () => {
                    actualizarTipoCupon();
                    config.elementos.valor.value = '';
                    validarEntrada(config.elementos.valor);
                });

                // Botón Limpiar
                config.elementos.clearBtn.addEventListener('click', () => {
                    // Resetear formulario
                    config.elementos.form.reset();

                    // Restablecer selects
                    const selects = config.elementos.form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.selectedIndex = 0;
                        select.dispatchEvent(new Event('change'));
                    });

                    // Limpiar validaciones
                    config.elementos.form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    config.elementos.form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                    config.elementos.nombre = "";
                    config.elementos.descripcion = "";

                    // Restablecer valores específicos
                    config.elementos.valorLabel.textContent = 'Valor del Cupón';
                    config.elementos.valor.placeholder = 'Ej: 100';
                    config.elementos.fechaDesde.value = '';
                    config.elementos.fechaHasta.value = '';
                });

                // -------------------------------
                // Inicialización
                // -------------------------------
                function inicializar() {
                    // Cargar valores antiguos
                    if ("{{ old('tipo') }}") {
                        config.elementos.tipo.value = "{{ old('tipo') }}";
                        config.elementos.tipo.dispatchEvent(new Event('change')); // Disparar evento para actualizar dependencias
                    }

                    // Cargar valor antiguo después de configurar el tipo
                    if ("{{ old('valor') }}") {
                        // Forzar la validación del formato según el tipo
                        validarEntrada(config.elementos.valor);
                        // Actualizar el valor conservando formato
                        config.elementos.valor.value = "{{ old('valor') }}";
                        config.elementos.valor.dataset.lastValid = "{{ old('valor') }}";
                    }

                    actualizarTipoCupon();
                }

                inicializar();
            });
        </script>
    </section>
@endsection
