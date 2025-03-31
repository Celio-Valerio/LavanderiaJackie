@extends('layouts.print') {{-- Layout especial para impresión --}}
@section('content')

    <style>
        .print-container {
            max-width: 800px;
            margin: 0 auto; /* Asegura que el contenido esté centrado */
            padding: 20px;
            border: 3px solid #007bff;
            border-radius: 15px;
            background: white;
            font-family: Arial, sans-serif;
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
                width: 100%; /* Asegura que el contenido use todo el ancho de la página */
            }
        }

        /* Modificaciones del encabezado */
        .header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px; /* Reducido */
        }

        .logo {
            max-width: 80px; /* Logo más pequeño */
            margin-right: 15px; /* Espacio a la derecha del logo */
        }

        .company-info {
            text-align: right;
            font-size: 12px;
            line-height: 1.4;
            max-width: 60%; /* Limitar el ancho del texto */
        }

        .cupon-title {
            color: #007bff;
            text-align: center;
            font-size: 26px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .cupon-details {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 14px;
        }

        .cupon-code {
            font-size: 36px;
            color: #28a745;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }

        .terms {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }
    </style>

    <div class="print-container">
        <!-- ENCABEZADO -->
        <div class="header-section">
            <img src="{{ asset('assets/img/logo.png') }}" class="logo" alt="Logo Lavandería">
            <div class="company-info">
                <strong style="font-size: 16px;">Lavandería Jackie</strong><br>
                Factura de Venta de Servicios<br>
                Prop. Matilde Jackeline Moncada Zelaya<br>
                Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.<br>
                R.T.N.: 07031985048849 &nbsp; | &nbsp; Cel: 9608-5567<br>
                Email: jacky.moncada25@gmail.com
            </div>
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

                <!-- Lista de clientes asignados -->
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                            </tr>
                            </thead>
                            <tbody>
                            <br>
                            <th>Clientes asignados:</th>
                            @forelse($cupon->clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->first_name }} {{ $cliente->last_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No hay clientes asignados</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

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
