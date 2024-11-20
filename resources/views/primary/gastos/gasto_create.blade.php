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
                                    <input type="number" name="monto" class="form-control @error('monto') is-invalid @enderror" id="monto" value="{{ old('monto') }}" placeholder="Ej: 1500" required maxlength="10" max="9999999999" oninput="this.value = Math.max(0, Math.min(9999999999, this.value))">
                                    @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Fecha -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Fecha del gasto</label>
                                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" id="fecha" value="{{ old('fecha') ?: date('Y-m-d') }}" required>
                                    @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botón para agregar productos -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="addProductButton">Agregar producto</button>
                            </div>

                            <!-- Modal para seleccionar productos -->
                            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel">Seleccionar producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <select id="productSelect" class="form-select" required>
                                                <option value="" disabled selected>Seleccione un producto</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->nombre }}" data-price="{{ $producto->precio }}">{{ $producto->nombre }} - ${{ $producto->precio }}</option>
                                                @endforeach
                                            </select>
                                            <div class="mt-3">
                                                <label for="productQuantity" class="form-label">Cantidad</label>
                                                <input type="number" id="productQuantity" class="form-control @error('productQuantity') is-invalid @enderror" min="1" value="" required maxlength="4" oninput="this.value = this.value.slice(0, 4)">
                                                @error('productQuantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" id="confirmAddProduct">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para agregar gastos fijos -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="addFixedExpenseButton">Agregar gasto fijo</button>
                            </div>

                            <!-- Modal para agregar gastos fijos -->
                            <div class="modal fade" id="fixedExpenseModal" tabindex="-1" aria-labelledby="fixedExpenseModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="fixedExpenseModalLabel">Agregar gasto fijo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="fixedExpenseName" class="form-label">Gasto fijo</label>
                                                <select id="fixedExpenseName" class="form-select" required>
                                                    <option value="" disabled selected>Seleccione un gasto fijo</option>
                                                    <option value="Energía">Energía</option>
                                                    <option value="Agua">Agua</option>
                                                    <option value="Internet">Internet</option>
                                                    <option value="Pago a Empleados">Pago a empleados</option>
                                                    <option value="Renta">Renta</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <label for="fixedExpenseAmount" class="form-label">Monto</label>
                                                <input type="number" id="fixedExpenseAmount" class="form-control @error('fixedExpenseAmount') is-invalid @enderror" min="0.01" value="" required maxlength="4" placeholder="Ej: 500 L" oninput="this.value = this.value.slice(0, 4)">
                                                @error('fixedExpenseAmount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" id="confirmAddFixedExpense">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de detalles de gastos -->
                            <table class="table" id="detailsTable">
                                <thead>
                                    <tr>
                                        <th onclick="sortTable(0)">Producto</th>
                                        <th onclick="sortTable(1)">Cantidad</th>
                                        <th onclick="sortTable(2)">Precio Unitario</th>
                                        <th onclick="sortTable(3)">Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="detailsTableBody"> 
                                    <!-- Aquí se agregarán las filas de productos -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8" class="text-end"><strong>Total:</strong></td>
                                        <td id="totalAmount">$0.00</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Tabla de gastos fijos -->
                            <table class="table" id="fixedExpensesTable">
                                <thead>
                                    <tr>
                                        <th>Nombre del Gasto Fijo</th>
                                        <th>Monto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se agregarán las filas de gastos fijos -->
                                </tbody>
                            </table>

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
            // Funciones y eventos
            // Función para limpiar los campos del formulario y eliminar los errores de validación
            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('gastoForm');
                form.reset();

                // Limpiar la tabla de detalles de gastos
                const tableBody = document.getElementById('detailsTable').querySelector('tbody');
                while (tableBody.firstChild) {
                    tableBody.removeChild(tableBody.firstChild);
                }

                // Limpiar la tabla de gastos fijos
                const fixedExpensesTableBody = document.getElementById('fixedExpensesTable').querySelector('tbody');
                while (fixedExpensesTableBody.firstChild) {
                    fixedExpensesTableBody.removeChild(fixedExpensesTableBody.firstChild);
                }

                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type !== 'hidden' && input.id !== 'fecha') {
                        input.value = '';
                    }
                });

                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });

                // Actualizar el total a 0
                document.getElementById('totalAmount').textContent = `$0.00`;
                document.getElementById('monto').value = '0.00'; // Actualiza el campo de monto
            });

            // Mostrar el modal al hacer clic en el botón "Agregar Producto"
            document.getElementById('addProductButton').addEventListener('click', function () {
                const productModal = new bootstrap.Modal(document.getElementById('productModal'));
                document.getElementById('productQuantity').value = '';
                productModal.show();
            });

            // Agregar el producto seleccionado a la tabla
            document.getElementById('confirmAddProduct').addEventListener('click', function () {
                const productSelect = document.getElementById('productSelect');
                const productName = productSelect.value;
                const quantity = parseInt(document.getElementById('productQuantity').value) || 0;
                const price = parseFloat(productSelect.selectedOptions[0].getAttribute('data-price')) || 0;

                if (!productName) {
                    alert("Por favor, selecciona un producto."); // Mensaje de error si no se selecciona un producto
                    return;
                }

                if (quantity <= 0) {
                    alert("Por favor, ingresa una cantidad válida."); // Mensaje de error si la cantidad es inválida
                    return;
                }

                if (price <= 0) {
                    alert("Por favor, ingresa una cantidad válida."); // Mensaje de error si el monto es inválido
                    return;
                }

                const totalPrice = quantity * price; // Calcular el total por producto

                const tableBody = document.getElementById('detailsTable').querySelector('tbody');
                const newRow = tableBody.insertRow();

                newRow.innerHTML = `
                    <td>${productName}</td>
                    <td><input type="number" value="${quantity}" min="1" class="form-control quantity-input" required></td>
                    <td>$${price.toFixed(2)}</td>
                    <td class="total-price">$${totalPrice.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger remove-button">Eliminar</button></td>
                `;

                newRow.classList.add('highlight-row'); // Agregar clase para resaltar la fila

                updateTotal();
                const productModal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                productModal.hide(); // Cerrar el modal
            });

            // Función para actualizar el total de gastos
            function updateTotal() {
                let total = 0;

                // Sumar los productos
                document.querySelectorAll('#detailsTable tbody tr').forEach(function (row) {
                    const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
                    const price = parseFloat(row.querySelector('.total-price').textContent.replace('$', '')) || 0;
                    total += price; // Cambiar a solo sumar el precio
                });

                // Sumar los gastos fijos
                document.querySelectorAll('#fixedExpensesTable tbody tr').forEach(function (row) {
                    const amount = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', '')) || 0;
                    total += amount; // Sumar el total de cada gasto fijo
                });

                // Actualizar el total en la tabla
                document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;
                document.getElementById('monto').value = total.toFixed(2); // Actualiza el campo de monto
            }

            // Evento para eliminar filas de la tabla
            document.getElementById('detailsTable').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-button')) {
                    const row = event.target.closest('tr');
                    row.remove();
                    updateTotal();
                }
            });

            // Mostrar el modal al hacer clic en el botón "Agregar Gasto Fijo"
            document.getElementById('addFixedExpenseButton').addEventListener('click', function () {
                const fixedExpenseModal = new bootstrap.Modal(document.getElementById('fixedExpenseModal'));
                document.getElementById('fixedExpenseName').value = '';
                document.getElementById('fixedExpenseAmount').value = '';
                fixedExpenseModal.show();
            });

            // Evento para agregar gastos fijos
            document.getElementById('confirmAddFixedExpense').addEventListener('click', function () {
                const fixedExpenseName = document.getElementById('fixedExpenseName').value;
                const amount = parseFloat(document.getElementById('fixedExpenseAmount').value);

                if (fixedExpenseName && amount > 0) {
                    const tableBody = document.getElementById('fixedExpensesTable').querySelector('tbody');
                    const newRow = tableBody.insertRow();

                    newRow.innerHTML = `
                        <td>${fixedExpenseName}</td>
                        <td>$${amount.toFixed(2)}</td>
                        <td><button type="button" class="btn btn-danger remove-fixed-expense-button">Eliminar</button></td>
                    `;

                    newRow.classList.add('highlight-row'); // Agregar clase para resaltar la fila

                    updateTotal(); // Asegúrate de que esta función también sume los gastos fijos
                    const fixedExpenseModal = bootstrap.Modal.getInstance(document.getElementById('fixedExpenseModal'));
                    fixedExpenseModal.hide(); // Cerrar el modal
                } else {
                    alert("Por favor, completa todos los campos y asegúrate de agregar el monto."); // Mensaje de error si los campos están vacíos o el monto es inválido
                }
            });

            // Evento para eliminar filas de la tabla de gastos fijos
            document.getElementById('fixedExpensesTable').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-fixed-expense-button')) {
                    const row = event.target.closest('tr');
                    row.remove();
                    updateTotal(); // Asegúrate de que esta función también sume los gastos fijos
                }
            });

            // Función para ordenar la tabla
            function sortTable(columnIndex) {
                const table = document.getElementById("detailsTable");
                const rows = Array.from(table.rows).slice(1); // Obtener todas las filas excepto el encabezado
                const isAscending = table.getAttribute("data-sort-order") === "asc"; // Determinar el orden actual

                rows.sort((a, b) => {
                    const aText = a.cells[columnIndex].textContent.trim();
                    const bText = b.cells[columnIndex].textContent.trim();

                    // Comparar según el tipo de dato
                    if (columnIndex === 1) { // Cantidad
                        return isAscending ? aText - bText : bText - aText;
                    } else if (columnIndex === 2) { // Precio Unitario
                        return isAscending ? aText - bText : bText - aText;
                    } else if (columnIndex === 3) { // Total
                        return isAscending ? aText - bText : bText - aText;
                    } else { // Producto
                        return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
                    }
                });

                // Reemplazar las filas en la tabla
                rows.forEach(row => table.appendChild(row));

                // Cambiar el orden actual
                table.setAttribute("data-sort-order", isAscending ? "desc" : "asc");
            }

            document.getElementById('gastoForm').addEventListener('submit', function (event) {
                const monto = parseFloat(document.getElementById('monto').value);
                if (monto <= 0) {
                    event.preventDefault(); // Evitar el envío del formulario
                    alert("El monto debe ser mayor que 0."); // Mensaje de error
                }
            });
        </script>

    </section>
@endsection


                            
                           