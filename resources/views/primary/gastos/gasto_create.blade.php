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
                        <form id="gastoForm" action="{{ route('gastos.store') }}" method="POST" novalidate>
                            @csrf 

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="description" class="form-label">Descripción del gasto</label>
                                    <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" value="{{ old('descripcion') }}" placeholder="Ej: Gastos de insumos" maxlength="100" required>
                                    @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>  
                                    @enderror
                                </div>

                                <input type="hidden" name="monto" id="monto" value="0.00">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Fecha del gasto</label>
                                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" id="fecha" value="{{ old('fecha') ?: date('Y-m-d') }}" required>
                                    @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <h2 class="card-subtitle text-center mb-3 mt-4" style="font-size: 22px;"><strong>Detalles de gastos</strong></h2>
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="addFixedExpenseButton">Agregar gasto fijo</button>
                            </div>

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
                                                <input type="text" id="fixedExpenseAmount" class="form-control @error('fixedExpenseAmount') is-invalid @enderror" min="0.01" value="" required maxlength="7" placeholder="Ej: 500.00" oninput="formato(this); calcular(); limitDigits(this)">
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
                            <table class="table" id="fixedExpensesTable">
                                <thead>
                                    <tr>
                                        <th>Gasto fijo</th>
                                        <th>Monto</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                </tbody>  
                            </table>
                            <div class="text-end">
                                <strong>Total Gastos Fijos:</strong>
                                <span id="totalFixedExpenses">$0.00</span>
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="addProductButton">Agregar producto</button>
                            </div>

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
                                                <input type="number" id="productQuantity" class="form-control @error('productQuantity') is-invalid @enderror" min="1" value="" required maxlength="2" oninput="this.value = this.value.slice(0, 2)">
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

                            <table class="table mt-3" id="detailsTable">
                                <thead>
                                    <tr>
                                        <th onclick="sortTable(0)">Producto</th>
                                        <th onclick="sortTable(1)">Cantidad</th>
                                        <th onclick="sortTable(2)">Precio Unitario</th>
                                        <th onclick="sortTable(3)">Total</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="detailsTableBody">   
                                </tbody>

                                <div class="text-end">
                                <strong>Total Productos:</strong>
                                <span id="totalProducts">$0.00</span>
                            </div>
                               
                                <tfoot style="margin-top: 40px; font-size: 20px;"> 
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total gastos :</strong></td>
                                        <td id="totalAmount">$0.00</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('gastos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        

        <script>
            let totalGastos = 0;

            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('gastoForm');
                form.reset();
                form.querySelectorAll('.is-invalid').forEach(function (input) {
                    input.classList.remove('is-invalid');
                });
                document.getElementById('monto').value = '0.00'; 
            });

            document.getElementById('addProductButton').addEventListener('click', function () {
                const productModal = new bootstrap.Modal(document.getElementById('productModal'));
                document.getElementById('productQuantity').value = '';
                productModal.show();
            });

            document.getElementById('confirmAddProduct').addEventListener('click', function () {
                const productSelect = document.getElementById('productSelect');
                const productName = productSelect.value;
                const quantity = parseInt(document.getElementById('productQuantity').value) || 0;
                const price = parseFloat(productSelect.selectedOptions[0].getAttribute('data-price')) || 0;

                if (!productName) {
                    alert("Por favor, selecciona un producto."); 
                    return;
                }

                if (quantity <= 0) {
                    alert("Por favor, ingresa una cantidad válida."); 
                    return;
                }

                if (price <= 0) {
                    alert("Por favor, ingresa una cantidad válida."); 
                    return;
                }

                const totalPrice = quantity * price; 

                const tableBody = document.getElementById('detailsTable').querySelector('tbody');
                const newRow = tableBody.insertRow();

                newRow.innerHTML = `
                    <td>${productName}</td>
                    <td><input type="text" value="${quantity}" class="form-control quantity-input" required disabled></td>
                    <td>$${price.toFixed(2)}</td>
                    <td class="total-price">$${totalPrice.toFixed(2)}</td>
                    <td class="text-end"><button type="button" class="btn btn-danger remove-button">Eliminar</button></td>
                `;

                newRow.classList.add('highlight-row'); 

                updateTotal();
                const productModal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                productModal.hide(); 
            });

            function updateTotal() {
                let total = 0;
                let totalFixed = 0;

                document.querySelectorAll('#detailsTable tbody tr').forEach(function (row) {
                    const price = parseFloat(row.querySelector('.total-price').textContent.replace('$', '')) || 0;
                    total += price; 
                });

                document.querySelectorAll('#fixedExpensesTable tbody tr').forEach(function (row) {
                    const amount = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', '')) || 0;
                    totalFixed += amount; 
                });

                totalGastos = total + totalFixed; 

                document.getElementById('totalAmount').textContent = `$${totalGastos.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
                document.getElementById('monto').value = totalGastos.toFixed(2); 

                document.getElementById('totalFixedExpenses').textContent = `$${totalFixed.toFixed(2)}`;
                document.getElementById('totalProducts').textContent = `$${total.toFixed(2)}`; 
            }

            document.getElementById('detailsTable').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-button')) {
                    const row = event.target.closest('tr');
                    row.remove();
                    updateTotal();
                }
            });

            document.getElementById('addFixedExpenseButton').addEventListener('click', function () {
                const fixedExpenseModal = new bootstrap.Modal(document.getElementById('fixedExpenseModal'));
                document.getElementById('fixedExpenseName').value = '';
                document.getElementById('fixedExpenseAmount').value = '';
                fixedExpenseModal.show();
            });

            document.getElementById('confirmAddFixedExpense').addEventListener('click', function () {
                const fixedExpenseName = document.getElementById('fixedExpenseName').value;
                const amount = parseFloat(document.getElementById('fixedExpenseAmount').value);

                if (fixedExpenseName && amount > 0) {
                    const tableBody = document.getElementById('fixedExpensesTable').querySelector('tbody');
                    const newRow = tableBody.insertRow();

                    newRow.innerHTML = `
                        <td>${fixedExpenseName}</td>
                        <td>$${amount.toFixed(2)}</td>
                        <td class="text-end"><button type="button" class="btn btn-danger remove-button">Eliminar</button></td>
                    `;

                    newRow.classList.add('highlight-row'); 

                    updateTotal(); 
                    const fixedExpenseModal = bootstrap.Modal.getInstance(document.getElementById('fixedExpenseModal'));
                    fixedExpenseModal.hide(); 
                } else {
                    alert("Por favor, completa todos los campos y asegúrate de agregar el monto."); 
                }
            });

            document.getElementById('fixedExpensesTable').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-button')) {
                    const row = event.target.closest('tr');
                    row.remove();
                    updateTotal(); 
                }
            });

            function sortTable(columnIndex) {
                const table = document.getElementById("detailsTable");
                const rows = Array.from(table.rows).slice(1); 
                const isAscending = table.getAttribute("data-sort-order") === "asc"; 

                rows.sort((a, b) => {
                    const aText = a.cells[columnIndex].textContent.trim();
                    const bText = b.cells[columnIndex].textContent.trim();

                    if (columnIndex === 1) { 
                        return isAscending ? aText - bText : bText - aText;
                    } else if (columnIndex === 2) { 
                        return isAscending ? aText - bText : bText - aText;
                    } else if (columnIndex === 3) { 
                        return isAscending ? aText - bText : bText - aText;
                    } else { 
                        return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
                    }
                });

                rows.forEach(row => table.appendChild(row));

                table.setAttribute("data-sort-order", isAscending ? "desc" : "asc");
            }

            document.getElementById('gastoForm').addEventListener('submit', function (event) {
                const monto = totalGastos; 
                if (monto <= 0) {
                    event.preventDefault(); 
                    alert("El monto debe ser mayor que 0."); 
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'monto'; 
                    hiddenInput.value = monto.toFixed(2);
                    this.appendChild(hiddenInput);
                }
            });

            function limitDigits(input) {
                const value = input.value;
                const regex = /^\d{0,4}(\.\d{0,2})?$/; 
                if (!regex.test(value)) {
                    input.value = value.slice(0, -1); 
                }
            }

            function saveTableData() {
                const fixedExpenses = [];
                const products = [];
                let totalFixed = 0;
                let totalProducts = 0;

                document.querySelectorAll('#fixedExpensesTable tbody tr').forEach(row => {
                    const cells = row.querySelectorAll('td');
                    fixedExpenses.push({
                        name: cells[0].textContent,
                        amount: parseFloat(cells[1].textContent.replace('$', ''))
                    });
                });

                document.querySelectorAll('#detailsTable tbody tr').forEach(row => {
                    const cells = row.querySelectorAll('td');
                    products.push({
                        name: cells[0].textContent,
                        quantity: parseInt(cells[1].querySelector('input').value),
                        price: parseFloat(cells[2].textContent.replace('$', '')),
                        total: parseFloat(cells[3].textContent.replace('$', ''))
                    });
                });

                totalFixed = fixedExpenses.reduce((sum, expense) => sum + expense.amount, 0);
                totalProducts = products.reduce((sum, product) => sum + product.total, 0);
                const totalAmount = totalFixed + totalProducts;

                localStorage.setItem('fixedExpenses', JSON.stringify(fixedExpenses));
                localStorage.setItem('products', JSON.stringify(products));
                localStorage.setItem('totalFixed', totalFixed.toFixed(2));
                localStorage.setItem('totalProducts', totalProducts.toFixed(2));
                localStorage.setItem('totalAmount', totalAmount.toFixed(2));
            }

            function loadTableData() {
                const fixedExpenses = JSON.parse(localStorage.getItem('fixedExpenses')) || [];
                const products = JSON.parse(localStorage.getItem('products')) || [];
                const totalFixed = parseFloat(localStorage.getItem('totalFixed')) || 0;
                const totalProducts = parseFloat(localStorage.getItem('totalProducts')) || 0;
                const totalAmount = parseFloat(localStorage.getItem('totalAmount')) || 0;

                const fixedExpensesTableBody = document.getElementById('fixedExpensesTable').querySelector('tbody');
                const detailsTableBody = document.getElementById('detailsTable').querySelector('tbody');

                fixedExpenses.forEach(expense => {
                    const newRow = fixedExpensesTableBody.insertRow();
                    newRow.innerHTML = `
                        <td>${expense.name}</td>
                        <td>$${expense.amount.toFixed(2)}</td>
                        <td class="text-end"><button type="button" class="btn btn-danger remove-button">Eliminar</button></td>
                    `;
                });

                products.forEach(product => {
                    const newRow = detailsTableBody.insertRow();
                    newRow.innerHTML = `
                        <td>${product.name}</td>
                        <td><input type="text" value="${product.quantity}" class="form-control quantity-input" required disabled></td>
                        <td>$${product.price.toFixed(2)}</td>
                        <td class="total-price">$${product.total.toFixed(2)}</td>
                        <td class="text-end"><button type="button" class="btn btn-danger remove-button">Eliminar</button></td>
                    `;
                });

                document.getElementById('totalFixedExpenses').textContent = `$${totalFixed.toFixed(2)}`;
                document.getElementById('totalProducts').textContent = `$${totalProducts.toFixed(2)}`;
                document.getElementById('totalAmount').textContent = `$${totalAmount.toFixed(2)}`;
            }

            document.addEventListener('DOMContentLoaded', loadTableData);

            document.getElementById('gastoForm').addEventListener('submit', function () {
                saveTableData();
            });
        </script>

    </section>
@endsection


                            
                           