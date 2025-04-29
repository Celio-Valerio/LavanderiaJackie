@extends('layouts.principal')
@section('title', 'Registrar Gastos')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->gastos_crear == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $fechaAc = date('Y-m-d');
                                $primerDiaMes = date('Y-m-01');
                                $ultimoDiaMes = date('Y-m-t');
                                $hayGastos = false;
                                $fechaRegistro = '';
                                $luz = 0;
                                $agua = 0;
                                $renta = 0;
                                $nomina = 0;
                                $internet = 0;
                                $hayluz = false;
                                $hayagua = false;
                                $hayrenta = false;
                                $haynomina = false;
                                $hayinternet = false;
                            @endphp
                            @foreach($gastos as $gasto)
                                @if($gasto->fecha >= $primerDiaMes && $gasto->fecha <= $ultimoDiaMes)
                                    @if($gasto->energia > 0)
                                        @php
                                            $hayluz = true;
                                            $luz = $gasto->energia;
                                        @endphp
                                    @endif
                                    @if($gasto->agua > 0)
                                        @php
                                            $hayagua = true;
                                            $agua = $gasto->agua;
                                        @endphp
                                    @endif
                                    @if($gasto->renta > 0)
                                        @php
                                            $hayrenta = true;
                                            $renta = $gasto->renta;
                                        @endphp
                                    @endif
                                    @if($gasto->nomina > 0)
                                        @php
                                            $haynomina = true;
                                            $nomina = $gasto->nomina;
                                        @endphp
                                    @endif
                                    @if($gasto->internet > 0)
                                        @php
                                            $hayinternet = true;
                                            $internet = $gasto->internet;
                                        @endphp
                                    @endif
                                    @if($hayluz && $hayinternet && $hayrenta && $hayagua && $haynomina)
                                        @php
                                            $hayGastos = true;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            <h1 class="card-title" style="font-size: 30px !important;">Registrar gastos</h1>
                            @if($hayGastos === true)
                                <label for="lblInfo" class="card-title">Los gastos fijos ya han sido registrados.</label>
                            @endif
                            <div class="invalid-feedback" id="formularioVacio"></div>
                            <hr>
                            <form id="gastoForm" action="{{ route('gastos.store') }}" method="POST" novalidate>
                                @csrf
                                <!-- Gastos fijos -->
                                <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Gastos fijos</strong></h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblDescripcion">Descripción:</label>
                                            <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" maxlength="50" value="{{old('descripcion')}}">
                                            <div class="invalid-feedback" id="descripcionVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lblProducto">Gastos fijos:</label>
                                        <select name="gastosfijos" class="form-control @error('gastosfijos') is-invalid @enderror" id="gastosfijos" >
                                        </select>
                                        <div class="invalid-feedback" id="gastofijoVacio"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lblValor">Monto:</label>
                                            <input type="text" name="monto" id="monto" class="form-control" maxlength="6" value="{{old('monto')}}" oninput="validarSoloNumeros2(this)">
                                            <div class="invalid-feedback" id="montoVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="opcion">Acción:</label> <br>
                                            <button class="btn btn-success" name="agreGasto" id="agreGasto">Agregar gasto</button>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-top: 40px">
                                <div class="table-responsive">
                                    <div class="invalid-feedback" id="tableVacia2"></div>
                                    <table class="table table-hover" id="tablaGasto" style="font-size: 16px;">
                                        <thead>
                                        <th class="color">Opción</th>
                                        <th class="color">Gasto fijo</th>
                                        <th class="color">Monto</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <hr style="margin-top: 40px">
                                <!-- Consumo -->
                                <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Agregar consumo de productos</strong></h2>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-4">
                                        <label for="lblProducto">Productos:</label>
                                        <select name="productos" class="form-control @error('productos') is-invalid @enderror" id="productos"  onchange="mostrarStock()">
                                            <option value=""></option>
                                            @foreach($productos as $producto)
                                                @if($producto->stock > 0)
                                                    <option value="{{$producto->id}}" data-stock="{{$producto->stock}}">
                                                        {{$producto->nombre}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="productoVacio"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="stock">Stock disponible:</label>
                                        <input type="text" id="stock" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblCantidad">Cantidad consumida:</label>
                                            <input type="text" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" maxlength="6" value="{{old('cantidad')}}" oninput="validarSoloNumeros(this)">
                                            <div class="invalid-feedback" id="cantidadVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="opcion">Acción:</label>
                                            <button class="btn btn-success" name="agrePro" id="agrePro">Agregar consumo</button>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-top: 40px">
                                <div class="table-responsive">
                                    <div class="invalid-feedback" id="tableVacia"></div>
                                    <table class="table table-hover" id="tablaConsumo" style="font-size: 16px;">
                                        <thead>
                                        <th class="color">Opción</th>
                                        <th class="color">Producto</th>
                                        <th class="color">Cantidad</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div>
                                        <input type="hidden" name="totalFij" id="totalFij" value="">
                                        <input type="hidden" name="detallesMandar2" id="detallesMandar2" value="">
                                        <input type="hidden" name="detallesMandar" id="detallesMandar" value="">
                                        <input type="hidden" name="hayinternet" id="hayinternet" value="{{$hayinternet ? $hayinternet : 0}}">
                                        <input type="hidden" name="haynomina" id="haynomina" value="{{$haynomina ? $haynomina : 0}}">
                                        <input type="hidden" name="hayrenta" id="hayrenta" value="{{$hayrenta ? $hayrenta : 0}}">
                                        <input type="hidden" name="hayagua" id="hayagua" value="{{$hayagua ? $hayagua : 0}}">
                                        <input type="hidden" name="hayluz" id="hayluz" value="{{$hayluz ? $hayluz : 0}}">
                                        <input type="hidden" name="hayGastos" id="hayGastos" value="{{$hayGastos ? $hayGastos : 0}}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button name="agregar" type="button" id="agregar" class="btn btn-primary flex-fill me-1">Registrar</button>
                                    <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                    <a href="{{ route('gastos.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                                </div>
                            </form>

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
            document.addEventListener("DOMContentLoaded", function () {
                // Función para validar que solo se ingresen números y un único punto decimal
                window.validarSoloNumeros2 = function (input) {
                    input.value = input.value
                        .replace(/[^0-9.]/g, "")          // Permite solo números y puntos
                        .replace(/^0(?!\.)/, "")          // Elimina ceros iniciales si no están seguidos por un punto
                        .replace(/^\./, "")              // Elimina un punto al principio
                        .replace(/(\..*)\./g, "$1");    // Permite un solo punto en el valor
                };
            });
        </script>
        <!-- Manejo de la tabla -->
        <script>
            let detallesCompra = [];
            let detallesFijos = [];
            document.addEventListener('DOMContentLoaded', function () {
                // Simula el arreglo de detallesCompra
                const hayGastos = document.getElementById('hayGastos').value;
                if(parseInt(hayGastos) === 1){
                    const tbody = document.querySelector('#tablaGasto tbody'); // Selecciona el tbody de la tabla
                    const trVacio = document.createElement('tr');

                    trVacio.innerHTML = `
            <td colspan="2" style="text-align: center; color: grey;">Los gastos fijos ya han sido registrados este mes</td>
        `;

                    tbody.appendChild(trVacio);
                }

                if (detallesFijos.length === 0 && parseInt(hayGastos) === 0) {
                    const tbody = document.querySelector('#tablaGasto tbody'); // Selecciona el tbody de la tabla
                    const trVacio = document.createElement('tr');

                    trVacio.innerHTML = `
            <td colspan="3" style="text-align: center; color: grey;">No hay gastos fijos</td>
        `;

                    tbody.appendChild(trVacio);
                }
            });
            document.addEventListener('DOMContentLoaded', function () {
                // Simula el arreglo de detallesCompra

                if (detallesCompra.length === 0) {
                    const tbody = document.querySelector('#tablaConsumo tbody'); // Selecciona el tbody de la tabla
                    const trVacio = document.createElement('tr');

                    trVacio.innerHTML = `
            <td colspan="3" style="text-align: center; color: grey;">No hay productos aún</td>
        `;

                    tbody.appendChild(trVacio);
                }
            });


            document.getElementById('agrePro').addEventListener('click', function (e) {
                e.preventDefault();

                const selectProducto = document.querySelector('select[name="productos"]');
                const cantidad = document.querySelector('input[name="cantidad"]').value;
                const cantidadInput = document.querySelector('input[name="cantidad"]');
                const tableVacia = document.getElementById('tableVacia');
                const productoVacio = document.getElementById('productoVacio');
                const cantidadVacio = document.getElementById('cantidadVacio');
                const select = document.getElementById('productos');
                var cant = document.getElementById('stock');
                var stock = parseInt(select.options[select.selectedIndex].getAttribute('data-stock')) || 0;


                productoVacio.style.display = 'none';
                productoVacio.textContent = '';
                cantidadVacio.style.display = 'none';
                cantidadVacio.textContent = '';
                tableVacia.style.display = 'none';
                tableVacia.textContent = '';

                let hayError = false;

                if (!selectProducto.value) {
                    selectProducto.classList.add('is-invalid');
                    productoVacio.style.display = 'block';
                    productoVacio.textContent = 'Por favor, seleccione un producto.';
                    hayError = true;
                }
                else{
                    selectProducto.classList.remove('is-invalid');
                }

                if (cantidad === '' || cantidad <= 0 || isNaN(cantidad)) {
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

                else if(cantidad > 0 && !selectProducto.value){
                    cantidadVacio.style.display = 'block';
                    cantidadInput.classList.add('is-invalid');
                    cantidadVacio.textContent = 'Por favor, seleccione un producto antes de ingresar la cantidad.';
                    hayError = true;
                }

                else if(stock > 0 && cantidad > stock){
                    if(cantidad > stock){
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


                if (selectProducto.value && cantidad) {
                    const productoId = selectProducto.value;
                    const productoNombre = selectProducto.options[selectProducto.selectedIndex].textContent;
                    const productoExistente = detallesCompra.find(detalle => detalle.producto_id === productoId);

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
                            producto_id: productoId,
                            nombre: productoNombre,
                            cantidad: cantidad,
                        };

                        detallesCompra.push(detalle);
                    }

                    actualizarTabla();
                    selectProducto.selectedIndex = 0;
                    cant.value = "";
                    document.querySelector('input[name="cantidad"]').value = "";

                }
            });

            document.getElementById('agreGasto').addEventListener('click', function(e) {
                e.preventDefault();
                const gastosfijos = document.querySelector('select[name="gastosfijos"]')
                const gastosfijosInput = document.getElementById("gastosfijos");
                const gastofijoVacio = document.getElementById('gastofijoVacio');
                const monto = document.getElementById('monto').value;
                const montoInput = document.getElementById("monto");
                const montoVacio = document.getElementById('montoVacio');

                gastofijoVacio.style.display = 'none';
                gastofijoVacio.textContent = '';
                montoVacio.style.display = 'none';
                montoVacio.textContent = '';

                let hayError = false;


                if (!gastosfijos.value) {
                    gastosfijos.classList.add('is-invalid');
                    gastofijoVacio.style.display = 'block';
                    gastofijoVacio.textContent = 'Por favor, seleccione un gasto fijo.';
                    hayError = true;
                }
                else{
                    gastosfijosInput.classList.remove('is-invalid');
                }

                if (monto === '' || monto <= 0 || isNaN(monto)) {
                    montoVacio.style.display = 'block';
                    montoInput.classList.add('is-invalid');
                    if(monto === ''){
                        montoVacio.textContent = 'Por favor, ingrese el monto.';
                        hayError = true;
                    }
                    else if(monto <= 0){
                        montoVacio.textContent = 'Por favor, ingrese un monto mayor a 0.';
                        hayError = true;
                    }
                }

                else if(monto > 0 && !gastosfijos.value){
                    montoVacio.style.display = 'block';
                    montoInput.classList.add('is-invalid');
                    montoVacio.textContent = 'Por favor, seleccione un gasto fijo antes de ingresar el monto.';
                    hayError = true;
                }

                else if(monto < 100){
                    montoVacio.style.display = 'block';
                    montoInput.classList.add('is-invalid');
                    montoVacio.textContent = 'El monto debe ser mayor o igual a L. 100.00.';
                    hayError = true;

                }
                else{
                    montoInput.classList.remove('is-invalid');
                }

                if (hayError) {
                    return;
                }


                if (gastosfijos.value && monto) {
                    const productoNombre = gastosfijos.options[gastosfijos.selectedIndex].textContent;
                    const productoExistente = detallesFijos.find(detalle => detalle.gastosfijos === productoNombre);

                    // Agregar un nuevo producto si no existe
                    const detalle = {
                        valor: gastosfijos.value,
                        gastosfijos: productoNombre,
                        monto : parseFloat(monto),
                    };

                    detallesFijos.push(detalle);

                    actualizarTabla2();
                    selectVacio();
                    gastosfijos.selectedIndex = 0;
                    monto.value = "";
                    document.querySelector('input[name="monto"]').value = "";

                }

            });

            function selectVacio(){
                // Elemento del select donde se agregarán las opciones
                const selectElement = document.getElementById("gastosfijos");
                const hayluz = document.getElementById("hayluz");
                const hayagua = document.getElementById("hayagua");
                const hayrenta = document.getElementById("hayrenta");
                const haynomina = document.getElementById("haynomina");
                const hayinternet = document.getElementById("hayinternet");

                // Función para agregar una opción al select
                function agregarOpcion(value, texto) {
                    const option = document.createElement("option");
                    option.value = value;
                    option.textContent = texto;
                    selectElement.appendChild(option);
                }

                    // Limpiar las opciones previas (si es necesario)
                    selectElement.innerHTML = "";

                    // Agregar la opción vacía
                    agregarOpcion("", "");

                    // Agregar opciones según los valores de los gastos
                    if (parseInt(hayluz.value) === 0 && !detallesFijos.some(detalle => detalle.gastosfijos === "Energía eléctrica")) {
                        agregarOpcion("luz", "Energía eléctrica");
                    }
                    if (parseInt(hayagua.value) === 0 && !detallesFijos.some(detalle => detalle.gastosfijos === "Agua")) {
                        agregarOpcion("agua", "Agua");
                    }
                    if (parseInt(haynomina.value) === 0 && !detallesFijos.some(detalle => detalle.gastosfijos === "Nómina")) {
                        agregarOpcion("nomina", "Nómina");
                    }
                    if (parseInt(hayrenta.value) === 0 && !detallesFijos.some(detalle => detalle.gastosfijos === "Renta")) {
                        agregarOpcion("renta", "Renta");
                    }
                    if (parseInt(hayinternet.value) === 0 && !detallesFijos.some(detalle => detalle.gastosfijos === "Internet")) {
                        agregarOpcion("internet", "Internet");
                    }

            }


            document.getElementById('agregar').addEventListener('click', function(e) {
                e.preventDefault();
                const hayGastos = document.getElementById('hayGastos').value;
                const tableVacia = document.getElementById('tableVacia');
                const totalFij = document.getElementById('totalFij');
                const detallesMandar2 = document.getElementById('detallesMandar2');
                const detallesMandar = document.getElementById('detallesMandar');
                const descripcion = document.getElementById('descripcion').value;
                const descripcionInput = document.getElementById("descripcion");
                const descripcionVacio = document.getElementById('descripcionVacio');
                const formularioVacio = document.getElementById('formularioVacio');
                const regex = /^[\p{L}áéíóúüñ]+(?: [\p{L}áéíóúüñ]+)*$/u;

                descripcionVacio.style.display = 'none';
                descripcionVacio.textContent = '';
                formularioVacio.style.display = 'none';
                formularioVacio.textContent = '';
                tableVacia.style.display = 'none';
                tableVacia.textContent = '';

                let hayError = false;
                let hayDato = false;

                if(descripcion === '' || !regex.test(descripcion)){
                    descripcionVacio.style.display = 'block';
                    descripcionInput.classList.add('is-invalid');
                    if(descripcion === ''){
                        descripcionVacio.textContent = 'Por favor, ingrese la descripción.';
                        hayError = true;
                    }
                    else if(!regex.test(descripcion)){
                        descripcionVacio.textContent = 'La descripción contiene caracteres no válidos.';
                        hayError = true;
                    }
                }
                else{
                    descripcionInput.classList.remove('is-invalid');
                }
                if(detallesFijos.length > 0){
                    hayDato = true;
                }

                if(parseInt(hayGastos) === 1){
                    if ((!detallesCompra || detallesCompra.length === 0) || hayError) {
                        if(!detallesCompra || detallesCompra.length === 0){
                            tableVacia.style.display = 'block';
                            tableVacia.textContent = 'Por favor, ingrese al menos un comsumo de producto.';
                        }
                        return;
                    }
                }else{
                    if ((!detallesCompra || detallesCompra.length === 0 && !hayDato) || hayError) {
                        if(!detallesCompra || detallesCompra.length === 0 && !hayDato){
                            formularioVacio.style.display = 'block';
                            formularioVacio.textContent = 'Por favor, ingrese al menos un gasto fijo o un consumo de producto.';
                        }
                        return;
                    }
                }
                const totalMonto = detallesFijos.reduce((suma, detalle) => suma + parseFloat(detalle.monto), 0);
                totalFij.value = totalMonto;
                detallesMandar2.value = JSON.stringify(detallesFijos);
                detallesMandar.value = JSON.stringify(detallesCompra);

                document.querySelector('form').submit();
            });

            function actualizarTabla2() {
                // Selecciona el tbody de la tabla correspondiente
                const tbody = document.querySelector('#tablaGasto tbody');
                tbody.innerHTML = ''; // Limpia el contenido del tbody

                // Si no hay datos en detallesFijos, muestra el mensaje de "No hay gastos fijos registrados"
                if (detallesFijos.length === 0) {
                    const trVacio = document.createElement('tr');
                    trVacio.innerHTML = `
                        <td colspan="2" style="text-align: center; color: grey;">No hay gastos fijos</td>
                    `;
                    tbody.appendChild(trVacio);
                    return;
                }

                // Recorre el array detallesFijos y genera las filas para la tabla
                detallesFijos.forEach(function (detalle, index) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td><button type="button" class="btn-eliminar2 btn btn-danger flex-fill" data-index="${index}">Eliminar</button></td>
                    <td>${detalle.gastosfijos}</td>
                    <td>L ${detalle.monto}</td>
                `;
                    tbody.appendChild(tr);
                });
                const totalMonto = detallesFijos.reduce((suma, detalle) => suma + parseFloat(detalle.monto), 0);

                // Agrega una fila al final de la tabla para mostrar el total
                const trTotal = document.createElement('tr');
                trTotal.innerHTML = `
                    <td style="font-weight: bold; text-align: right;" colspan="2">Total:</td>
                    <td style="font-weight: bold;">L ${totalMonto.toFixed(2)}</td>
                `;
                tbody.appendChild(trTotal);
                document.querySelectorAll('.btn-eliminar2').forEach(function (boton, index) {
                    boton.setAttribute('data-index', index);
                    boton.addEventListener('click', function () {
                        const index = boton.getAttribute('data-index');
                        detallesFijos.splice(index, 1);
                        actualizarTabla2();
                        selectVacio();
                    });
                });
            }

            function actualizarTabla() {
                const tbody = document.querySelector('#tablaConsumo tbody');
                tbody.innerHTML = '';

                if (detallesCompra.length === 0) {
                    const trVacio = document.createElement('tr');
                    trVacio.innerHTML = `
                    <td colspan="5" style="text-align: center; color: grey;">No hay productos aún</td>
                `;
                    tbody.appendChild(trVacio);
                    return;
                }

                detallesCompra.forEach(function (detalle, index) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                <td><button class="btn-eliminar btn btn-danger flex-fill" data-index="${index}">Eliminar</button></td>
                <td>${detalle.nombre}</td>
                <td>${detalle.cantidad}</td>
            `;
                    tbody.appendChild(tr);
                });

                document.querySelectorAll('.btn-eliminar').forEach(function (boton, index) {
                    boton.setAttribute('data-index', index);
                    boton.addEventListener('click', function () {
                        const index = boton.getAttribute('data-index');
                        detallesCompra.splice(index, 1);
                        actualizarTabla();
                    });
                });

            }

        </script>
        <script>
            document.getElementById('clearButton').addEventListener('click', function () {
                location.reload();
            });
        </script>

        <script>
            function mostrarStock(){
                const select = document.getElementById('productos');
                var stock = select.options[select.selectedIndex].getAttribute('data-stock') || 0;
                var mostrar = document.getElementById('stock');

                mostrar.value = stock;

            }
        </script>
        <script>
            window.onload = function (){
                selectVacio();
            }
        </script>


    </section>
@endsection
