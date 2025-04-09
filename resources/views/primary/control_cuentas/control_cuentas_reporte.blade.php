@extends('layouts.print')

@section('content')
    <style>
        .invoice-container {
            max-width: 100%;
            margin: 10px auto;
            padding: 20px;
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }

        .header-section {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-section img {
            max-width: 100px;
            display: block;
            margin: 0 auto;
        }

        .company-info {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .total-row {
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }
    </style>

    <div class="invoice-container">
        <!-- ENCABEZADO -->
        <div class="header-section">
            <table style="width: 100%; border-bottom: 2px solid #333; margin-bottom: 10px;">
                <tr>
                    <td style="width: 80px; text-align: left;">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Lavandería" style="max-width: 70px;">
                    </td>
                    <td style="text-align: center; font-size: 12px; line-height: 1.3;">
                        <strong style="font-size: 18px;">Lavandería Jackie</strong><br>
                        Reporte de Control de Cuentas<br>
                        Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.<br>
                        R.T.N.: 07031985048849 &nbsp; | &nbsp; Cel: 9608-5567<br>
                        Email: jacky.moncada25@gmail.com
                    </td>
                </tr>
            </table>
        </div>

        @php
            \Carbon\Carbon::setLocale('es');
        @endphp

            <!-- TÍTULO -->
        <div class="title text-center mb-4">
            <strong style="font-size: 22px; display: block;">Reporte de Control de Cuentas</strong>
            <div class="text-center mb-3" style="font-size: 14px;">
                @if(!empty($fechaDesde) && !empty($fechaHasta))
                    <div>
                        <strong>Generado desde</strong>
                        {{ \Carbon\Carbon::parse($fechaDesde)->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
                        <strong>hasta</strong>
                        {{ \Carbon\Carbon::parse($fechaHasta)->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
                    </div>
                @else
                    <div>
                        <strong>Generado el</strong>
                        {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
                    </div>
                @endif

                @if(!empty($searchTerm))
                    <div class="mt-2">
                        Búsqueda realizada utilizando todos los filtros para <strong>"{{ $searchTerm }}"</strong>
                    </div>
                @elseif(empty($fechaDesde) && empty($fechaHasta))
                    <div class="mt-2">
                        <em>Reporte sin filtros aplicados</em>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabla de Control de Cuentas -->
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th class="text-end">Depositos</th>
                <th class="text-end">Retiros</th>
                <th class="text-end">Saldo Inicial</th>
                <th class="text-end">Saldo Neto</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transacciones as $i => $transaccion)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $transaccion->notas }}</td>
                    <td class="text-end">L. {{ number_format($transaccion->transaccion == 'Deposito' ? $transaccion->monto : 0, 2, '.', ',') }}</td>
                    <td class="text-end">L. {{ number_format($transaccion->transaccion == 'Retiro' ? $transaccion->monto : 0, 2, '.', ',') }}</td>
                    <td class="text-end">L. {{ number_format($transaccion->transaccion == 'Saldo inicial' ? $transaccion->monto : 0, 2, '.', ',') }}</td>
                    <td class="text-end">
                        L. {{ number_format($transaccion->transaccion == 'Saldo inicial' ? $transaccion->monto : 0
                                + ($transaccion->transaccion == 'Deposito' ? $transaccion->monto : 0)
                                - ($transaccion->transaccion == 'Retiro' ? $transaccion->monto : 0), 2, '.', ',') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-end">Totales:</td>
                <td class="text-end">L. {{ number_format($totalDepositos, 2, '.', ',') }}</td>
                <td class="text-end">L. {{ number_format($totalRetiros, 2, '.', ',') }}</td>
                <td class="text-end">L. {{ number_format($totalSaldoInicial, 2, '.', ',') }}</td>
                <td class="text-end">
                    L. {{ number_format($neto, 2, '.', ',') }}
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
