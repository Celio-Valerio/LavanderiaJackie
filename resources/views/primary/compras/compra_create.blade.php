<!-- resources/views/primary/compras/compra_create.blade.php -->
@extends('layouts.principal')
@section('title', 'Registrar Compra')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px;">Registrar compra</h1>
                        <hr>

                        @if(session('clearLocalStorage'))
                            <script>localStorage.clear();</script>
                        @endif

                        <form id="compraForm" action="{{ route('compras.store') }}" method="POST" novalidate>
                            @csrf
                            <input type="hidden" name="detallesMandar" id="detallesMandar" value="{{ old('detallesMandar') }}">

                            {{-- Proveedor y Factura --}}
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="proveedor_id">Proveedor:</label>
                                    <select name="proveedor_id" id="proveedor_id"
                                            class="form-control @error('proveedor_id') is-invalid @enderror"
                                            onchange="handleProveedor(this)" required>
                                        <option value=""></option>
                                        @foreach ($proveedores as $prov)
                                            @if($prov->productos->count())
                                                <option value="{{ $prov->id }}"
                                                        data-productos='@json($prov->productos)'
                                                    {{ old('proveedor_id') == $prov->id ? 'selected' : '' }}>
                                                    {{ $prov->full_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="numero_factura">Número de Factura:</label>
                                    <input type="text" name="numero_factura" id="numero_factura"
                                           class="form-control @error('numero_factura') is-invalid @enderror"
                                           required maxlength="16"
                                           value="{{ old('numero_factura') }}">
                                    @error('numero_factura')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="fecha_compra">Fecha de Compra:</label>
                                    <input type="date" name="fecha_compra" id="fecha_compra"
                                           class="form-control @error('fecha_compra') is-invalid @enderror"
                                           required
                                           value="{{ old('fecha_compra', date('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}">
                                    @error('fecha_compra')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Descripción --}}
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="descripcion">Descripción:</label>
                                    <textarea name="descripcion" id="descripcion"
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              required>{{ old('descripcion') }}</textarea>
                                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="mb-4">

                            {{-- Detalles Dinámicos --}}
                            <h2 class="mb-3">Detalles de compra</h2>
                            <div id="detallesCompra">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label>Producto:</label>
                                        <select id="producto_select" class="form-control">
                                            <option value=""></option>
                                        </select>
                                        <div class="invalid-feedback" id="productoError"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cantidad:</label>
                                        <input type="number" id="cantidad" class="form-control" placeholder="Ej: 10">
                                        <div class="invalid-feedback" id="cantidadError"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Precio:</label>
                                        <input type="number" step="0.01" id="precio" class="form-control" placeholder="Ej: 100.00">
                                        <div class="invalid-feedback" id="precioError"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Descuento %:</label>
                                        <input type="number" step="0.01" id="descuento" class="form-control" placeholder="0 - 100">
                                        <div class="invalid-feedback" id="descuentoError"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="addProducto" class="btn btn-success w-100">Agregar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive my-4">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Acción</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Desc %</th><th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyDetalles">
                                    <tr><td colspan="6" class="text-center text-muted">No hay productos</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Botones --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">Registrar</button>
                                <button type="reset" id="btnClear" class="btn btn-warning flex-fill">Limpiar</button>
                                <a href="{{ route('compras.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
