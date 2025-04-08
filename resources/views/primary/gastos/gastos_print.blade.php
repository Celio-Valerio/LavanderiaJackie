@extends('layouts.print')

@section('content')

    <style>
        .invoice-container {
            max-width: 100%;
            margin: 10px auto;
            padding: 20px;
            border: 2px solid #333;
            background: #fff;
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

        .title-section {
            text-align: center;
            margin: 20px 0;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            table-layout: fixed;
        }

        .detail-table th, .detail-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 11px;
        }

        .detail-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #333;
            text-align: center;
            font-size: 12px;
        }

        .footer-note {
            font-size: 10px;
            color: #666;
            margin-top: 15px;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .invoice-container {
                border: none;
                padding: 0;
                font-size: 11px;
            }

            .detail-table tbody tr {
                page-break-inside: avoid;
            }

            .page-break {
                display: none;
            }
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
                        <strong style="font-size: 14px;">Lavandería Jackie</strong><br>
                        Reporte de Gastos<br>
                        Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.<br>
                        R.T.N.: 07031985048849 &nbsp; | &nbsp; Cel: 9608-5567<br>
                        Email: jacky.moncada25@gmail.com
                    </td>
                </tr>
            </table>
        </div>

        <!-- INFORMACIÓN DEL REPORTE -->
        <div class="title-section">
            <h1>Reporte de Gastos</h1>
            <p class="text-muted">Fecha: {{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</p>
            <p class="text-muted">Descripción: {{ $gasto->descripcion }}</p>
        </div>

        <!-- GASTOS FIJOS -->
        @if($gasto->totalG > 0)
            <h4>Gastos Fijos</h4>
            <table class="detail-table">
                <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                </tr>
                </thead>
                <tbody>
                @foreach(['energia', 'agua', 'renta', 'nomina', 'internet'] as $tipo)
                    @if($gasto->$tipo > 0)
                        <tr>
                            <td>{{ ucfirst($tipo) }}</td>
                            <td>L. {{ number_format($gasto->$tipo, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr class="total-row">
                    <td>Total Gastos Fijos</td>
                    <td>L. {{ number_format($gasto->totalG, 2) }}</td>
                </tr>
                </tbody>
            </table>
        @endif

        <!-- PRODUCTOS UTILIZADOS -->
        @if(!$detallesGastos->isEmpty())
            <h4>Productos Utilizados</h4>
            <table class="detail-table">
                <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @php $totalConsumos = 0; @endphp
                @foreach($detallesGastos as $detalle)
                    @php
                        $subtotal = $detalle->cantidad * $detalle->producto->precio;
                        $totalConsumos += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>L. {{ number_format($detalle->producto->precio, 2) }}</td>
                        <td>L. {{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total Consumos</td>
                    <td>L. {{ number_format($totalConsumos, 2) }}</td>
                </tr>
                @if($gasto->totalG > 0)
                    <tr class="total-row">
                        <td colspan="3">Total General</td>
                        <td>L. {{ number_format($totalConsumos + $gasto->totalG, 2) }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        @endif

        <!-- FIRMA -->
        <div class="signature-section">
            <p>_________________________<br>
                Responsable de Operaciones</p>
            <p>_________________________<br>
                Recibido por</p>
        </div>

        <div class="footer-note">
            * Este documento es un registro oficial de la empresa<br>
            * Cualquier alteración invalida su autenticidad
        </div>

    </div>

@endsection
