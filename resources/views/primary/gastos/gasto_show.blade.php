@extends('layouts.principal')
@section('title', 'Gasto')
@section('content')

<style>
    .transparent-table {
        background-color: rgba(255, 255, 255, 0);
        border: 1px solid rgba(0, 0, 0, 0.1); 
    }

    .transparent-table td, .transparent-table th {
        background-color: rgba(255, 255, 255, 0);
    }

</style>

    <section class="section" style="padding: 50px 0;">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg rounded-lg border-0" style="background-image: url('{{ asset('assets/img/laundry-background.jpg') }}'); background-size: cover; background-position: center center; border-radius: 15px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="card-body" style="background-color: rgba(255, 255, 255, 0.85); border-radius: 15px; transition: background-color 0.3s ease;">


                        <h1 class="card-title text-center" style="font-size: 35px !important;">Detalles de gastos</h1>
                        <hr>
                        <!-- Sección para mostrar gastos fijos -->
                        <h2 class="mb-3">Gastos Fijos</h2>


                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Descripción del gasto:</strong> {{ $gasto->descripcion }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><strong>Energía eléctrica:</strong> L.{{ number_format($gasto->energia ?? 0, 2) }}</label>
                                @if(is_null($gasto->energia) || $gasto->energia === 0)
                                    <small class="text-danger">No se ha registrado el gasto </small>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><strong>Agua:</strong> L.{{ number_format($gasto->agua, 2) }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Nomina:</strong> L.{{ number_format($gasto->nomina, 2) }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><strong>Renta:</strong> L.{{ number_format($gasto->renta, 2) }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><strong>Internet:</strong> L.{{ number_format($gasto->internet, 2) }}</label>
                            </div>
                        </div>

                        @php
                            $total = 0;
                            $produ = 0;
                        @endphp
                        <!-- Sección para mostrar detalles de compras -->
                        <h2 class="mb-3">Detalles de Compras</h2>
                        <ul>
                            <div class="table-responsive">
                                <table class="table table-hover transparent-table" style="font-size: 16px; ">
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
                                        @foreach($detallesCompras as $detalle)
                                            <tr>
                                                <td>{{$detalle->numFactura}}</td>
                                                <td>{{date('d-m-Y', strtotime($detalle->fecha))}}</td>
                                                <td>{{$detalle->producto}}</td>
                                                <td>{{number_format($detalle->cantidad, 0, '.', ',')}}</td>
                                                <td>L.{{number_format($detalle->precio, 2, '.', ',')}}</td>
                                                <td>{{$detalle->descuento}} %</td>
                                                <td>{{number_format($detalle->cantidad * $detalle->precio - ($detalle->descuento / 100 * ($detalle->cantidad * $detalle->precio)), 2, '.', ',')}}</td>
                                                @php
                                                    $produ++;
                                                    $total += $detalle->cantidad * $detalle->precio - ($detalle->descuento / 100 * ($detalle->cantidad * $detalle->precio));
                                                @endphp
                                            </tr>
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
                                        <td>L.{{ number_format(($gasto->energia ?? 0) + ($gasto->agua ?? 0) + ($gasto->nomina ?? 0) + ($gasto->renta ?? 0) + ($gasto->internet ?? 0), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right" colspan="6"><strong>Total de gastos del mes(fijos + compras):</strong></td>
                                        <td>L.{{ number_format(($gasto->energia ?? 0) + ($gasto->agua ?? 0) + ($gasto->nomina ?? 0) + ($gasto->renta ?? 0) + ($gasto->internet ?? 0) + ($total ?? 0), 2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Calcular y mostrar el total gastado -->

                            <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                            <div class="row mt-3">
                                <div class="col-md-6 small-text-field">
                                    <a href="{{ route('gastos.index') }}" class="btn btn-secondary w-100">Volver a la lista</a>
                                </div>
                                <div class="col-md-6 small-text-field">
                                    <a href="{{ route('gastos.edit', $gasto->id) }}" class="btn btn-warning w-100">Editar gasto</a>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
