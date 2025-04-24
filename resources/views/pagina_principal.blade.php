<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lavandería Jackie - Inicio</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        /* Variables y estilos globales (idénticos a los definidos) */
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
        body { background: var(--background); font-family: 'Roboto', sans-serif; color: var(--on-surface); }
        .container { max-width: 1440px; margin: 0 auto; padding: var(--spacing); }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: calc(var(--spacing) * 1.5); background: var(--surface); padding: calc(var(--spacing) * 1.5); border-radius: var(--border-radius); box-shadow: var(--shadow-1); }
        .header-title h1 { margin: 0; font-size: 1.75rem; font-weight: 700; color: var(--mdc-primary); }
        .header-title p { margin: 0.5rem 0 0; color: var(--on-surface-60); font-size: 0.95rem; }
        .btn-primary { background: linear-gradient(135deg, var(--mdc-primary) 0%, var(--mdc-secondary) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 0.75rem; font-weight: 500; transition: transform 0.2s, box-shadow 0.2s; border: none; cursor: pointer; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-2); }
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: var(--spacing); margin-bottom: calc(var(--spacing) * 1.5); }
        .metric-card { background: var(--surface); padding: var(--spacing); border-radius: var(--border-radius); box-shadow: var(--shadow-1); display: flex; align-items: center; gap: 1.5rem; transition: transform 0.2s; }
        .metric-card:hover { transform: translateY(-3px); }
        .metric-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; }
        .metric-content h3 { margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--on-surface); }
        .metric-content p { margin: 0.25rem 0 0; color: var(--on-surface-60); font-size: 0.9rem; }
        .dashboard-content { display: grid; grid-template-columns: 2fr 1fr; gap: var(--spacing); margin-bottom: var(--spacing); }
        .card { background: var(--surface); border-radius: var(--border-radius); box-shadow: var(--shadow-1); }
        .chart-card { padding: var(--spacing); }
        .chart-header h2 { margin: 0 0 1rem; font-size: 1.25rem; font-weight: 600; color: var(--on-surface); }
        .inventory-table { background: var(--surface); border-radius: var(--border-radius); box-shadow: var(--shadow-1); overflow: hidden; }
        .table-header { padding: var(--spacing); border-bottom: 1px solid var(--border); }
        .table-header h2 { margin: 0; font-size: 1.25rem; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: left; font-size: 0.9rem; }
        th { background: var(--background); color: var(--on-surface-60); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; }
        tr:nth-child(even) { background: var(--background); }
        .stock-indicator { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 500; font-size: 0.85rem; }
        .stock-low { background: #FFF3E0; color: #EF6C00; }
        .btn-icon { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid var(--border); background: transparent; cursor: pointer; transition: background 0.2s; }
        .btn-icon:hover { background: rgba(0, 0, 0, 0.05); }
        @media (max-width: 768px) { .dashboard-content { grid-template-columns: 1fr; } .metrics-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
@extends('layouts.principal')
@section('title', 'Lavandería Jackie - Inicio')
@section('content')

    @php use App\Models\Producto; @endphp

    <div class="container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-title">
                <h1>Panel de gestión</h1>
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
                    <p>Clientes registrados</p>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon" style="background: var(--mdc-success);">
                    <span class="material-icons-round">work</span>
                </div>
                <div class="metric-content">
                    <h3>{{ $empleadosActivos }}</h3>
                    <p>Empleados activos</p>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon" style="background: var(--mdc-secondary);">
                    <span class="material-icons-round">inventory</span>
                </div>
                <div class="metric-content">
                    <h3>{{ Producto::count() }}</h3>
                    <p>Total de productos</p>
                </div>
            </div>
        </div>

        <!-- Agrega: Bienvenida con logo -->
        <div>
            <!-- Tarjeta de Bienvenida Mejorada -->
            <div class="welcome-card">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="welcome-logo animate-pop">
                <div class="welcome-content">
                    <h2 class="welcome-title">
                        ¡Hola, <span class="user-name">{{ Auth::user()->name }}</span>!
                        <span class="material-icons-round wave-animation">waving_hand</span>
                    </h2>
                    <p class="welcome-text">
                        Gestiona tus pedidos y productos de Lavandería Jackie desde nuestro
                        <span class="highlight">centro de control integral</span>.
                        Aquí podrás:
                    </p>
                    <ul class="features-list">
                        <li><span class="material-icons-round">check_circle</span> Administrar inventario en tiempo real</li>
                        <li><span class="material-icons-round">check_circle</span> Seguir el progreso de los pedidos</li>
                        <li><span class="material-icons-round">check_circle</span> Generar reportes detallados</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Animaciones */
        @keyframes pop-in {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            20% { transform: rotate(-20deg); }
            40% { transform: rotate(15deg); }
            60% { transform: rotate(-10deg); }
            80% { transform: rotate(5deg); }
            100% { transform: rotate(0deg); }
        }

        /* Estilos para la tarjeta de bienvenida */
        .welcome-card {
            background: linear-gradient(135deg, rgba(42,92,130,0.05) 0%, rgba(90,177,187,0.05) 100%);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            display: flex;
            align-items: center;
            gap: 3rem;
            margin-bottom: var(--spacing);
            border: 2px solid var(--mdc-primary);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
            rgba(42,92,130,0.03) 0%,
            rgba(90,177,187,0.03) 50%,
            transparent 100%);
            z-index: 0;
        }

        .welcome-logo {
            height: 180px;
            width: auto;
            flex-shrink: 0;
            z-index: 1;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .animate-pop {
            animation: pop-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .welcome-content {
            z-index: 1;
            flex: 1;
        }

        .welcome-title {
            font-size: 2.2rem;
            color: var(--on-surface);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            color: var(--mdc-primary);
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .wave-animation {
            animation: wave 1.2s ease-in-out;
            transform-origin: 75% 80%;
        }

        .welcome-text {
            font-size: 1.1rem;
            color: var(--on-surface-60);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .highlight {
            color: var(--mdc-secondary);
            font-weight: 600;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 1rem;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            background: rgba(90,177,187,0.08);
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .features-list li:hover {
            transform: translateX(10px);
        }

        @media (max-width: 768px) {
            .welcome-card {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
            }

            .welcome-title {
                flex-direction: column;
                gap: 0.5rem;
                font-size: 1.8rem;
            }

            .features-list li {
                justify-content: center;
                text-align: left;
            }
        }
    </style>
@endsection
