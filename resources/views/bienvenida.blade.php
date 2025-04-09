<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lavandería Jackie - Servicios Profesionales de Lavandería</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), url('https://images.unsplash.com/photo-1576560663481-a8f6cbd7d74a') center/cover;
            color: white;
            padding: 120px 0;
        }
        .service-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .contact-section {
            background: #f8f9fa;
            padding: 80px 0;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }
        .social-links a {
            color: white;
            margin: 0 10px;
            font-size: 24px;
            transition: color 0.3s;
        }
        .social-links a:hover {
            color: #18bc9c;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
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
                    <a href="{{ route('login') }}" class="btn btn-primary ml-2">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" id="inicio">
    <div class="container text-center">
        <h1 class="display-4 mb-4">Servicios Profesionales de Lavandería</h1>
        <p class="lead mb-4">Lavado, planchado y cuidado profesional de prendas</p>
        <a href="#contacto" class="btn btn-light btn-lg">Programar Recogida</a>
    </div>
</section>

<!-- Servicios -->
<section class="py-5" id="servicios">
    <div class="container">
        <h2 class="text-center mb-5">Nuestros Servicios</h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952" class="card-img-top" alt="Lavado estándar">
                    <div class="card-body">
                        <h5 class="card-title">Lavado Estándar</h5>
                        <p class="card-text">Servicio completo de lavado y secado para ropa diaria</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <img src="https://images.unsplash.com/photo-1626804475297-41608ea09aeb" class="card-img-top" alt="Lavado delicado">
                    <div class="card-body">
                        <h5 class="card-title">Lavado Delicado</h5>
                        <p class="card-text">Cuidado especial para prendas delicadas y de alta calidad</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <img src="https://images.unsplash.com/photo-1617791160536-598cf32026fb" class="card-img-top" alt="Planchado profesional">
                    <div class="card-body">
                        <h5 class="card-title">Planchado Profesional</h5>
                        <p class="card-text">Deje sus prendas impecablemente planchadas por nuestros expertos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contacto">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h3 class="mb-4">Visítanos</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.1856350364265!2d-86.58251168569567!3d13.83113259029145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f7516c22b6a9c7b%3A0x1e3e5b7f4a4b4b7a!2sDanl%C3%AD%2C%20El%20Para%C3%ADso!5e0!3m2!1ses!2shn!4v1653592345678!5m2!1ses!2shn" style="border:0;" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="mb-4">Contáctanos</h3>
                <div class="contact-info mb-4">
                    <p><i class="fas fa-map-marker-alt"></i> Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso</p>
                    <p><i class="fas fa-phone"></i> <a href="tel:+50496085567">9608-5567</a></p>
                    <p><i class="fas fa-envelope"></i> <a href="mailto:jacky.moncada25@gmail.com">jacky.moncada25@gmail.com</a></p>
                </div>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Correo electrónico">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="4" placeholder="Mensaje"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Horario de Atención</h5>
                <p>Lunes a Viernes: 7:00 AM - 7:00 PM<br>
                    Sábados: 8:00 AM - 5:00 PM</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Redes Sociales</h5>
                <div class="social-links">
                    <a href="https://facebook.com/tu_pagina" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://instagram.com/tu_cuenta" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <hr>
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
