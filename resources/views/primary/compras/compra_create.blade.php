<!-- resources/views/primary/compras/compra_create.blade.php -->
@extends('layouts.principal')
@section('title', 'Registrar Compra')

<section class="section">
    @if($usuario->rolpermiso->compras_crear == 1)
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="presupuesto">Presupuesto disponible:</label>
                                        <input type="text" class="form-control" value="L. {{number_format($presupuesto->cantidad - $presupuesto->gastado, 2, '.', ',')}}" readonly>
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
                                            <select name="productos" class="form-control" id="productos">
                                                <option value=""></option>
                                                @foreach($productos as $producto)
                                                    <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
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
        const form = document.getElementById('compraForm');
        const provSelect = document.getElementById('proveedor_id');
        let detalles = [];

        // Cuando cambia proveedor, recarga lista de productos
        function handleProveedor(el) {
            detalles = [];
            document.getElementById('bodyDetalles').innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay productos</td></tr>';
            provSelect.disabled = false;

            const productos = JSON.parse(el.selectedOptions[0]?.dataset.productos || '[]');
            const prodSel = document.getElementById('producto_select');
            prodSel.innerHTML = '<option value=""></option>' + productos.map(p => `<option value="${p.id}">${p.nombre}</option>`).join('');
        }

        // Agregar detalle
        document.getElementById('addProducto').addEventListener('click', () => {
            // Validaciones... (omitir por brevedad)
            // Suponiendo validación OK:
            const id = document.getElementById('producto_select').value;
            const nombre = document.getElementById('producto_select').selectedOptions[0]?.text;
            const cant = +document.getElementById('cantidad').value;
            const precio = +document.getElementById('precio').value;
            const desc = +document.getElementById('descuento').value;
            const total = (precio * cant) * (1 - desc / 100);

            detalles.push({producto_id: id, nombre, cantidad: cant, precio, descuento: desc, total});
            renderTabla();
        });

        // Render tabla de detalles
        function renderTabla() {
            const body = document.getElementById('bodyDetalles');
            body.innerHTML = '';
            let suma = 0;
            detalles.forEach((d,i) => {
                suma += d.total;
                body.innerHTML += `
        <tr>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="remove(${i})">Eliminar</button></td>
          <td>${d.nombre}</td>
          <td>${d.cantidad}</td>
          <td>${d.precio.toFixed(2)}</td>
          <td>${d.descuento}%</td>
          <td>${d.total.toFixed(2)}</td>
        </tr>
      `;
            });
            body.innerHTML += `
      <tr><td colspan="5" class="text-end"><strong>Total:</strong></td><td>${suma.toFixed(2)}</td></tr>
    `;
        }

        window.remove = function(i){ detalles.splice(i,1); renderTabla(); }

        // Antes de enviar, setear detalles y reactivar proveedor
        form.addEventListener('submit', function(e) {
            if (detalles.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto');
                return;
            }
            document.getElementById('detallesMandar').value = JSON.stringify(detalles);
            provSelect.disabled = false;
        });
    </script>
@endsection
