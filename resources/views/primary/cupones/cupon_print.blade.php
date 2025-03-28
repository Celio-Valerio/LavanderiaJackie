@extends('layouts.print') {{-- Layout especial para impresión --}}
@section('content')

    <style>
        .print-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            border: 3px solid #007bff;
            border-radius: 15px;
            position: relative;
            background: white;
        }

        .logo {
            max-width: 200px;
            margin: 0 auto 20px;
            display: block;
        }

        .cupon-title {
            color: #007bff;
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .cupon-details {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .cupon-code {
            font-size: 32px;
            color: #28a745;
            text-align: center;
            margin: 25px 0;
            font-weight: bold;
        }

        .terms {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            margin-top: 30px;
        }

        @media print {
            body {
                margin: 0;
                padding: 20px;
                background: white !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="print-container">
        <img src="{{ asset('assets/img/logo.png') }}" class="logo" alt="Logo Lavandería">

        <h1 class="cupon-title">Cupón de Descuento</h1>

        <div class="cupon-code">
            CÓDIGO: {{ $cupon->codigo ?? $cupon->id }}
        </div>

        <div class="cupon-details">
            <table class="table table-borderless">
                <tr>
                    <th width="40%">Nombre:</th>
                    <td>{{ $cupon->nombre }}</td>
                </tr>
                <tr>
                    <th>Valor:</th>
                    <td>
                        @if($cupon->tipo == 'Descuento')
                            {{ $cupon->valor }}% de Descuento
                        @else
                            L. {{ number_format($cupon->valor, 2) }} de Crédito
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Válido hasta:</th>
                    <td>{{ \Carbon\Carbon::parse($cupon->fecha_hasta)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Cliente:</th>
                    <td>{{ $cliente->first_name ?? 'Portador' }} {{ $cliente->last_name ?? '' }}</td>
                </tr>
            </table>
        </div>

        <div class="terms">
            * Presentar este cupón al momento del pago<br>
            * No acumulable con otras promociones<br>
            * Válido
        </div>
    </div>

@endsection
