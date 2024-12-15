@extends('layouts.principal')
@section('title', 'Registrar Gastos')
@section('content')

    <section class="section">

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
                        @endphp
                        @foreach($gastos as $gasto)
                            @if($gasto->fecha >= $primerDiaMes && $gasto->fecha <= $ultimoDiaMes)
                                @if($gasto->totalG > 0)
                                    @php
                                        $hayGastos = true;
                                        $fechaRegistro = $gasto->fecha;
                                        $luz = $gasto->energia;
                                        $agua = $gasto->agua;
                                        $renta = $gasto->renta;
                                        $nomina = $gasto->nomina;
                                        $internet = $gasto->internet;
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar gastos</h1>
                        @if($hayGastos === true)
                            <label for="lblInfo" class="card-title">Los gastos fijos ya han sido registrados el día {{ \Carbon\Carbon::parse($fechaRegistro)->translatedFormat('l d \d\e F, Y') }}</label>
                        @endif
                        <div class="invalid-feedback" id="formularioVacio"></div>
                        <hr>
                        <form id="gastoForm" action="{{ route('gastos.store') }}" method="POST" novalidate>
                            @csrf

                            <!-- Gastos fijos -->
                            <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Gastos fijos</strong></h2>
                            <div class="row">
                                @if($hayGastos === false)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblDescripcion">Descripción:</label>
                                            <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" maxlength="50" value="{{old('descripcion')}}">
                                            <div class="invalid-feedback" id="descripcionVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblLuz">Energía eléctrica:</label>
                                            <input type="text" name="luz" id="luz" class="form-control @error('luz') is-invalid @enderror" maxlength="6" value="{{old('luz')}}" oninput="validarSoloNumeros2(this); calcular(this)">
                                            <div class="invalid-feedback" id="luzVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblAgua">Agua:</label>
                                            <input type="text" name="agua" id="agua" class="form-control @error('agua') is-invalid @enderror" maxlength="6" value="{{old('agua')}}" oninput="validarSoloNumeros2(this); calcular(this)">
                                            <div class="invalid-feedback" id="aguaVacio"></div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lblRenta">Renta:</label>
                                                <input type="text" name="renta" id="renta" class="form-control @error('renta') is-invalid @enderror" maxlength="6" value="{{old('renta')}}" oninput="validarSoloNumeros2(this); calcular(this)">
                                                <div class="invalid-feedback" id="rentaVacio"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lblNomina">Nómina:</label>
                                                <input type="text" name="nomina" id="nomina" class="form-control @error('nomina') is-invalid @enderror" maxlength="6" value="{{old('nomina')}}" oninput="validarSoloNumeros2(this); calcular(this)">
                                                <div class="invalid-feedback" id="nominaVacio"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lblInternet">Internet:</label>
                                                <input type="text" name="internet" id="internet" class="form-control @error('internet') is-invalid @enderror" maxlength="6" value="{{old('internet')}}" oninput="validarSoloNumeros2(this); calcular(this)">
                                                <div class="invalid-feedback" id="internetVacio"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-md-4">
                                            <label for="totalF">Total gastos fijos:</label>
                                            <input type="text" id="TotalF" name="TotalF" class="form-control" readonly>
                                        </div>
                                    </div>
                                @else
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblDescripcion">Descripción:</label>
                                            <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" maxlength="50" value="{{old('descripcion')}}">
                                            <div class="invalid-feedback" id="descripcionVacio"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblLuz">Energía eléctrica:</label>
                                            <input type="text" name="luz" id="luz" class="form-control" maxlength="6" value="{{isset($gasto) ? $luz : old('luz')}}" readonly>
                                            <div class="invalid-feedback" id="luzVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblAgua">Agua:</label>
                                            <input type="text" name="agua" id="agua" class="form-control" maxlength="6" value="{{isset($gasto) ? $agua : old('agua')}}" readonly>
                                            <div class="invalid-feedback" id="aguaVacio"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblRenta">Renta:</label>
                                            <input type="text" name="renta" id="renta" class="form-control" maxlength="6" value="{{isset($gasto) ? $renta : old('renta')}}" readonly>
                                            <div class="invalid-feedback" id="rentaVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblNomina">Nómina:</label>
                                            <input type="text" name="nomina" id="nomina" class="form-control" maxlength="6" value="{{isset($gasto) ? $nomina : old('nomina')}}" readonly>
                                            <div class="invalid-feedback" id="nominaVacio"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblInternet">Internet:</label>
                                            <input type="text" name="internet" id="internet" class="form-control" maxlength="6" value="{{isset($gasto) ? $internet : old('internet')}}" readonly>
                                            <div class="invalid-feedback" id="internetVacio"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-4">
                                        <label for="totalF">Total gastos fijos:</label>
                                        <input type="text" id="TotalF" name="TotalF" class="form-control" readonly value="{{ number_format(($luz ?? 0) + ($agua ?? 0) + ($nomina ?? 0) + ($renta ?? 0) + ($internet ?? 0), 2) }}">
                                    </div>
                                </div>
                                @endif
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
                                        <label for="opcion">Acción:</label> <br>
                                        <button class="btn btn-success" name="agrePro" id="agrePro">Agregar consumo</button>
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
                                        <th class="color">Cantidad</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div>
                                    <input type="hidden" name="detallesMandar" id="detallesMandar" value="">
                                    <input type="hidden" name="hayGastos" id="hayGastos" value="{{$hayGastos}}">
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
        <script>
            function calcular(){
                var luz = parseInt(document.getElementById('luz').value) || 0;
                var agua = parseInt(document.getElementById('agua').value) || 0;
                var renta = parseInt(document.getElementById('renta').value) || 0;
                var nomina = parseInt(document.getElementById('nomina').value) || 0;
                var internet = parseInt(document.getElementById('internet').value) || 0;
                var total = document.getElementById('TotalF');

                total.value = luz + agua + renta + nomina + internet;
            }
        </script>
        <!-- Manejo de la tabla -->
        <script>
            let detallesCompra = [];
            document.addEventListener('DOMContentLoaded', function () {
                if (detallesCompra.length === 0) {
                    const tbody = document.querySelector('table tbody');
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

            document.getElementById('agregar').addEventListener('click', function(e) {
                e.preventDefault();
                const hayGastos = document.getElementById('hayGastos').value;
                const tableVacia = document.getElementById('tableVacia');
                const detallesMandar = document.getElementById('detallesMandar');
                const descripcion = document.getElementById('descripcion').value;
                const descripcionInput = document.getElementById("descripcion");
                const luz = document.getElementById('luz').value;
                const agua = document.getElementById('agua').value;
                const renta = document.getElementById('renta').value;
                const nomina = document.getElementById('nomina').value;
                const internet = document.getElementById('internet').value;
                const luzInput = document.getElementById("luz");
                const aguaInput = document.getElementById("agua");
                const rentaInput = document.getElementById("renta");
                const nominaInput = document.getElementById("nomina");
                const internetInput = document.getElementById("internet");
                const luzVacio = document.getElementById('luzVacio');
                const aguaVacio = document.getElementById('aguaVacio');
                const rentaVacio = document.getElementById('rentaVacio');
                const nominaVacio = document.getElementById('nominaVacio');
                const internetVacio = document.getElementById('internetVacio');
                const descripcionVacio = document.getElementById('descripcionVacio');
                const formularioVacio = document.getElementById('formularioVacio');
                const regex = /^[\p{L}áéíóúüñ]+(?: [\p{L}áéíóúüñ]+)*$/u;

                descripcionVacio.style.display = 'none';
                descripcionVacio.textContent = '';
                luzVacio.style.display = 'none';
                luzVacio.textContent = '';
                aguaVacio.style.display = 'none';
                aguaVacio.textContent = '';
                rentaVacio.style.display = 'none';
                rentaVacio.textContent = '';
                nominaVacio.style.display = 'none';
                nominaVacio.textContent = '';
                internetVacio.style.display = 'none';
                internetVacio.textContent = '';
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
                if(luz !== '' || agua !== '' || renta !== '' || nomina !== '' || internet !== ''){
                    hayDato = true;
                }

                if(hayDato){
                    if(luz === '' || luz < 100){
                        luzVacio.style.display = 'block';
                        luzInput.classList.add('is-invalid');
                        if(luz === ''){
                            luzVacio.textContent = 'Si se ingresa un gasto fijo, los demás son obligatorios.';
                            hayError = true;
                        }
                        else if(parseFloat(luz) < 100){
                            luzVacio.textContent = 'El gasto de energía eléctrica debe ser de al menos L.100.00.';
                            hayError = true;
                        }
                    }
                    else{
                        luzInput.classList.remove('is-invalid');
                    }
                    if(agua === '' || agua < 100){
                        aguaVacio.style.display = 'block';
                        aguaInput.classList.add('is-invalid');
                        if(agua === ''){
                            aguaVacio.textContent = 'Si se ingresa un gasto fijo, los demás son obligatorios.';
                            hayError = true;
                        }
                        else if(parseFloat(agua) < 100){
                            aguaVacio.textContent = 'El gasto de agua debe ser de al menos L.100.00.';
                            hayError = true;
                        }
                    }
                    else{
                        aguaInput.classList.remove('is-invalid');
                    }
                    if(renta === '' || renta < 100){
                        rentaVacio.style.display = 'block';
                        rentaInput.classList.add('is-invalid');
                        if(renta === ''){
                            rentaVacio.textContent = 'Si se ingresa un gasto fijo, los demás son obligatorios.';
                            hayError = true;
                        }
                        else if(parseFloat(renta) < 100){
                            rentaVacio.textContent = 'El gasto por la renta debe ser de al menos L.100.00.';
                            hayError = true;
                        }
                    }
                    else{
                        rentaInput.classList.remove('is-invalid');
                    }
                    if(nomina === '' || nomina < 100){
                        nominaVacio.style.display = 'block';
                        nominaInput.classList.add('is-invalid');
                        if(nomina === ''){
                            nominaVacio.textContent = 'Si se ingresa un gasto fijo, los demás son obligatorios.';
                            hayError = true;
                        }
                        else if(parseFloat(nomina) < 100){
                            nominaVacio.textContent = 'El gasto por la nómina debe ser de al menos L.100.00.';
                            hayError = true;
                        }
                    }
                    else{
                        nominaInput.classList.remove('is-invalid');
                    }
                    if(internet === '' || internet < 100){
                        internetVacio.style.display = 'block';
                        internetInput.classList.add('is-invalid');
                        if(internet === ''){
                            internetVacio.textContent = 'Si se ingresa un gasto fijo, los demás son obligatorios.';
                            hayError = true;
                        }
                        else if(parseFloat(internet) < 100){
                            internetVacio.textContent = 'El gasto por el internet debe ser de al menos L.100.00.';
                            hayError = true;
                        }
                    }
                    else{
                        internetInput.classList.remove('is-invalid');
                    }
                }
                else{
                    aguaInput.classList.remove('is-invalid');
                    luzInput.classList.remove('is-invalid');
                    nominaInput.classList.remove('is-invalid');
                    rentaInput.classList.remove('is-invalid');
                    internetInput.classList.remove('is-invalid');
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
                            formularioVacio.textContent = 'Por favor, ingrese los gastos fijos o al menos un comsumo de producto.';
                        }
                        return;
                    }
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
                calcular();
            });
        </script>

        <script>
            window.onload = function (){
                calcular();
            }
        </script>
        <script>
            function mostrarStock(){
                const select = document.getElementById('productos');
                var stock = select.options[select.selectedIndex].getAttribute('data-stock') || 0;
                var mostrar = document.getElementById('stock');

                mostrar.value = stock;

            }
        </script>

    </section>
@endsection



