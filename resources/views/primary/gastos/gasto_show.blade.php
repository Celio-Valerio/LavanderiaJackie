@extends('layouts.principal')
@section('title', 'Gasto')
@section('content')

<style>
    .transparent-table {
        background-color: rgba(255, 255, 255, 0);
        border: 1px solid rgba(0, 0, 0, 0.1); /* Agregar un borde sutil si lo necesitas */
    }

    .transparent-table td, .transparent-table th {
        background-color: rgba(255, 255, 255, 0);
    }

</style>

    <section class="section" style="padding: 50px 0;">
        @if($usuario->rolpermiso->gastos_ver == 1)
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
                                    <label class="form-label" style="white-space: nowrap;"><strong>Fecha de registro:</strong>{{ \Carbon\Carbon::parse($gasto->fecha)->translatedFormat('l d \d\e F, Y') }}</label>
                                </div>
                            </div>


                            <ul>
                                <div class="table-responsive">
                                    <table class="table table-hover transparent-table" style="font-size: 16px; ">
                                        <thead>
                                        <th class="color">Gasto fijos</th>
                                        <th class="color">Monto</th>
                                        </thead>
                                        <tbody>
                                        @if($gasto->totalG > 0)
                                            @if($gasto->energia > 0)
                                                <tr>
                                                    <td>Energía eléctrica</td>
                                                    <td>L. {{ number_format($gasto->energia ?? 0, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if($gasto->agua > 0)
                                                <tr>
                                                    <td>Agua</td>
                                                    <td>L. {{ number_format($gasto->agua ?? 0, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if($gasto->renta > 0)
                                                <tr>
                                                    <td>Renta</td>
                                                    <td>L. {{ number_format($gasto->renta ?? 0, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if($gasto->nomina > 0)
                                                <tr>
                                                    <td>Nómina</td>
                                                    <td>L. {{ number_format($gasto->nomina ?? 0, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if($gasto->internet > 0)
                                                <tr>
                                                    <td>Internet</td>
                                                    <td>L. {{ number_format($gasto->internet ?? 0, 2) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td style="text-align: end"><strong>Total gastos fijos</strong></td>
                                                <td>L. {{ number_format($gasto->totalG ?? 0, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2" style="text-align: center; color: grey;">No hay registros de gastos fijos.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </ul>
                            <!-- Sección para mostrar detalles de compras -->
                            <h2 class="mb-3">Detalles de consumos</h2>
                            <ul>
                                <div class="table-responsive">
                                    <table class="table table-hover transparent-table" style="font-size: 16px; ">
                                        <thead>
                                        <th class="color">Producto</th>
                                        <th class="color">Cantidad</th>
                                        <th class="color">Precio</th>
                                        <th class="color">Total</th>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @if(!$detallesGastos->isEmpty())
                                            @foreach($detallesGastos as $detalle)
                                                @php
                                                    $total = $total + ($detalle->cantidad * $detalle->producto->precio);
                                                @endphp
                                                <tr>
                                                    <td>{{$detalle->producto->nombre}}</td>
                                                    <td>{{$detalle->cantidad}}</td>
                                                    <td>L. {{ number_format($detalle->producto->precio ?? 0, 2) }}</td>
                                                    <td>L. {{ number_format($detalle->cantidad * $detalle->producto->precio ?? 0, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" style="text-align: end;"><strong>Total de gastos por consumo:</strong></td>
                                                <td>L. {{ number_format($total ?? 0, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: end;"><strong>Total(Gastos fijos + Gastos por consumo):</strong></td>
                                                <td>L. {{ number_format($total + $gasto->totalG ?? 0, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="4" style="text-align: center; color: grey;">No hay registros de consumos.</td>
                                            </tr>
                                        @endif
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
    </section>
@endsection
