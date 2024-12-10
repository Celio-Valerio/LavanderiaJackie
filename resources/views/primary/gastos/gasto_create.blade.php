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
                        <form id="gastoForm" action="{{ isset($gasto) ? route('gastos.update', $gasto->id) : route('gastos.store') }}" method="POST" novalidate>
                            @csrf
                            @if(isset($gasto))
                                @method('put')
                            @endif
                            @if($compras->isEmpty())
                                <div class="alert alert-warning" role="alert">
                                    No se encontraron resultados para esta ventana.
                                </div>
                            @else
                                @php
                                    $fechaAc = date('Y-m-d');
                                    $primerDiaMes = date('Y-m-01');
                                    $ultimoDiaMes = date('Y-m-t');
                                    $total = 0;
                                    $suma = 0;
                                    $produ = 0;
                                @endphp
                                <!-- Gastos fijos -->
                                <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Gastos fijos</strong></h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblDescripcion">Descripción:</label>
                                            <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" maxlength="100" value="{{isset($gasto) ? $gasto->descripcion : old('descripcion')}}">
                                            @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblLuz">Energía eléctrica:</label>
                                            <input type="text" name="luz" id="luz" class="form-control @error('luz') is-invalid @enderror" maxlength="6" value="{{isset($gasto) ? $gasto->energia : old('luz')}}" oninput="validarSoloNumeros(this); calcular(this)">
                                            @error('luz')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblAgua">Agua:</label>
                                            <input type="text" name="agua" id="agua" class="form-control @error('agua') is-invalid @enderror" maxlength="6" value="{{isset($gasto) ? $gasto->agua : old('agua')}}" oninput="validarSoloNumeros(this); calcular(this)">
                                            @error('agua')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblRenta">Renta:</label>
                                            <input type="text" name="renta" id="renta" class="form-control @error('renta') is-invalid @enderror" maxlength="6" value="{{isset($gasto) ? $gasto->renta : old('renta')}}" oninput="validarSoloNumeros(this); calcular(this)">
                                            @error('renta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblNomina">Nómina:</label>
                                            <input type="text" name="nomina" id="nomina" class="form-control @error('nomina') is-invalid @enderror" maxlength="6" value="{{isset($gasto) ? $gasto->nomina : old('nomina')}}" oninput="validarSoloNumeros(this); calcular(this)">
                                            @error('nomina')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lblInternet">Internet:</label>
                                            <input type="text" name="internet" id="internet" class="form-control @error('internet') is-invalid @enderror" maxlength="6" value="{{isset($gasto) ? $gasto->internet : old('internet')}}" oninput="validarSoloNumeros(this); calcular(this)">
                                            @error('internet')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-top: 40px">
                                        <!-- Gastos por compras -->
                                        <h2 class="card-subtitle text-center mb-3" style="font-size: 22px;"><strong>Gastos por compras</strong></h2>
                                        <div class="table-responsive">
                                            <table class="table table-hover" style="font-size: 16px;">
                                                <thead>
                                                    <th class="color">N° Factura</th>
                                                    <th class="color">Fecha compra</th>
                                                    <th class="color">Producto</th>
                                                    <th class="color">Cantidad</th>
                                                    <th class="color">Precio</th>
                                                    <th class="color">Descuento</th>
                                                    <th class="color">Total</th>
                                                </thead>
                                                <tbody>
                                                @foreach($compras as $compra)
                                                    @if($compra->fecha_compra >= $fechaAc && $compra->fecha_compra <= $ultimoDiaMes)
                                                        @php
                                                            $suma++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @foreach($compras as $compra)
                                                    @if($compra->fecha_compra >= $fechaAc && $compra->fecha_compra <= $ultimoDiaMes)
                                                    @foreach($compra->detalles as $detalle)
                                                        <tr>
                                                            <td>{{$detalle->compra->numero_factura}}</td>
                                                            <td>{{date('d-m-Y', strtotime($detalle->compra->fecha_compra))}}</td>
                                                            <td>{{$detalle->producto->nombre}}</td>
                                                            <td>{{number_format($detalle->cantidad, 0, '.', ',')}}</td>
                                                            <td>L.{{number_format($detalle->precio, 2, '.', ',')}}</td>
                                                            <td>{{$detalle->descuento}} %</td>
                                                            <td>{{number_format($detalle->cantidad * $detalle->precio - ($detalle->descuento / 100 * ($detalle->cantidad * $detalle->precio)), 2, '.', ',')}}</td>
                                                            @php
                                                                $total += $detalle->cantidad * $detalle->precio - ($detalle->descuento / 100 * ($detalle->cantidad * $detalle->precio));
                                                            @endphp
                                                        </tr>
                                                        @php
                                                        $produ++;
                                                            $detalles[] = ['numero' => $detalle->compra->numero_factura, 'fecha' => $detalle->compra->fecha_compra, 'producto' => $detalle->producto->nombre, 'cantidad' => $detalle->cantidad, 'precio' => $detalle->precio, 'descuento' => $detalle->descuento];
                                                        @endphp
                                                    @endforeach
                                                    @endif
                                                @endforeach
                                                @if($produ < 1)
                                                    <td colspan="7" style="text-align: center; color: grey;">No hay gastos por compra de productos.</td>
                                                @endif
                                                <tr>
                                                    <td style="text-align: right" colspan="6"><strong>Total de gastos por compras:</strong></td>
                                                    <td>L.{{number_format($total, 2, '.', ',')}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right" colspan="6"><strong>Total de gastos fijos:</strong></td>
                                                    <td><span id="totalFijos"></span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right" colspan="6"><strong>Total de gastos del mes(fijos + compras):</strong></td>
                                                    <td><span id="totalTotal"></span></td>
                                                </tr>
                                                @if($suma > 0)
                                                    @php
                                                        $detallesMandar = json_encode($detalles);
                                                    @endphp
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                <div>
                                    <input type="hidden" name="tot" id="tot" value="{{$total}}">
                                    <input type="hidden" name="total" id="total">
                                    <input type="hidden" name="suma" id="suma" value="{{$suma}}">
                                    @if($suma > 0)
                                        <input type="hidden" name="detalles" id="detalles" value="{{$detallesMandar}}">
                                    @endif
                                </div>
                            @endif

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success flex-fill me-1">{{isset($gasto) ? 'Actualizar' : 'Registrar'}}</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                @if(isset($gasto))
                                    <button type="button" class="btn btn-primary flex-fill me-1" id="reloadButton">Reestablecer</button>
                                @endif
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
                        .replace(/[^0-9.]/g, "") // Permite solo números y un punto decimal
                        .replace(/(\..*)\./g, "$1") // Evita múltiples puntos decimales
                        .replace(/^0+(?=\d)/, "0") // Permite un solo 0 al inicio, seguido de más números
                        .replace(/^0+(?!\.|$)/g, "") // Elimina ceros iniciales si no hay un punto o es solo un 0
                        .replace(/^(\.)/, ""); // Elimina el punto si está al principio
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
                var tot = parseFloat(document.getElementById('tot').value) || 0;
                var total = document.getElementById('total');

                var totalFijos = luz + agua + renta + nomina + internet;
                var totalFinal = totalFijos + tot;

                document.getElementById('totalFijos').textContent = totalFijos.toLocaleString('es-HN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                document.getElementById('totalTotal').textContent = totalFinal.toLocaleString('es-HN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                total.value = totalFinal;
            }
        </script>
        <script>
            document.getElementById('clearButton').addEventListener('click', function () {
                document.getElementById('descripcion').value = '';
                document.getElementById('luz').value = '';
                document.getElementById('agua').value = '';
                document.getElementById('renta').value = '';
                document.getElementById('nomina').value = '';
                document.getElementById('internet').value = '';

                
                const errorMessages = document.querySelectorAll('.invalid-feedback');
                errorMessages.forEach(function (msg) {
                    msg.remove();
                });

                document.getElementById('descripcion').classList.remove('is-invalid');
                document.getElementById('luz').classList.remove('is-invalid');
                document.getElementById('agua').classList.remove('is-invalid');
                document.getElementById('renta').classList.remove('is-invalid');
                document.getElementById('nomina').classList.remove('is-invalid');
                document.getElementById('internet').classList.remove('is-invalid');
                calcular();
            });
        </script>

        <script>
            window.onload = function (){
                calcular();
            }
        </script>

        <script>
            
            const initialValues = {
                descripcion: "{{ isset($gasto) ? $gasto->descripcion : '' }}",
                luz: "{{ isset($gasto) ? $gasto->energia : '' }}",
                agua: "{{ isset($gasto) ? $gasto->agua : '' }}",
                renta: "{{ isset($gasto) ? $gasto->renta : '' }}",
                nomina: "{{ isset($gasto) ? $gasto->nomina : '' }}",
                internet: "{{ isset($gasto) ? $gasto->internet : '' }}"
            };

            document.getElementById('reloadButton').addEventListener('click', function () {
                
                document.getElementById('descripcion').value = initialValues.descripcion;
                document.getElementById('luz').value = initialValues.luz;
                document.getElementById('agua').value = initialValues.agua;
                document.getElementById('renta').value = initialValues.renta;
                document.getElementById('nomina').value = initialValues.nomina;
                document.getElementById('internet').value = initialValues.internet;

                
                const errorMessages = document.querySelectorAll('.invalid-feedback');
                errorMessages.forEach(function (msg) {
                    msg.remove();
                });

                document.getElementById('descripcion').classList.remove('is-invalid');
                document.getElementById('luz').classList.remove('is-invalid');
                document.getElementById('agua').classList.remove('is-invalid');
                document.getElementById('renta').classList.remove('is-invalid');
                document.getElementById('nomina').classList.remove('is-invalid');
                document.getElementById('internet').classList.remove('is-invalid');
                calcular();
            });
        </script>

    </section>
@endsection



