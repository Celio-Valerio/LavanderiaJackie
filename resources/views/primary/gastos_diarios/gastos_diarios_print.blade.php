@extends('layouts.print')
@section('content')

    <style>
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 2px solid #333;
            background: #fff;
            font-family: 'Arial', sans-serif;
        }

        .header-section {
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info {
            text-align: right;
            margin-bottom: 20px;
        }

        .title-section {
            text-align: center;
            margin: 30px 0;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        .detail-table th,
        .detail-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .detail-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #333;
        }

        .footer-note {
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .invoice-container {
                border: none;
                padding: 0;
            }
        }
    </style>

    <div class="invoice-container">
        <div class="header-section">
            <div class="company-info">
                <h2>Lavandería Jackie</h2>
                <p>Tel: +504 ####-####<br>
                    Email: info@lavanderiajackie.com<br>
                    Dirección: Danlí, Honduras</p>
            </div>
        </div>

        <div class="title-section">
            <h1>Reporte de Gastos Diarios</h1>
            <p class="text-muted">N° {{ $gastoDiario->id }}</p>
        </div>

        <div class="client-info">
            <table class="detail-table">
                <tr>
                    <th>Fecha</th>
                    <td>{{ \Carbon\Carbon::parse($gastoDiario->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <h4>Productos Utilizados</h4>
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
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->unidad_medida }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="signature-section">
            <div class="row">
                <div class="col-6">
                    <p>_________________________<br>
                        Responsable de Operaciones</p>
                </div>
                <div class="col-6 text-right">
                    <p>_________________________<br>
                        Recibido por</p>
                </div>
            </div>
        </div>

        <div class="footer-note">
            * Este documento es un registro oficial de la empresa<br>
            * Cualquier alteración invalida su autenticidad
        </div>
    </div>

@endsection
