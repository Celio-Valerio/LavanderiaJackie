<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Animations Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            height: 100vh;
            margin: 0;
            background-color: #f5f7fb; /* Fondo suave */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco con algo de transparencia */
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            animation: float 6s ease-in-out infinite;
            width: 100%;
            max-width: 400px;
            z-index: 1;
            position: relative;
        }

        /* Fondo con figuras de colores material design */
        .background-figures {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 10% 20%, #ff6f61, #ffcc33);
            opacity: 0.1;
            z-index: 0;
            animation: moveFigures 10s infinite ease-in-out;
        }

        /* Burbujas transparentes en movimiento */
        .background-bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .background-bubbles::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(66, 165, 245, 0.4);
            animation: bubbleMovement 15s infinite ease-in-out;
            opacity: 0.5;
        }

        @keyframes moveFigures {
            0% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
            100% { transform: translate(0, 0); }
        }

        @keyframes bubbleMovement {
            0% {
                transform: translate(-50%, 0);
                opacity: 0.5;
            }
            25% {
                transform: translate(-20%, -30%);
                opacity: 0.3;
            }
            50% {
                transform: translate(10%, -20%);
                opacity: 0.6;
            }
            75% {
                transform: translate(40%, 10%);
                opacity: 0.4;
            }
            100% {
                transform: translate(-30%, 50%);
                opacity: 0.5;
            }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .form-control {
            background-color: #f4f7fb;
            border: 1px solid #ddd;
            padding-left: 45px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: #42a5f5;
            background-color: #ffffff;
        }

        .form-floating label {
            color: #555;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #42a5f5;
            border-color: #42a5f5;
            transition: transform 0.3s ease-in-out;
            width: 100%;
            padding: 1rem;
            font-size: 1.2rem;
            border-radius: 12px;
        }

        .btn-primary:hover {
            background-color: #1e88e5;
            border-color: #1e88e5;
            transform: scale(1.05);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(66, 165, 245, 0.5);
        }

        .text-muted {
            color: #757575;
            font-size: 0.9rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header img {
            width: 80px; /* Tamaño del logo */
            height: auto;
            margin-bottom: 15px;
        }

        .login-header h1 {
            color: #42a5f5;
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .text-center a {
            color: #42a5f5;
            font-weight: bold;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .form-floating .password-toggle {
            position: absolute;
            right: 10px;
            top: 45px;
            cursor: pointer;
        }

        .text-danger {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

<!-- Fondo con burbujas en movimiento -->
<div class="background-bubbles"></div>

<!-- Fondo con figuras de colores -->
<div class="background-figures"></div>

<div class="login-card animate__animated animate__fadeIn">
    <div class="login-header">
        <!-- Logo centrado -->
        <div style="display: flex; justify-content: center;">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Lavandería" style="max-width: 70px;">
        </div>
        <h1>Inicio de Sesión</h1>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo Electrónico -->
        <div class="form-floating">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control rounded-4" id="email" name="email" placeholder="nombre@ejemplo.com" required autofocus>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="form-floating position-relative">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control rounded-4 pr-5" id="password" name="password" placeholder="Contraseña" required>
            <i class="mdi mdi-eye password-toggle" id="togglePassword" style="color: #42a5f5; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Texto informativo -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Recordar sesión</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button class="btn btn-lg btn-primary mb-3" type="submit">
            Ingresar
        </button>

        <div class="text-center mt-4">
            <p class="text-muted">¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</div>

<script>
    // Script para mostrar/ocultar la contraseña
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        togglePassword.classList.toggle('mdi-eye-off');
    });
</script>

</body>
</html>
