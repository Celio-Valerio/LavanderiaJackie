<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Lavandería Jackie')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Estilos y scripts de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif; /* Cambia la fuente de todo el body */
        }

        .small-text-field {
            font-size: 14px; /* Ajusta el tamaño según tus preferencias */
        }

        #clientesTable {
            font-size: 0.9rem; /* Tamaño de fuente más pequeño */
        }

        #clientesTable th,
        #clientesTable td {
            padding: 0.5rem; /* Ajusta el padding según sea necesario */
        }
    </style>

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Updated: Apr 20 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="max-height: 50px; object-fit: contain; margin-right: 10px;">
            <span class="d-none d-lg-block">Lavandería Jackie</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- Imagen de perfil del usuario -->
                    @if(Auth::check() && Auth::user()->image)
                        <img src="{{ asset('assets/img/perfiles/' . Auth::user()->image) }}" alt="Profile" class="rounded-circle">
                    @else
                        <img src="{{ asset('img/default-user.png') }}" alt="Profile" class="rounded-circle">
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2">
            @if(Auth::check())
                            {{ Auth::user()->name }}
                        @else
                            Usuario No Autenticado
                        @endif
        </span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        @if(Auth::check())
                            <h6>{{ Auth::user()->name }}</h6>
                            <!-- Puedes agregar más información del usuario si lo deseas -->
                            <span>{{ Auth::user()->empleado ? Auth::user()->empleado->puesto->name : 'No asignado' }}</span>
                        @else
                            <h6>Usuario No Autenticado</h6>
                        @endif
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Enlace a la configuración de cuenta -->
                    @if(Auth::check())

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif


                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Cerrar sesión -->
                    @if(Auth::check())
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Cerrar Sesión</span>
                                </a>
                            </form>
                        </li>
                    @endif
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <!-- Menú Items -->
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="/">
                <i class="bi bi-grid"></i>
                <span>Inicio</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#operaciones-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Operaciones</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="operaciones-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('cuenta_bancos.index') }}">
                        <i class="bi bi-circle"></i><span>Cuentas de banco</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('control_cuentas.index') }}">
                        <i class="bi bi-circle"></i><span>Transacciones</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cupones.index') }}">
                        <i class="bi bi-circle"></i><span>Cupones</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('vencidos.index') }}">
                        <i class="bi bi-circle"></i><span>Cupones vencidos</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('gastos_diarios.index') }}">
                        <i class="bi bi-circle"></i><span>Gastos diarios</span>
                    </a>
                </li>

                <li>
                    <a href="/productos">
                        <i class="bi bi-circle"></i><span>Productos</span>
                    </a>
                </li>

                <li>
                    <a href="/promociones">
                        <i class="bi bi-circle"></i><span>Promociones</span>
                    </a>
                </li>

                <li>
                    <a href="/compras">
                        <i class="bi bi-circle"></i><span>Compras</span>
                    </a>
                </li>

                <li>
                    <a href="/gastos">
                        <i class="bi bi-circle"></i><span>Gastos</span>
                    </a>
                </li>

                <li>
                    <a href="/inventarios">
                        <i class="bi bi-circle"></i><span>Inventario</span>
                    </a>
                </li>

                <li>
                    <a href="/presupuestos">
                        <i class="bi bi-circle"></i><span>Presupuestos</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Servicios</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/servicios">
                        <i class="bi bi-circle"></i><span>Servicios</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('servicios_pendientes.index') }}">
                        <i class="bi bi-circle"></i><span>Servicios pendientes</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('servicios_efectuados.index') }}">
                        <i class="bi bi-circle"></i><span>Servicios efectuados</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('servicios_efectuados.ventas') }}">
                        <i class="bi bi-circle"></i><span>Venta de servicios</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Recursos</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/empleados">
                        <i class="bi bi-circle"></i><span>Empleados</span>
                    </a>
                </li>

                <li>
                    <a href="/usuarios">
                        <i class="bi bi-circle"></i><span>Usuarios</span>
                    </a>
                </li>

                <li>
                    <a href="/clientes">
                        <i class="bi bi-circle"></i><span>Clientes</span>
                    </a>
                </li>

                <li>
                    <a href="/proveedores">
                        <i class="bi bi-circle"></i><span>Proveedores</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Componentes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/maquinarias">
                        <i class="bi bi-circle"></i><span>Maquinarias</span>
                    </a>
                </li>

                <li>
                    <a href="/mantenimientos">
                        <i class="bi bi-circle"></i><span>Mantenimientos</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav -->
    </ul>
    <!-- Menú Items -->

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Aquí puedes colocar el contenido de tu página -->
                @yield('content')
            </div>

        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Lavandería Jackie 2024</span></strong>. Todos los derechos reservados
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        By <a href="">Jackeline Monacada</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>
