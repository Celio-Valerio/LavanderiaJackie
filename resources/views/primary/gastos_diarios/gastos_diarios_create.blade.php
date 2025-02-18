@extends('layouts.principal')
@section('title', 'Registrar gasto diario')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar gasto diario</h1>
                        <hr>

                        <form id="gastoDiarioForm" action="{{ route('gastos_diarios.update', $gastoDiario->id ?? '') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <!-- Select de Cliente (Gasto Diario) -->
                                <div class="col-md-6">
                                    <label for="gasto_diario_id" class="form-label">Cliente</label>
                                    <select name="gasto_diario_id" class="form-select" id="gasto_diario_id">
                                        <option value="">Seleccione un gasto diario</option>
                                        @foreach($gastosDiarios as $gasto)
                                            <option value="{{ $gasto->id }}" {{ $gastoDiario && $gastoDiario->id == $gasto->id ? 'selected' : '' }}>
                                                {{ $gasto->servicioEfectuado->cliente->first_name }} {{ $gasto->servicioEfectuado->cliente->last_name }}
                                                (Servicio: {{ $gasto->servicioEfectuado->servicio->nombre }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Select de Producto -->
                                <div class="col-md-6">
                                    <label for="producto_id" class="form-label">Producto</label>
                                    <select name="producto_id" class="form-select" id="producto_id">
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}">{{ $producto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tabla de Productos Agregados -->
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Unidad de Medida</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody id="productosTableBody">
                                    @if($gastoDiario)
                                        @foreach($gastoDiario->detalleGastoDiarios as $detalle)
                                            <tr id="producto-{{ $detalle->producto_id }}">
                                                <td>{{ $detalle->producto->nombre }}
                                                    <input type="hidden" name="productos[{{ $detalle->producto_id }}][id]" value="{{ $detalle->producto_id }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="productos[{{ $detalle->producto_id }}][cantidad]"
                                                           value="{{ $detalle->cantidad }}" class="form-control text-center" required min="0.1" max="999" step="0.1">
                                                </td>
                                                <td>
                                                    <select name="productos[{{ $detalle->producto_id }}][unidad]" class="form-select" required>
                                                        <option value="Kilogramos" {{ $detalle->unidad_medida == 'Kilogramos' ? 'selected' : '' }}>Kilogramos</option>
                                                        <option value="Kilos" {{ $detalle->unidad_medida == 'Kilos' ? 'selected' : '' }}>Kilos</option>
                                                        <option value="Gramos" {{ $detalle->unidad_medida == 'Gramos' ? 'selected' : '' }}>Gramos</option>
                                                        <option value="Gotas" {{ $detalle->unidad_medida == 'Gotas' ? 'selected' : '' }}>Gotas</option>
                                                        <option value="Unidades" {{ $detalle->unidad_medida == 'Unidades' ? 'selected' : '' }}>Unidades</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm delete-row">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" name="actualizar" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <a href="{{ route('gastos_diarios.index') }}" class="btn btn-danger flex-fill">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para agregar productos -->
    <div class="modal fade" id="cantidadModal" tabindex="-1" aria-labelledby="cantidadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cantidadModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cantidadForm">
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="0.1" max="999" step="0.1" required>
                        </div>
                        <div class="mb-3">
                            <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                            <select class="form-select" id="unidad_medida" name="unidad_medida" required>
                                <option value="Kilogramos">Kilogramos</option>
                                <option value="Kilos">Kilos</option>
                                <option value="Gramos">Gramos</option>
                                <option value="Gotas">Gotas</option>
                                <option value="Unidades">Unidades</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarProducto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gastoDiarioSelect = document.getElementById('gasto_diario_id');
            const gastoDiarioForm = document.getElementById('gastoDiarioForm');

            // Actualizar la acción del formulario cuando se cambia el gasto diario
            gastoDiarioSelect.addEventListener('change', function() {
                const gastoDiarioId = this.value;

                // Si se selecciona un gasto diario, actualiza el action del formulario
                if (gastoDiarioId) {
                    gastoDiarioForm.action = `/gastos-diarios/${gastoDiarioId}`;
                } else {
                    gastoDiarioForm.action = "#"; // Si no hay selección, no debería enviar el formulario
                }
            });
        });
    </script>

    <!-- Scripts para manejar la lógica del formulario -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productoSelect = document.getElementById('producto_id');
            const productosTableBody = document.getElementById('productosTableBody');
            const cantidadModal = new bootstrap.Modal(document.getElementById('cantidadModal'));
            const cantidadInput = document.getElementById('cantidad');
            const unidadMedidaSelect = document.getElementById('unidad_medida');
            let selectedProductId = null;
            let selectedProductName = null;

            // Mostrar el modal cuando se selecciona un producto
            productoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                selectedProductId = this.value;
                selectedProductName = selectedOption.getAttribute('data-nombre');

                // Verificar si el producto ya fue agregado
                const existingProducts = Array.from(productosTableBody.querySelectorAll('input[name^="productos"]'))
                    .map(input => input.value);

                if (selectedProductId && !existingProducts.includes(selectedProductId)) {
                    cantidadModal.show();
                } else {
                    this.value = '';
                    alert('Este producto ya fue agregado');
                }
            });

            // Guardar el producto en la tabla
            document.getElementById('guardarProducto').addEventListener('click', function() {
                const cantidad = cantidadInput.value;
                const unidadMedida = unidadMedidaSelect.value;

                if (cantidad >= 0.1 && cantidad <= 999) {
                    const rowId = `producto-${selectedProductId}`;

                    productosTableBody.insertAdjacentHTML('beforeend', `
                        <tr id="${rowId}">
                            <td>${selectedProductName}
                                <input type="hidden" name="productos[${selectedProductId}][id]" value="${selectedProductId}">
                            </td>
                            <td>
                                <input type="number" name="productos[${selectedProductId}][cantidad]"
                                       class="form-control text-center"
                                       value="${cantidad}" min="0.1" max="999" step="0.1" required>
                            </td>
                            <td>
                                <select name="productos[${selectedProductId}][unidad]" class="form-select" required>
                                    <option value="${unidadMedida}">${unidadMedida}</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-row">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);

                    // Deshabilitar el producto en el select
                    productoSelect.querySelector(`option[value="${selectedProductId}"]`).disabled = true;

                    cantidadModal.hide();
                    productoSelect.value = '';
                    cantidadInput.value = '';
                }
            });

            // Eliminar producto de la tabla
            productosTableBody.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-row')) {
                    const row = e.target.closest('tr');
                    const productId = row.id.split('-')[1];
                    productoSelect.querySelector(`option[value="${productId}"]`).disabled = false;
                    row.remove();
                }
            });
        });
    </script>
@endsection
