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
                        Reporte de Servicios Efectuados<br>
                        Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.<br>
                        R.T.N.: 07031985048849 &nbsp; | &nbsp; Cel: 9608-5567<br>
                        Email: jacky.moncada25@gmail.com
                    </td>
                </tr>
            </table>
        </div>

        @php
            // Fija Carbon en español
            \Carbon\Carbon::setLocale('es');
        @endphp

            <!-- TÍTULO -->
        <div class="title text-center mb-4">
            <strong style="font-size: 22px; display: block;">Reporte de servicios efectuados</strong>

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

        <!-- TABLA -->
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($servicios as $index => $servicio)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $servicio->cliente->first_name }} {{ $servicio->cliente->last_name }}</td>
                    <td>{{ $servicio->servicio->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $servicio->estado }}</td>
                    <td>L. {{ number_format($servicio->total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-end">Total General:</td>
                <td>L. {{ number_format($servicios->sum('total'), 2) }}</td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
