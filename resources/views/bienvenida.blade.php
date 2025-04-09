<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lavandería Jackie - Servicios Profesionales</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #2B59C3;
            --secondary-color: #FF9F1C;
            --accent-color: #8BAAAD;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #F8F9FA;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .hero-section {
            background: linear-gradient(rgba(43,89,195,0.8), rgba(43,89,195,0.8)), url('https://images.unsplash.com/photo-1582213782179-e0d53f98f2ba') center/cover;
            color: white;
            padding: 150px 0;
        }
        .service-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .service-card img {
            height: 250px;
            object-fit: cover;
            border-bottom: 3px solid var(--secondary-color);
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .badge-feature {
            background: var(--secondary-color);
            color: white;
            font-size: 0.9rem;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 40px 0;
        }
        .social-links a {
            color: white;
            margin: 0 10px;
            font-size: 24px;
            transition: transform 0.3s;
        }
        .social-links a:hover {
            transform: translateY(-3px);
            color: var(--secondary-color);
        }
        .contact-info p {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        .btn-custom {
            background: var(--secondary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
        }
        .btn-custom:hover {
            background: #FF8C00;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="#" style="color: var(--primary-color);">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 40px;">
            Lavandería Jackie
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                <li class="nav-item">
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-primary ml-2">Inicio</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary ml-2">Iniciar sesión</a>
                    @endauth
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" id="inicio">
    <div class="container text-center">
        <h1 class="display-4 mb-4 font-weight-bold">Cuidado Profesional para Tus Prendas</h1>
        <p class="lead mb-4">Especialistas en lavado de ropa, peluches, cobijas y artículos delicados</p>
        <a href="#contacto" class="btn btn-custom btn-lg">Solicitar Servicio</a>
    </div>
</section>

<!-- Servicios -->
<section class="py-5" id="servicios">
    <div class="container">
        <h2 class="text-center mb-5 display-4 font-weight-bold" style="color: var(--primary-color);">Nuestros Servicios</h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <img src="{{ asset('assets/img/bienvenida/ropa.jpg') }}" class="card-img-top" alt="Lavado de ropa">
                    <div class="card-body text-center">
                        <h5 class="card-title font-weight-bold">Lavado de Ropa</h5>
                        <p class="card-text">Lavado profesional con técnicas especializadas para todo tipo de prendas</p>
                        <span class="badge badge-feature">Incluye secado y doblado</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <img src="{{ asset('assets/img/bienvenida/peluches.png') }}" class="card-img-top" alt="Limpieza de peluches">
                    <div class="card-body text-center">
                        <h5 class="card-title font-weight-bold">Limpieza de Peluches</h5>
                        <p class="card-text">Lavado especializado para juguetes de peluche y muñecos de tela</p>
                        <span class="badge badge-feature">Secado controlado</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <img src="{{ asset('assets/img/bienvenida/cobijas.jpg') }}" class="card-img-top" alt="Lavado de cobijas">
                    <div class="card-body text-center">
                        <h5 class="card-title font-weight-bold">Lavado de Cobijas</h5>
                        <p class="card-text">Cuidado especial para edredones, colchas y cubrecamas</p>
                        <span class="badge badge-feature">Grandes dimensiones</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <i class="fas fa-tint feature-icon"></i>
                <h5>Productos Ecológicos</h5>
                <p>Detergentes hipoalergénicos y amigables con el medio ambiente</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fas fa-clock feature-icon"></i>
                <h5>Servicio Express</h5>
                <p>Lavado urgente disponible en 4 horas</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fas fa-shield-alt feature-icon"></i>
                <h5>Protección Total</h5>
                <p>Seguro contra daños y pérdidas</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fas fa-truck feature-icon"></i>
                <h5>Recogida a Domicilio</h5>
                <p>Servicio gratuito en área metropolitana</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5" id="contacto">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h3 class="mb-4 font-weight-bold">Visítanos</h3>
                <div class="embed-responsive embed-responsive-16by9 shadow-lg">
                    <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.1856350364265!2d-86.58251168569567!3d13.83113259029145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f7516c22b6a9c7b%3A0x1e3e5b7f4a4b4b7a!2sDanl%C3%AD%2C%20El%20Para%C3%ADso!5e0!3m2!1ses!2shn!4v1653592345678!5m2!1ses!2shn" style="border:0;" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="mb-4 font-weight-bold">Contáctanos</h3>
                    <div class="contact-info">
                        <p class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso
                        </p>
                        <p class="d-flex align-items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <a href="tel:+50496085567">9608-5567</a>
                        </p>
                        <p class="d-flex align-items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <a href="mailto:jacky.moncada25@gmail.com">jacky.moncada25@gmail.com</a>
                        </p>
                    </div>
                    <div class="mt-4">
                        <h5 class="mb-3">Horario de Atención</h5>
                        <p>Lunes a Viernes: 7:00 AM - 7:00 PM<br>
                            Sábados: 8:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Nuestra Misión</h5>
                <p>Brindar cuidado profesional a tus prendas con tecnología ecológica y atención personalizada.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="#inicio" class="text-light">Inicio</a></li>
                    <li><a href="#servicios" class="text-light">Servicios</a></li>
                    <li><a href="#contacto" class="text-light">Contacto</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Conéctate</h5>
                <div class="social-links">
                    <a href="https://wa.me/50496085567" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.facebook.com/share/1BYi4y3Xf6/" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/lavanderiajackie?igsh=MW9iNm4yZXc5Z3o4ag==" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <hr class="bg-white">
        <div class="text-center mt-4">
            <p>&copy; 2024 Lavandería Jackie - Todos los derechos reservados</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
