@extends('layouts.principal')
@section('title', 'Registrar Compra')
@section('content')

<section class="section">

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title" style="font-size: 30px !important;">Registrar compra</h1>
                <hr>
                @if(session('clearLocalStorage'))
                    <script>
                        localStorage.removeItem('detallesCompra');
                        localStorage.removeItem('productosSeleccionados');
                    </script>
                @endif

<form action="{{ route('compras.store') }}" method="POST" novalidate>
    @csrf
    <div class="col-md-12">
        <div class="form-group">
            <label for="proveedor_id">Proveedor:</label>
            <select name="proveedor_id" id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror" onchange="mostrarProductos(this); bloquearProveedor(this);" required>
                <option value=""></option>
                @foreach ($proveedores as $proveedor)
                    @if($proveedor->productos->count() > 0)
                        <option value="{{$proveedor->id}}" {{  (old('proveedor_id') == $proveedor->id) ? 'selected' : '' }} data-productos="{{ json_encode($proveedor->productos) }}">{{ $proveedor->full_name }}</option>
                    @endif
                @endforeach
            </select>
            @error('proveedor_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <!-- Información de la Factura -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-group">
                <label for="numero_factura">Número de Factura:</label>
                <input type="text" name="numero_factura" id="numero_factura" class="form-control @error('numero_factura') is-invalid @enderror" required maxlength="16" value="{{old('numero_factura')}}">
                @error('numero_factura')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="fecha_compra">Fecha de Compra:</label>
                <input type="date" name="fecha_compra" id="fecha_compra" class="form-control @error('fecha_compra') is-invalid @enderror" required value="{{ date('Y-m-d') }}" max="{{date('Y-m-d')}}">
                @error('fecha_compra')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>
    <!-- Descripción de la Compra -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{  old('descripcion') }}</textarea>
                @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div id="linea" class="col-mb-12 bg-primary"
         style="height: 3px; margin-bottom: 20px"
    > </div>
    <!-- Tabla de Detalles de la Compra -->
    <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Detalles de compra</strong></h2>
    <div id="detallesCompra">
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="detalles[0][producto_id]">Producto:</label>
                    <select name="productos" class="form-control" id="productos" required>
                        <option value=""></option>
                    </select>
                    <div class="invalid-feedback" id="productoVacio"></div>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="detalles[0][cantidad]">Cantidad:</label>
                    <input type="text" name="detalles[0][cantidad]" class="form-control" required placeholder="Ej: 10" maxlength="6">
                    <div class="invalid-feedback" id="cantidadVacio"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="detalles[0][precio]">Precio:</label>
                    <input type="text" name="detalles[0][precio]" class="form-control" required placeholder="Ej: 100.00" maxlength="6">
                    <div class="invalid-feedback" id="precioVacio"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="detalles[0][descuento]">Descuento:</label>
                    <input type="text" name="detalles[0][descuento]" class="form-control" required placeholder="Ej: 10.00 %" maxlength="3">
                    <div class="invalid-feedback" id="descuentoVacio"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="opcion">Acción:</label> <br>
                    <button class="btn btn-success btn-sm flex-fill me-0" name="agrePro" id="agrePro" style="height: 30px; width: 120px;">Agregar producto</button>
                </div>
            </div>
            <input type="hidden" name="detallesMandar" id="detallesMandar">
        </div>
    </div>

    <div class="table-responsive" style="margin-top: 50px; margin-bottom: 20px">
        <div class="invalid-feedback" id="tableVacia"></div>
        <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <th class="color">Opción</th>
                    <th class="color">Producto</th>
                    <th class="color">Cantidad</th>
                    <th class="color">Precio</th>
                    <th class="color">Descuento</th>
                    <th class="color">Total</th>
                </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Botones de acción -->
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary flex-fill me-1" name="registrar" id="registrar">Registrar</button>
        <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
        <a href="{{ route('compras.index') }}" class="btn btn-danger flex-fill">Regresar</a>
    </div>
</form>
<!-- Fin del formulario -->

            </div>
        </div>
    </div>
