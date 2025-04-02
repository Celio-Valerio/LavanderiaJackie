@extends('layouts.print') {{-- Layout especial para impresión --}}
@section('content')

    <style>
        .print-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #007bff;
            background: white;
            font-family: Helvetica, Arial, sans-serif;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .print-container {
                width: 100%;
            }
        }

        .header-section {
            width: 100%;
            border-bottom: 2px solid #007bff;
            margin-bottom: 15px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .logo {
            width: 80px;
        }

        .company-info {
            text-align: right;
            font-size: 12px;
            line-height: 1.4;
        }

        .cupon-title {
            color: #007bff;
            text-align: center;
            font-size: 24px;
            text-transform: uppercase;
            margin: 15px 0;
        }

        .cupon-code {
            font-size: 32px;
            color: #28a745;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }

        .cupon-details {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 14px;
        }

        .terms {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }
    </style>

    <div class="print-container">
        <div class="header-section">
            <table class="header-table">
                <tr>
                    <td style="width: 80px;">
                        <img src="{{ asset('assets/img/logo.png') }}" class="logo" alt="Logo Lavandería">
                    </td>
                    <td class="company-info">
                        <strong style="font-size: 16px;">Lavandería Jackie</strong><br>
                        Factura de Venta de Servicios<br>
                        Prop. Matilde Jackeline Moncada Zelaya<br>
                        Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.<br>
                        R.T.N.: 07031985048849 &nbsp; | &nbsp; Cel: 9608-5567<br>
                        Email: jacky.moncada25@gmail.com
                    </td>
                </tr>
            </table>
        </div>

        <h1 class="cupon-title">Cupón de Descuento</h1>

        <div class="cupon-code">
            CÓDIGO: {{ $cupon->codigo ?? $cupon->id }}
        </div>

        <div class="cupon-details">
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td>{{ $cupon->nombre }}</td>
                </tr>
                <tr>
                    <td><strong>Valor:</strong></td>
                    <td>
                        @if($cupon->tipo == 'Descuento')
                            {{ $cupon->valor }}% de Descuento
                        @else
                            L. {{ number_format($cupon->valor, 2) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Válido desde:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($cupon->fecha_desde)->translatedFormat('d \d\e F, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Válido hasta:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($cupon->fecha_hasta)->translatedFormat('d \d\e F, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Estado:</strong></td>
                    <td>{{ ucfirst(strtolower($cupon->estado)) }}</td>
                </tr>
                <tr>
                    <td><strong>Descripción:</strong></td>
                    <td>{{ ucfirst(strtolower($cupon->descripcion)) }}</td>
                </tr>
            </table>
        </div>

        <div class="terms">
            * Presentar este cupón al momento del pago<br>
            * No acumulable con otras promociones<br>
            * Uso único por cliente<br>
            * No válido después de la fecha de vencimiento
        </div>
    </div>

@endsection
