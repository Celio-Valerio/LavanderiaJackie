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
                                        <option value="" disabled selected>Seleccione el tipo</option>
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
                                <div class="col-md-6">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <div class="input-group">
                                        <select name="cliente_id" class="form-control" id="cliente_id">
                                            <option value="" disabled selected>Seleccione un cliente</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}"
                                                        data-visitas="{{ $cliente->visitas_disponibles }}"
                                                        @if(in_array($cliente->id, old('clientes', []))) disabled @endif>
                                                    {{ $cliente->first_name }} {{ $cliente->last_name }} - {{ $cliente->visitas_disponibles }} visitas
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-success" id="agregarCliente">
                                            <i class="bi bi-plus-lg"></i> Agregar
                                        </button>
                                    </div>
                                </div>

                                <!-- Fecha Desde -->
                                <div class="col-md-3">
                                    <label for="fecha_desde" class="form-label">Desde</label>
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control @error('fecha_desde') is-invalid @enderror" required value="{{ old('fecha_desde') }}">
                                    @error('fecha_desde')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fecha Hasta -->
                                <div class="col-md-3">
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
                            <!-- Tabla de Clientes Agregados -->
                            <div class="mb-4" id="clientesContainer" style="display: {{ count(old('clientes', [])) ? 'block' : 'none' }};">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="clientesTable">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Visitas Disponibles</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach (old('clientes', []) as $clienteId)
                                            @php
                                                $cliente = $clientes->find($clienteId);
                                            @endphp
                                            <tr data-cliente-id="{{ $cliente->id }}">
                                                <td>{{ $cliente->first_name }} {{ $cliente->last_name }}</td>
                                                <td>{{ $cliente->visitas_disponibles }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm removerCliente">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
            document.getElementById('cliente_id').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let visitasDisponibles = selectedOption.getAttribute('data-visitas') || 0;
                document.getElementById('visitas_disponibles').value = visitasDisponibles;
            });

            document.getElementById('nombre').addEventListener('input', function () {
                this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
            });

            document.getElementById('descripcion').addEventListener('input', function () {
                this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
            });

            document.addEventListener('DOMContentLoaded', function () {
                let clienteSelect = document.getElementById('cliente_id');
                let visitasInput = document.getElementById('visitas_disponibles');

                function actualizarVisitas() {
                    let selectedOption = clienteSelect.options[clienteSelect.selectedIndex];
                    let visitasDisponibles = selectedOption ? selectedOption.getAttribute('data-visitas') : '0';
                    visitasInput.value = visitasDisponibles;
                }

                // Actualizar visitas al cambiar el cliente
                clienteSelect.addEventListener('change', actualizarVisitas);

                // Mantener visitas seleccionadas después de la recarga
                actualizarVisitas();
            });

            document.getElementById('tipo').addEventListener('change', function() {
                let tipo = this.value;
                let valorInput = document.getElementById('valor');
                valorInput.required = tipo !== 'Cantidad';

                if (tipo === 'Valor') {
                    valorLabel.textContent = 'Valor en lempiras';
                    valorInput.placeholder = 'Ej: 1000.00';
                    valorInput.value = '';
                    valorInput.setAttribute('maxlength', '8');
                    valorInput.setAttribute('pattern', '^[0-9]+(\.[0-9]{1,2})?$');
                } else if (tipo === 'Descuento') {
                    valorLabel.textContent = 'Porcentaje';
                    valorInput.placeholder = 'Ej: 15';
                    valorInput.value = '';
                    valorInput.setAttribute('maxlength', '2');
                    valorInput.setAttribute('pattern', '^[0-9]{1,2}$');
                } else if (tipo === 'Cantidad') {
                    valorLabel.textContent = 'Cantidad';
                    valorInput.placeholder = 'Ej: 5';
                    valorInput.value = '';
                    valorInput.setAttribute('maxlength', '5');
                    valorInput.setAttribute('pattern', '^[0-9]{1,5}$');
                }
            });

            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('cuponForm');

                // Limpiar los campos manualmente sin eliminar el token CSRF
                form.querySelectorAll('input:not([name="_token"]), textarea').forEach(input => input.value = '');

                // Restablecer selección de cliente sin borrar el token
                const clienteSelect = document.getElementById('cliente_id');
                clienteSelect.selectedIndex = 0;

                // Restablecer visitas disponibles
                document.getElementById('visitas_disponibles').value = "0";

                // Restablecer selección de tipo
                const tipoSelect = document.getElementById('tipo');
                tipoSelect.selectedIndex = 0;

                // Restablecer etiquetas y placeholders dinámicos
                const valorInput = document.getElementById('valor');
                const valorLabel = document.getElementById('valorLabel');
                valorLabel.textContent = 'Valor del Cupón';
                valorInput.placeholder = 'Ej: 100';

                // Eliminar clases de validación
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            });

            document.getElementById('valor').addEventListener('input', function () {
                let tipo = document.getElementById('tipo').value;
                let valor = this.value;

                if (tipo === 'Valor') {
                    this.value = valor.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').slice(0, 8);
                } else if (tipo === 'Descuento') {
                    this.value = valor.replace(/[^0-9]/g, '').slice(0, tipo === 'Descuento' ? 2 : 3);
                }
            });
        </script>

            <script>
                // Clase para gestionar el estado (versión corregida)
                class ClientManager {
                    constructor() {
                        this.select = document.getElementById('cliente_id');
                        this.tbody = document.querySelector('#clientesTable tbody');
                        this.container = document.getElementById('clientesContainer');
                        this.originalOptions = [...this.select.options];

                        this.container.style.display = this.tbody.children.length > 0 ? 'block' : 'none';
                    }

                    addClient() {
                        const selectedOption = this.select.options[this.select.selectedIndex];

                        if (selectedOption.value && !selectedOption.disabled) {
                            // ... (código existente de addClient)
                        }
                    }

                    removeClient(clienteId) {
                        // ... (código existente de removeClient)
                    }

                    removeAllClients() {
                        // Eliminar todas las filas
                        const rows = this.tbody.querySelectorAll('tr');
                        rows.forEach(row => {
                            const clienteId = row.getAttribute('data-cliente-id');
                            this.removeClient(clienteId);
                        });

                        // Forzar actualización de visualización
                        this.container.style.display = 'none';
                    }
                }

                // Inicializar manager
                const clientManager = new ClientManager();

                // Evento del botón Limpiar (versión corregida)
                document.getElementById('clearButton').addEventListener('click', function() {
                    // Restablecer formulario
                    document.getElementById('cuponForm').reset();

                    // Limpiar campos manualmente
                    document.querySelectorAll('#nombre, #descripcion, #valor, #fecha_desde, #fecha_hasta').forEach(field => {
                        field.value = '';
                    });

                    // Restablecer selects
                    document.getElementById('tipo').selectedIndex = 0;
                    document.getElementById('cliente_id').selectedIndex = 0;

                    // Limpiar tabla de clientes
                    clientManager.removeAllClients();

                    // Restablecer etiqueta del valor
                    document.getElementById('valorLabel').textContent = 'Valor del Cupón';

                    // Eliminar mensajes de error
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                });

                // ... (resto del código existente)
            </script>

            <script>
                // En la sección del botón Limpiar
                document.getElementById('clearButton').addEventListener('click', function () {
                    const form = document.getElementById('cuponForm');

                    // Limpiar todos los inputs y selects
                    form.querySelectorAll('input:not([type="hidden"]):not([name="_token"]), textarea, select').forEach(element => {
                        if (element.tagName === 'SELECT') {
                            element.selectedIndex = 0; // Restablecer selects
                        } else {
                            element.value = ''; // Limpiar inputs y textarea
                        }
                    });

                    // Limpiar tabla de clientes y reactivar opciones
                    clientManager.removeAllClients();

                    // Restablecer etiqueta y placeholder del valor
                    const valorLabel = document.getElementById('valorLabel');
                    valorLabel.textContent = 'Valor del Cupón';
                    const valorInput = document.getElementById('valor');
                    valorInput.placeholder = 'Ej: 100';

                    // Eliminar clases de validación
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                    // Restablecer fechas
                    document.getElementById('fecha_desde').value = '';
                    document.getElementById('fecha_hasta').value = '';
                });

                // En la clase ClientManager agregar este método
                class ClientManager {
                    // ... (código existente)

                    removeAllClients() {
                        // Eliminar todas las filas
                        this.tbody.querySelectorAll('tr').forEach(row => {
                            const clienteId = row.getAttribute('data-cliente-id');
                            this.removeClient(clienteId);
                        });

                        // Ocultar contenedor
                        this.container.style.display = 'none';
                    }
                }
            </script>
    </section>
@endsection
