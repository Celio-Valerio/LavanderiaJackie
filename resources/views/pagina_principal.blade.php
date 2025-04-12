@extends('layouts.principal')
@section('title', 'Lavandería Jackie - Inicio')
@section('content')
    @php
        use App\Models\Producto;
    @endphp

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        :root {
            --mdc-primary:    #2A5C82;
            --mdc-secondary:  #5AB1BB;
            --mdc-success:    #4CAF50;
            --mdc-warning:    #FFC107;
            --mdc-error:      #D32F2F;
            --surface:       #FFFFFF;
            --background:    #F9FBFD;
            --on-surface:     #263238;
            --on-surface-60:  #607D8B;
            --border:         #E0E0E0;
            --border-radius:  12px;
            --spacing:        24px;
            --shadow-1:       0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-2:       0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background: var(--background);
            font-family: 'Roboto', sans-serif;
            color: var(--on-surface);
        }

        .container {
            max-width: 1440px;
            margin: 0 auto;
            padding: var(--spacing);
        }

        /* Header Section */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: calc(var(--spacing) * 1.5);
            background: var(--surface);
            padding: calc(var(--spacing) * 1.5);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-1);
        }

        .header-title h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--mdc-primary);
        }

        .header-title p {
            margin: 0.5rem 0 0;
            color: var(--on-surface-60);
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--mdc-primary) 0%, var(--mdc-secondary) 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-2);
        }

        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: var(--spacing);
            margin-bottom: calc(var(--spacing) * 1.5);
        }

        .metric-card {
            background: var(--surface);
            padding: var(--spacing);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: transform 0.2s;
        }

        .metric-card:hover {
            transform: translateY(-3px);
        }

        .metric-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .metric-content h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--on-surface);
        }

        .metric-content p {
            margin: 0.25rem 0 0;
            color: var(--on-surface-60);
            font-size: 0.9rem;
        }

        /* Main Content Layout */
        .dashboard-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: var(--spacing);
            margin-bottom: var(--spacing);
        }

        /* Chart Section */
        .chart-card {
            background: var(--surface);
            border-radius: var(--border-radius);
            padding: var(--spacing);
            box-shadow: var(--shadow-1);
        }

        .chart-header {
            margin-bottom: 1.5rem;
        }

        .chart-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--on-surface);
        }

        /* Recent Purchases */
        .recent-purchases {
            background: var(--surface);
            border-radius: var(--border-radius);
            padding: var(--spacing);
            box-shadow: var(--shadow-1);
        }

        .purchase-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        .purchase-item:last-child {
            border-bottom: none;
        }

        .purchase-info h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .purchase-info small {
            color: var(--on-surface-60);
            font-size: 0.85rem;
        }

        .purchase-amount {
            background: var(--mdc-success);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Inventory Table */
        .inventory-table {
            background: var(--surface);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-1);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing);
            border-bottom: 1px solid var(--border);
        }

        .table-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            font-size: 0.9rem;
        }

        th {
            background: var(--background);
            color: var(--on-surface-60);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        tr:nth-child(even) {
            background: var(--background);
        }

        .stock-indicator {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .stock-low {
            background: #FFF3E0;
            color: #EF6C00;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-icon:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .dashboard-content {
                grid-template-columns: 1fr;
            }

            .metrics-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-title">
                <h1>Panel de Gestión</h1>
                <p>Bienvenido al sistema de Lavandería Jackie</p>
            </div>
            <a class="btn-primary" href="{{ route('compras.create') }}">
                <span class="material-icons-round">add</span>
                Comprar productos
            </a>
        </header>

        <!-- Key Metrics -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-icon" style="background: var(--mdc-primary);">
                    <span class="material-icons-round">group</span>
                </div>
                <div class="metric-content">
                    <h3>{{ $totalClientes }}</h3>
                    <p>Clientes Registrados</p>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon" style="background: var(--mdc-success);">
                    <span class="material-icons-round">work</span>
                </div>
                <div class="metric-content">
                    <h3>{{ $empleadosActivos }}</h3>
                    <p>Empleados Activos</p>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon" style="background: var(--mdc-secondary);">
                    <span class="material-icons-round">inventory</span>
                </div>
                <div class="metric-content">
                    <h3>{{ Producto::count() }}</h3>
                    <p>Total Productos</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-content">
            <!-- Gráfico de Stock -->
            <div class="chart-card">
                <div class="chart-header">
                    <h2>Productos con Mayor Stock</h2>
                </div>
                <div id="stockChart" style="height: 320px;"></div>
            </div>

            <!-- Últimas Compras -->
            <div class="recent-purchases">
                <div class="chart-header">
                    <h2>Últimas Transacciones</h2>
                </div>
                <div class="purchase-list">
                    @foreach ($ultimasCompras as $compra)
                        <div class="purchase-item">
                            <div class="purchase-info">
                                <h6  style="font-size: 9px">Factura #{{ $compra->numero_factura }}</h6>
                                <small  style="font-size: 5px">{{ \Carbon\Carbon::parse($compra->fecha_compra)->isoFormat('D MMM YYYY') }}</small>
                            </div>
                            <span class="purchase-amount" style="font-size: 8px">
                                L. {{ number_format($compra->detalle_compras->sum('precio'), 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tabla de Inventario -->
        <div class="inventory-table">
            <div class="table-header">
                <h2>Productos con Stock Bajo</h2>
                <a class="btn-icon" href="{{ route('productos.index') }}">
                    <span class="material-icons-round">manage_history</span>
                    Gestionar
                </a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock Actual</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Producto::where('stock','<',10)->get() as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>

                            <td>
                                    <span class="stock-indicator stock-low">
                                        {{ $producto->stock }} unidades
                                    </span>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script del Gráfico -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#stockChart"), {
                series: [{
                    name: 'Stock',
                    data: @json($topProductos->pluck('stock'))
                }],
                chart: {
                    type: 'bar',
                    height: '100%',
                    toolbar: { show: false },
                    fontFamily: 'Roboto'
                },
                colors: ['#2A5C82'],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '45%',
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: @json($topProductos->pluck('nombre')),
                    labels: { style: { fontSize: '13px' } }
                },
                yaxis: { labels: { style: { fontSize: '13px' } } },
                grid: { borderColor: '#ECEFF1' },
                tooltip: {
                    y: {
                        formatter: (val) => `${val} unidades`,
                        title: { formatter: () => 'Stock' }
                    }
                }
            }).render();
        });
    </script>
@endsection
