<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Minimalista</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #424242;
            margin: 0;
            padding: 20px;
        }

        /* Encabezado */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            color: #009688;
            font-weight: 700;
            margin: 0;
        }

        .contact-info {
            font-size: 12px;
            text-align: right;
            color: #757575;
        }

        /* Invoice Card */
        .card-factura {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #009688;
        }

        .section-title {
            font-size: 16px;
            color: #009688;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .info-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            color: #424242;
            margin-bottom: 10px;
        }

        /* Table Styling */
        .table th {
            background-color: #009688;
            color: white;
            font-weight: 500;
            border: none;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f4f4f4;
        }

        .table td, .table th {
            padding: 12px;
            vertical-align: middle;
        }

        /* Total Section */
        .total-section {
            text-align: right;
            font-size: 18px;
            font-weight: 500;
            color: #009688;
            margin-top: 20px;
        }

        /* Buttons */
        .btn-custom {
            border-radius: 20px;
            font-weight: bold;
            padding: 8px 16px;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary-custom {
            background-color: #009688;
        }

        .btn-secondary-custom {
            background-color: #757575;
        }

        .btn-custom:hover {
            opacity: 0.9;
        }

        /* Social Media */
        .social-icons {
            font-size: 18px;
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 15px;
            color: #757575;
        }

        .social-icons a:hover {
            color: #009688;
        }

        /* Print Styles */
        @media print {
            .header, .btn, .social-icons {
                display: none;
            }

            .card-factura {
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<section class="container py-3">
    <!-- Encabezado -->
    <div class="header">
        <div>
            <h1>Lavandería Jackie</h1>
            <p class="text-muted">Factura de compra</p>
        </div>
        <div class="contact-info">
            <p><i class="fas fa-map-marker-alt"></i> Danlí, El Paraíso.</p>
            <p><i class="fas fa-phone"></i> +504 9608-5567</p>
            <p><i class="fas fa-envelope"></i> lavanderiajackie@gmail.com</p>
        </div>
    </div>

    <!-- Factura -->
    <div class="card-factura">
        <!-- Información de la Factura -->
        <div class="section-title">Detalles de la factura</div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="info-box">
                    <strong>Número de factura:</strong>
                    <p>{{ $compra->numero_factura }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <strong>Fecha de compra:</strong>
                    <p>{{ ucfirst(\Carbon\Carbon::parse($compra->fecha_compra)->translatedFormat('l d \d\e F, Y')) }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <strong>Proveedor:</strong>
                    <p>{{ $compra->proveedor->full_name }}</p>
                </div>
            </div>
        </div>

        <!-- Descripción de la Compra -->
        <div class="section-title">Descripción</div>
        <div class="info-box mb-3">
            <p>{{ $compra->descripcion }}</p>
        </div>

        <!-- Tabla de Detalles -->
        <div class="section-title">Detalles de la compra</div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <th style="width: 45%;">Producto</th>
                    <th style="width: 10%;">Cantidad</th>
                    <th style="width: 15%;">Precio</th>
                    <th style="width: 15%;">Descuento</th>
                    <th style="width: 15%;">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($compra->detalles as $detalle)
                    <tr>
                        <td class="text-start">{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{!! formatCurrency($detalle->precio) !!}</td>
                        <td>{!! formatCurrency($detalle->descuento) !!}</td>
                        <td>{!! formatCurrency(($detalle->precio * $detalle->cantidad) - $detalle->descuento) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total de la Factura -->
        <div class="d-flex justify-content-end my-3">
            <h4>Total: {!! formatCurrency($compra->detalles->sum(function($detalle) {
                return ($detalle->precio * $detalle->cantidad) - $detalle->descuento;
            })) !!}</h4>
        </div>

        <!-- Botones -->
        <div class="row mb-2">
            <div class="col-md-4">
                <a href="{{ route('compras.index') }}" class="btn btn-secondary btn-custom w-100">
                    <i class="fas fa-arrow-left"></i> Volver a la Lista
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-primary-custom btn-custom w-100">
                    <i class="fas fa-edit"></i> Editar Factura
                </a>
            </div>
            <div class="col-md-4">
                <button onclick="window.print()" class="btn btn-secondary btn-custom w-100">
                    <i class="fas fa-print"></i> Imprimir Factura
                </button>
            </div>
        </div>

        <!-- Redes Sociales -->
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@php
    function formatCurrency($amount) {
        // Formatear la cantidad con el formato L. y con espacios para alinear
        $formattedAmount = number_format($amount, 2, '.', ',');
        $spaces = str_repeat('&nbsp;', 12 - strlen($formattedAmount));
        return "<span class='currency'>L.$spaces$formattedAmount</span>";
    }
@endphp
