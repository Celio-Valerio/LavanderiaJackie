@extends('layouts.principal')
@section('title', 'Registrar Gastos')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar gastos</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="gastoForm" action="{{ route('gastos.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">
                                <!-- Campo de Descripción del Gasto -->
                                <div class="col-md-6">
                                    <label for="description" class="form-label">Descripción del gasto</label>
                                    <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" value="{{ old('descripcion') }}" placeholder="Ej: Gastos de insumos" maxlength="100" required>
                                    @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Monto -->
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Monto</label>
                                    <input type="number" name="monto" class="form-control @error('monto') is-invalid @enderror" id="monto" value="{{ old('monto') }}" placeholder="Ej: 1500" required maxlength="4" max="9999" oninput="this.value = Math.max(0, Math.min(9999, this.value))">
                                    @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Fecha -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Fecha del gasto</label>
                                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                    @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Categoría -->
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Categoría</label>
                                    <select name="categoria" class="form-select @error('categoria') is-invalid @enderror" id="categoria" required>
                                        <option value="" disabled selected>Seleccione una categoría</option>
                                        <option value="Operativo" {{ old('category') == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                                        <option value="Mantenimiento" {{ old('category') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                        <option value="Otros" {{ old('category') == 'Otros' ? 'selected' : '' }}>Otros</option>
                                    </select>
                                    @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botón para agregar productos -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-info" id="addProductButton">Agregar Producto</button>
                            </div>

                            <!-- Modal para seleccionar productos -->
                            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel">Seleccionar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <select id="productSelect" class="form-select">
                                                <!-- Aquí se llenarán los productos disponibles -->
                                                <option value="" disabled selected>Seleccione un producto</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->nombre }}" data-price="{{ $producto->precio }}">{{ $producto->nombre }} - ${{ $producto->precio }}</option>
                                                @endforeach
                                            </select>
                                            <div class="mt-3">
                                                <label for="productQuantity" class="form-label">Cantidad</label>
                                                <input type="number" id="productQuantity" class="form-control" min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" id="confirmAddProduct">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de detalles de gastos -->
                            <table class="table" id="detailsTable">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se agregarán las filas de productos -->
                                </tbody>
                            </table>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="total" class="form-label">Total Gastos</label>
                                    <input type="text" name="total" class="form-control" id="total" value="0" readonly>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('gastos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Función para limpiar los campos del formulario y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('gastoForm');
                form.reset();

                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden') {
                        input.value = '';
                    }
                });

                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
            });

            // Mostrar el modal al hacer clic en el botón "Agregar Producto"
            document.getElementById('addProductButton').addEventListener('click', function () {
                const productModal = new bootstrap.Modal(document.getElementById('productModal'));
                productModal.show();
            });

            // Agregar el producto seleccionado a la tabla
            document.getElementById('confirmAddProduct').addEventListener('click', function () {
                const productSelect = document.getElementById('productSelect');
                const productName = productSelect.value;
                const quantity = parseInt(document.getElementById('productQuantity').value) || 1;
                const price = parseFloat(productSelect.selectedOptions[0].getAttribute('data-price')) || 0;

                if (productName) {
                    const totalPrice = quantity * price; // Calcular el total por producto

                    const tableBody = document.getElementById('detailsTable').querySelector('tbody');
                    const newRow = tableBody.insertRow();

                    newRow.innerHTML = `
                        <td>${productName}</td>
                        <td><input type="number" value="${quantity}" min="1" class="form-control quantity-input"></td>
                        <td>$${price.toFixed(2)}</td>
                        <td class="total-price">$${totalPrice.toFixed(2)}</td>
                        <td><button type="button" class="btn btn-danger remove-button">Eliminar</button></td>
                    `;

                    updateTotal();
                    const productModal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                    productModal.hide(); // Cerrar el modal
                }
            });

            // Función para actualizar el total de gastos
            function updateTotal() {
                const totalInput = document.getElementById('total');
                let total = 0;

                document.querySelectorAll('#detailsTable tbody tr').forEach(function (row) {
                    const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
                    const price = parseFloat(row.querySelector('.total-price').textContent.replace('$', '')) / quantity || 0;
                    total += quantity * price; // Sumar el total de cada producto
                });

                totalInput.value = total;
            }

            // Evento para eliminar filas de la tabla
            document.getElementById('detailsTable').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-button')) {
                    const row = event.target.closest('tr');
                    row.remove();
                    updateTotal();
                }
            });
        </script>

    </section>
@endsection