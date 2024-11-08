<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la factura</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #e3f2fd);
            color: #444;
            padding: 20px;
        }

        /* Encabezado */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 24px;
            color: #00796b;
            font-weight: 700;
        }

        .contact-info {
            font-size: 13px;
            color: #666;
            text-align: right;
        }

        /* Tarjeta de Factura */
        .card-factura {
            border: none;
            padding: 25px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 20px;
            color: #00796b;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .info-box {
            background: #f3f8fb;
            padding: 18px;
            border-radius: 8px;
            color: #333;
            margin-bottom: 12px;
        }

        /* Tabla de Detalles */
        .table th {
            background-color: #00796b;
            color: #ffffff;
            font-weight: 600;
            border-top: none;
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 14px;
            border-top: 1px solid #ddd;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #eaf4f7;
        }

        /* Estilo de Moneda */
        .currency {
            font-family: monospace;
            display: inline-block;
            min-width: 120px;
            text-align: right;
            color: #00796b;
        }

        /* Botones */
        .btn-custom {
            border-radius: 30px;
            font-weight: bold;
            padding: 10px 20px;
            transition: all 0.2s ease;
        }

        .btn-primary-custom {
            background-color: #00796b;
            color: #fff;
        }

        .btn-primary-custom:hover {
            background-color: #004d40;
        }

        .btn-secondary-custom {
            background-color: #6c757d;
            color: #fff;
        }

        /* Redes Sociales */
        .social-icons {
            font-size: 18px;
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .social-icons a {
            color: #00796b;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #004d40;
        }

        /* Estilos de impresión */
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
