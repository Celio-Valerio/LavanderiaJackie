@extends('layouts.principal')
@section('title', 'Registrar Gastos')
@section('content')

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Editar gastos</h1>
                        <div class="invalid-feedback" id="formularioVacio"></div>
                        <hr>
                        <form id="gastoForm" action="{{ isset($gasto) ? route('gastos.update', $gasto->id) : route('gastos.store') }}" method="POST" novalidate>
                            @csrf
                            @if(isset($gasto))
                                @method('put')
                            @endif
                                <!-- Gastos fijos -->
                            <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Gastos fijos</strong></h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lblDescripcion"><strong>Descripción: </strong><br>{{$gasto->descripcion}}</label>
                                    </div>
                                </div>
                                @if($gasto->energia > 0)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblLuz"><strong>Energía eléctrica:</strong><br>L. {{ number_format($gasto->energia ?? 0, 2) }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if($gasto->agua > 0)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblAgua"><strong>Agua:</strong><br>L. {{ number_format($gasto->agua ?? 0, 2) }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if($gasto->renta > 0)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblRenta"><strong>Renta:</strong><br>L. {{ number_format($gasto->renta ?? 0, 2) }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if($gasto->nomina > 0)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblNomina"><strong>Nómina:</strong><br>L. {{ number_format($gasto->nomina ?? 0, 2) }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if($gasto->internet > 0)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblInternet"><strong>Internet:</strong><br>L. {{ number_format($gasto->internet ?? 0, 2) }}</label>
                                        </div>
                                    </div>
                                @endif
                                @if($gasto->totalG > 0)
                                    <div class="col-md-4">
                                        <label for="totalF"><strong>Total gastos fijos:</strong><br>L. {{ number_format($gasto->totalG ?? 0, 2) }}</label>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <label for="totalF"><strong>Ningún gasto fijo fue registrado en este registro.</strong></label>
                                    </div>
                                @endif

                            </div>
                            <hr style="margin-top: 40px">
                            <!-- Consumo -->
                            <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Editar consumo de productos</strong></h2>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-4">
                                    <label for="lblProducto">Producto:</label>
                                    <input type="text" name="producto" id="producto" class="form-control @error('producto') is-invalid @enderror" readonly>
                                    <div class="invalid-feedback" id="productoVacio"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lblCantidad">Cantidad adicional:</label>
                                        <input type="text" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" maxlength="6" value="{{old('cantidad')}}" oninput="validarSoloNumeros(this)">
                                        <div class="invalid-feedback" id="cantidadVacio"></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="opcion">Acción:</label> <br>
                                        <button class="btn btn-success" type="button" name="agrePro" id="agrePro">Agregar consumo</button>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin-top: 40px">
                            <div class="table-responsive">
                                <div class="invalid-feedback" id="tableVacia"></div>
                                <table class="table table-hover" style="font-size: 16px;">
                                    <thead>
                                    <th class="color">Opción</th>
                                    <th class="color">Producto</th>
                                    <th class="color">Cantidad consumida</th>
                                    <th class="color">Cantidad disponible</th>
                                    <th class="color">Consumo adicional</th>
                                    </thead>
                                    <tbody>
                                        @forelse($gasto->detalles as $detalle)
                                            <tr>
                                                @if($detalle->producto->stock > 0)
                                                    <td><button class="btn-eliminar btn btn-warning flex-fill"
                                                                type="button"
                                                                data-index="{{$loop->index}}"
                                                                data-stock="{{$detalle->producto->stock}}"
                                                                data-producto="{{$detalle->producto->nombre}}"
                                                                data-cantidad="{{$detalle->cantidad}}"
                                                                data-productoid="{{$detalle->producto->id}}">
                                                            Modificar
                                                        </button></td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{$detalle->producto->nombre}}</td>
                                                <td>{{$detalle->cantidad}}</td>
                                                <td>{{$detalle->producto->stock}}</td>
                                                <td>
                                                    <span class="cantidad-restante" data-id="{{$detalle->producto_id}}"></span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td><td colspan="5" style="text-align: center; color: grey;">No hay productos registrados</td></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <input type="hidden" name="detallesMandar" id="detallesMandar" value="">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button name="agregar" type="button" id="agregar" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Restablecer</button>
                                <a href="{{ route('gastos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script>
            const boton = document.querySelector(".btn-eliminar");
            document.addEventListener("DOMContentLoaded", function () {
                const botonesModificar = document.querySelectorAll(".btn-eliminar");

                botonesModificar.forEach((boton) => {
                    boton.addEventListener("click", function () {
                        // Obtener valores de los atributos data-*
                        const producto = boton.dataset.producto;
                        const stock = boton.dataset.stock;
                        const produc_id = boton.dataset.productoid;

                        // Asignar valores a los inputs
                        document.getElementById("producto").value = producto;

                        // Cambiar el foco al campo de cantidad para edición
                        document.getElementById("cantidad").focus();
                        window.stockDisponible = stock;
                        window.productoIden = produc_id;
                    });
                });
            });
            let detallesCompra = [];
            document.getElementById('agrePro').addEventListener('click', function (e) {
                e.preventDefault();
                const producto = document.getElementById('producto').value;
                const cantidad = document.querySelector('input[name="cantidad"]').value;
                const cantidadInput = document.querySelector('input[name="cantidad"]');
                const cantidadVacio = document.getElementById('cantidadVacio');
                const stock = parseInt(window.stockDisponible);
                const produc_id = parseInt(window.productoIden);

                cantidadVacio.style.display = 'none';
                cantidadVacio.textContent = '';

                let hayError = false;

                if(cantidad === '' && !producto || cantidad !== '' && !producto){
                    cantidadVacio.style.display = 'block';
                    cantidadInput.classList.add('is-invalid');
                    cantidadVacio.textContent = 'Por favor, seleccione un producto antes de ingresar la cantidad adicional.';
                    hayError = true;
                }
                else if (cantidad === '' || cantidad <= 0 || isNaN(cantidad)) {
                    cantidadVacio.style.display = 'block';
                    cantidadInput.classList.add('is-invalid');
                    if(cantidad === ''){
                        cantidadVacio.textContent = 'Por favor, ingrese la cantidad.';
                        hayError = true;
                    }
                    else if(cantidad <= 0){
                        cantidadVacio.textContent = 'Por favor, ingrese una cantidad mayor a 0.';
                        hayError = true;
                    }
                }

                else if(parseInt(stock) > 0 && parseInt(cantidad) > parseInt(stock)){
                    if(parseInt(cantidad) > parseInt(stock)){
                        cantidadVacio.style.display = 'block';
                        cantidadInput.classList.add('is-invalid');
                        cantidadVacio.textContent = 'Por favor, ingrese una cantidad menor o igual al stock disponible.';
                        hayError = true;
                    }
                }
                else{
                    cantidadInput.classList.remove('is-invalid');
                }

                if (hayError) {
                    return;
                }


                if (producto && cantidad) {
                    const productoExistente = detallesCompra.find(detalle => detalle.producto_id === produc_id);

                    if (productoExistente) {
                        // Sumar la cantidad si ya existe
                        const nuevaCantidad = parseInt(productoExistente.cantidad) + parseInt(cantidad);

                        // Validar que la nueva cantidad no supere el stock
                        if (nuevaCantidad > stock) {
                            cantidadVacio.style.display = 'block';
                            cantidadVacio.textContent = 'La cantidad total supera el stock disponible.';
                            return;
                        }

                        productoExistente.cantidad = nuevaCantidad;
                    } else {
                        // Agregar un nuevo producto si no existe
                        const detalle = {
                            producto_id: produc_id,
                            cantidad: cantidad,
                            index: boton.dataset.index,
                        };

                        detallesCompra.push(detalle);
                    }

                    actualizarTabla();
                    document.querySelector('input[name="producto"]').value = "";
                    document.querySelector('input[name="cantidad"]').value = "";
                    const detallesString = detallesCompra.map(item => `Producto ID: ${item.producto_id}, Cantidad: ${item.cantidad}`).join("\n");

                }
            });
            function actualizarTabla() {
                detallesCompra.forEach(detalle => {
                    // Buscamos el span correspondiente con el producto_id
                    const spanCantidad = document.querySelector(`span.cantidad-restante[data-id="${detalle.producto_id}"]`);
                    if (spanCantidad) {
                        // Actualizamos el texto del span con la nueva cantidad
                        spanCantidad.textContent = detalle.cantidad;
                    }
                });
            }
            document.getElementById('agregar').addEventListener('click', function(e) {
                e.preventDefault();
                const detallesMandar = document.getElementById('detallesMandar');
                detallesMandar.value = JSON.stringify(detallesCompra);

                document.querySelector('form').submit();
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Función para permitir solo números y validar el formato correcto para decimales
                window.validarSoloNumeros = function (input) {
                    input.value = input.value
                        .replace(/[^0-9]/g, "") // Permite solo números y un punto decimal
                        .replace(/^0+(?=\d)/, "0") // Permite un solo 0 al inicio, seguido de más números
                        .replace(/^0+(?!\.|$)/g, "") // Elimina ceros iniciales si no hay un punto o es solo un 0
                };
            });
        </script>
        <script>
            document.getElementById('clearButton').addEventListener('click', function () {
                location.reload();
            });
        </script>
    </section>
@endsection



