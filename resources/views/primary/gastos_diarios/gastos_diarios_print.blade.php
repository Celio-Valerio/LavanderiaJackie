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
            font-size: 12px; /* Fuente más compacta */
        }

        .header-section {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-section img {
            max-width: 100px; /* Ajuste de tamaño del logo */
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
            table-layout: fixed; /* Hace que las columnas sean más compactas */
        }

        .detail-table th, .detail-table td {
            border: 1px solid #ddd;
            padding: 6px; /* Compacta las celdas */
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
                        Factura de Venta de Servicios<br>
                        Prop. Matilde Jackeline Moncada Zelaya<br>
                        Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.<br>
                        R.T.N.: 07031985048849 &nbsp; | &nbsp; Cel: 9608-5567<br>
                        Email: jacky.moncada25@gmail.com
                    </td>
                </tr>
            </table>
        </div>

        <!-- INFORMACIÓN DEL REPORTE -->
        <div class="title-section">
            <h1>Reporte de Gastos Diarios</h1>
            <p class="text-muted">N° {{ $gastoDiario->id }}</p>
        </div>

        <div class="client-info">
            <table class="detail-table">
                <tr>
                    <th>Fecha del Gasto</th>
                    <td>{{ \Carbon\Carbon::parse($gastoDiario->fecha)->translatedFormat('j \d\e F, Y') }}</td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td>
                        {{ optional($gastoDiario->servicioEfectuado)->cliente->first_name ?? 'N/A' }}
                        {{ optional($gastoDiario->servicioEfectuado)->cliente->last_name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>Servicio</th>
                    <td>{{ optional($gastoDiario->servicioEfectuado)->servicio->nombre ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <h4>Productos Utilizados</h4>

        @php
            $totalProductos = $gastoDiario->detalleGastoDiarios->count();
        @endphp

        <table class="detail-table">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Unidad</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gastoDiario->detalleGastoDiarios as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Producto no encontrado' }}</td>
                    <td>{{ number_format($detalle->cantidad, 2) }}</td>
                    <td>{{ $detalle->unidad_medida }}</td>
                </tr>
                @if($loop->index % 10 == 9 && !$loop->last)
                    <tr class="page-break"></tr>
                @endif
            @endforeach
            </tbody>
        </table>

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