</div>

    <script>
        function mostrarProductos(select) {
            var productosJson = select.options[select.selectedIndex].getAttribute('data-productos');

            if (productosJson) {
                localStorage.setItem('productosSeleccionados', productosJson);
            }

            var product = document.getElementById('productos');

            if (productosJson) {
                var productos = JSON.parse(productosJson);
                var selectProductos = document.querySelector('select[name="productos"]');
                selectProductos.innerHTML = '<option value=""></option>';

                productos.forEach(function(producto) {
                    var option = document.createElement('option');
                    option.value = producto.id;
                    option.textContent = producto.nombre;
                    selectProductos.appendChild(option);
                });
            } else {
                var selectProductos = document.querySelector('select[name="productos"]');
                selectProductos.innerHTML = '<option value=""></option>';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            let savedProductos = localStorage.getItem('productosSeleccionados');

            if (savedProductos) {
                var productos = JSON.parse(savedProductos);
                var selectProductos = document.querySelector('select[name="productos"]');
                selectProductos.innerHTML = '<option value=""></option>';

                productos.forEach(function(producto) {
                    var option = document.createElement('option');
                    option.value = producto.id;
                    option.textContent = producto.nombre;
                    selectProductos.appendChild(option);
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let savedDetalles = localStorage.getItem('detallesCompra');
            if (savedDetalles) {
                detallesCompra = JSON.parse(savedDetalles);
                actualizarTabla();
            }

            if (detallesCompra.length === 0) {
                const tbody = document.querySelector('table tbody');
                const trVacio = document.createElement('tr');
                trVacio.innerHTML = `
            <td colspan="6" style="text-align: center; color: grey;">No hay productos aún</td>
        `;
                tbody.appendChild(trVacio);
            }
        });
        let detallesCompra = [];

        document.getElementById('agrePro').addEventListener('click', function (e) {
            e.preventDefault();

            const selectProducto = document.querySelector('select[name="productos"]');
            const cantidad = document.querySelector('input[name="detalles[0][cantidad]"]').value;
            const precio = document.querySelector('input[name="detalles[0][precio]"]').value;
            const descuento = document.querySelector('input[name="detalles[0][descuento]"]').value;
            const productoVacio = document.getElementById('productoVacio');
            const cantidadVacio = document.getElementById('cantidadVacio');
            const precioVacio = document.getElementById('precioVacio');
            const descuentoVacio = document.getElementById('descuentoVacio');
            const tableVac = document.getElementById('tableVacia');

            productoVacio.style.display = 'none';
            productoVacio.textContent = '';
            cantidadVacio.style.display = 'none';
            cantidadVacio.textContent = '';
            precioVacio.style.display = 'none';
            precioVacio.textContent = '';
            descuentoVacio.style.display = 'none';
            descuentoVacio.textContent = '';
            tableVac.style.display = 'none';
            tableVac.textContent = '';

            let hayError = false;

            if (!selectProducto.value) {
                productoVacio.style.display = 'block';
                productoVacio.textContent = 'Por favor, seleccione un producto.';
                hayError = true;
            }
            if (cantidad === '' || cantidad <= 0 || isNaN(cantidad)) {
                if(isNaN(cantidad)){
                    cantidadVacio.style.display = 'block';
                    cantidadVacio.textContent = 'Por favor, ingrese una cantidad numérica.';
                    hayError = true;
                }
                if(cantidad === ''){
                    cantidadVacio.style.display = 'block';
                    cantidadVacio.textContent = 'Por favor, ingrese la cantidad.';
                    hayError = true;
                }
                else if(cantidad <= 0){
                    cantidadVacio.style.display = 'block';
                    cantidadVacio.textContent = 'Por favor, ingrese una cantidad mayor a 0.';
                    hayError = true;
                }

            }
            if (precio === '' || precio <= 0 || isNaN(precio)) {
                if(isNaN(precio)){
                    precioVacio.style.display = 'block';
                    precioVacio.textContent = 'Por favor, ingrese un precio numérico.';
                    hayError = true;
                }
                if(precio === ''){
                    precioVacio.style.display = 'block';
                    precioVacio.textContent = 'Por favor, ingrese el precio.';
                    hayError = true;
                }
                else if(precio <= 0){
                    precioVacio.style.display = 'block';
                    precioVacio.textContent = 'Por favor, ingrese un precio mayor a 0.';
                    hayError = true;
                }

            }
            if (descuento === '' || descuento < 0 || descuento > 100 || isNaN(descuento)) {
                if(isNaN(descuento)){
                    descuentoVacio.style.display = 'block';
                    descuentoVacio.textContent = 'Por favor, ingrese un descuento numérico.';
                    hayError = true;
                }
                if(descuento === ''){
                    descuentoVacio.style.display = 'block';
                    descuentoVacio.textContent = 'Por favor, ingrese el descuento.';
                    hayError = true;
                }
                else if(descuento < 0 || descuento > 100){
                    descuentoVacio.style.display = 'block';
                    descuentoVacio.textContent = 'Por favor, ingrese un descuento entre 0 y 100.';
                    hayError = true;
                }
            }

            if (hayError) {
                return;
            }


            if (selectProducto.value && cantidad && precio && descuento) {
                const productoId = selectProducto.value;
                const productoNombre = selectProducto.options[selectProducto.selectedIndex].textContent;

                const subtotal = (parseFloat(precio) * parseInt(cantidad) - ((parseFloat(descuento) / 100) * parseFloat(precio) * parseInt(cantidad)) ) ;

                const detalle = {
                    producto_id: productoId,
                    nombre: productoNombre,
                    cantidad: cantidad,
                    precio: precio,
                    descuento: descuento,
                    total: subtotal
                };

                detallesCompra.push(detalle);

                localStorage.setItem('detallesCompra', JSON.stringify(detallesCompra));
                actualizarTabla();
                selectProducto.selectedIndex = 0;
                document.querySelector('input[name="detalles[0][cantidad]"]').value = "";
                document.querySelector('input[name="detalles[0][precio]"]').value = "";
                document.querySelector('input[name="detalles[0][descuento]"]').value = "";

            }
        });

        document.getElementById('registrar').addEventListener('click', function(e) {
            e.preventDefault();
            const tableVacia = document.getElementById('tableVacia');
            const detallesMandar = document.getElementById('detallesMandar');
            tableVacia.style.display = 'none';
            var prove = document.getElementById('proveedor_id');
            prove.disabled = false;


            if (!detallesCompra || detallesCompra.length === 0) {
                tableVacia.style.display = 'block';
                tableVacia.textContent = 'Por favor, ingrese al menos un producto antes de continuar con el registro.';
                return;
            }

            detallesMandar.value = JSON.stringify(detallesCompra);

            document.querySelector('form').submit();
        });

        function actualizarTabla() {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';

            if (detallesCompra.length === 0) {
                const trVacio = document.createElement('tr');
                trVacio.innerHTML = `
                    <td colspan="5" style="text-align: center; color: grey;">No hay productos aún</td>
                `;
                tbody.appendChild(trVacio);
                return;
            }

            let totalTabla = 0;

            detallesCompra.forEach(function (detalle, index) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td><button class="btn-eliminar btn btn-danger flex-fill" data-index="${index}">Eliminar</button></td>
                <td>${detalle.nombre}</td>
                <td>${detalle.cantidad}</td>
                <td>L. ${detalle.precio}</td>
                <td>${detalle.descuento} %</td>
                <td>L. ${detalle.total.toFixed(2)}</td>
            `;
                tbody.appendChild(tr);
                totalTabla += detalle.total;
            });

            document.querySelectorAll('.btn-eliminar').forEach(function (boton, index) {
                boton.setAttribute('data-index', index);
                boton.addEventListener('click', function () {
                    const index = boton.getAttribute('data-index');
                    detallesCompra.splice(index, 1);

                    localStorage.setItem('detallesCompra', JSON.stringify(detallesCompra));

                    actualizarTabla();
                });
            });



            const trTotal = document.createElement('tr');
            trTotal.innerHTML = `
                <td colspan="5" style="text-align: right"><strong>Total de la compra:</strong></td>
                <td><strong>L. ${totalTabla.toFixed(2)}</strong></td>
    `;
            tbody.appendChild(trTotal);
        }

    </script>



<script>
    document.getElementById('clearButton').addEventListener('click', function () {
        document.querySelector('form').reset();
        var prove = document.getElementById('proveedor_id');
        var numF = document.getElementById('numero_factura');
        var descrip = document.getElementById('descripcion');

        prove.selectedIndex = 0;
        prove.disabled = false;
        numF.value = '';
        descrip.value = '';
        detallesCompra = [];
        localStorage.removeItem('productosSeleccionados');
        localStorage.removeItem('detallesCompra');
        var invalidFeedbacks = document.querySelectorAll('.invalid-feedback');
        invalidFeedbacks.forEach(function(feedback) {
            feedback.style.display = 'none';
            feedback.textContent = '';
        });

        var inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            input.classList.remove('is-invalid');
        });

        var selectProductos = document.querySelector('select[name="productos"]');
        selectProductos.innerHTML = '<option value=""></option>';
        actualizarTabla();
    });
</script>
    <script>
        function bloquearProveedor() {
            var prove = document.getElementById('proveedor_id');
            if(prove.value !== ''){
                prove.disabled = true;
            }
        }
    </script>

    <script>
        window.onload = function (){
            var prove = document.getElementById('proveedor_id');
            if(prove.value !== ''){
                prove.disabled = true;
            }
        }
    </script>
</section>
@endsection