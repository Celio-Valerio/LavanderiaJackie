<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lavandería Jackie - Reestablecer contraseña</title>
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
            background: linear-gradient(to bottom right, #e0f7fa, #ffffff); /* Suave degradado tipo agua */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 10% 20%, rgba(0, 188, 212, 0.2) 0%, transparent 40%),
            radial-gradient(circle at 80% 30%, rgba(3, 169, 244, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(0, 150, 136, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.2) 0%, transparent 30%);
            z-index: 0;
            pointer-events: none;
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

        .background-figures {
            animation: moveFigures 20s infinite ease-in-out; /* Animación más lenta */
        }

        @keyframes moveFigures {
            0% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
            100% { transform: translate(0, 0); }
        }

        .bubble {
            position: absolute;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(66, 165, 245, 0.3);
            animation: bubbleMovement 25s infinite ease-in-out;
            opacity: 0.4;
        }

        @keyframes bubbleMovement {
            0% {
                transform: translate(0, 0);
                opacity: 0.4;
            }
            25% {
                transform: translate(100px, -150px);
                opacity: 0.3;
            }
            50% {
                transform: translate(200px, 50px);
                opacity: 0.5;
            }
            75% {
                transform: translate(-100px, 100px);
                opacity: 0.3;
            }
            100% {
                transform: translate(0, 0);
                opacity: 0.4;
            }
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

        .text-danger {
            font-size: 0.8rem;
        }

        .background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            opacity: 0.25;
            pointer-events: none;
        }

        .password-requirements {
            color: #616161;
            font-size: 0.9rem;
            margin: 1rem 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }

    </style>
</head>
<body>

<!-- Fondo con burbujas en movimiento -->
<div class="background-bubbles"></div>

<!-- Fondo con figuras de colores -->
<div class="background-figures"></div>

<!-- Burbujas con 7 instancias -->
<div class="background-bubbles">
    <div class="bubble" style="top:10%; left:15%; animation-delay: 0s"></div>
    <div class="bubble" style="top:70%; left:80%; animation-delay: 2s"></div>
    <div class="bubble" style="top:30%; left:50%; animation-delay: 4s"></div>
    <div class="bubble" style="top:85%; left:30%; animation-delay: 6s"></div>
    <div class="bubble" style="top:45%; left:90%; animation-delay: 8s"></div>
    <div class="bubble" style="top:60%; left:10%; animation-delay: 10s"></div>
    <div class="bubble" style="top:20%; left:70%; animation-delay: 12s"></div>
</div>

<!-- SVG con figuras repetidas -->
<svg class="background-shapes" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
    <!-- 7 Círculos con animaciones -->
    <circle cx="5" cy="15" r="1.2" stroke="#42a5f5" stroke-width="0.3" fill="none">
        <animate attributeName="cy" values="15;18;15" dur="12s" repeatCount="indefinite"/>
    </circle>
    <circle cx="25" cy="65" r="1.8" stroke="#26c6da" stroke-width="0.3" fill="none">
        <animate attributeName="cx" values="25;28;25" dur="15s" repeatCount="indefinite"/>
    </circle>
    <!-- Repetir círculos 5 veces más con diferentes posiciones -->
    <circle cx="45" cy="35" r="1.2" stroke="#ab47bc" stroke-width="0.3" fill="none">
        <animate attributeName="cy" values="35;38;35" dur="14s" repeatCount="indefinite"/>
    </circle>
    <circle cx="65" cy="55" r="1.5" stroke="#7e57c2" stroke-width="0.3" fill="none">
        <animate attributeName="cx" values="65;68;65" dur="16s" repeatCount="indefinite"/>
    </circle>
    <circle cx="85" cy="25" r="1.2" stroke="#ec407a" stroke-width="0.3" fill="none">
        <animate attributeName="cy" values="25;28;25" dur="13s" repeatCount="indefinite"/>
    </circle>
    <circle cx="15" cy="75" r="1.5" stroke="#66bb6a" stroke-width="0.3" fill="none">
        <animate attributeName="cy" values="75;78;75" dur="17s" repeatCount="indefinite"/>
    </circle>
    <circle cx="95" cy="85" r="1.2" stroke="#29b6f6" stroke-width="0.3" fill="none">
        <animate attributeName="cx" values="95;92;95" dur="18s" repeatCount="indefinite"/>
    </circle>

    <!-- 7 Triángulos con animaciones -->
    <polygon points="10,25 12,22 14,25" stroke="#ffa726" stroke-width="0.3" fill="none">
        <animateTransform attributeName="transform" type="translate" values="0,0;0,-3;0,0" dur="10s" repeatCount="indefinite"/>
    </polygon>
    <!-- Repetir triángulos 6 veces más -->
    <polygon points="30,45 32,42 34,45" stroke="#ef5350" stroke-width="0.3" fill="none">
        <animateTransform attributeName="transform" type="translate" values="0,0;0,-2;0,0" dur="12s" repeatCount="indefinite"/>
    </polygon>
    <!-- Círculos -->
    <circle cx="10" cy="20" r="1.5" stroke="#42a5f5" stroke-width="0.4" fill="none">
        <animate attributeName="cy" values="20;22;20" dur="5s" repeatCount="indefinite" />
    </circle>
    <circle cx="30" cy="60" r="2" stroke="#26c6da" stroke-width="0.4" fill="none" />
    <circle cx="50" cy="40" r="1" stroke="#ab47bc" stroke-width="0.4" fill="none" />

    <!-- Triángulos -->
    <polygon points="20,30 22,26 24,30" stroke="#ffa726" stroke-width="0.4" fill="none">
        <animateTransform attributeName="transform" type="translate" values="0,0;0,-1;0,0" dur="6s" repeatCount="indefinite" />
    </polygon>
    <polygon points="70,70 72,66 74,70" stroke="#ef5350" stroke-width="0.4" fill="none" />

    <!-- Cruces (X) -->
    <g stroke="#66bb6a" stroke-width="0.4">
        <line x1="60" y1="20" x2="62" y2="22" />
        <line x1="62" y1="20" x2="60" y2="22" />
    </g>
    <g stroke="#29b6f6" stroke-width="0.4">
        <line x1="80" y1="80" x2="82" y2="82" />
        <line x1="82" y1="80" x2="80" y2="82" />
    </g>

    <!-- Pentágonos -->
    <polygon points="40,60 41,58 43,58 44,60 42,62" stroke="#ec407a" stroke-width="0.4" fill="none" />

    <!-- Octágonos -->
    <polygon points="15,15 16,14 18,14 19,15 19,17 18,18 16,18 15,17" stroke="#7e57c2" stroke-width="0.4" fill="none" />

    <!-- Polígono irregular -->
    <polygon points="85,30 86,28 88,29 89,32 87,34 85,33" stroke="#26a69a" stroke-width="0.4" fill="none">
        <animateTransform attributeName="transform" type="rotate" from="0 87 31" to="360 87 31" dur="20s" repeatCount="indefinite" />
    </polygon>
</svg>

<!-- Mismos elementos de fondo que en login -->
<div class="login-card animate__animated animate__fadeIn">
    <div class="login-header">
        <div style="display: flex; justify-content: center;">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Lavandería" style="max-width: 70px;">
        </div>
        <h1>Restablecer Contraseña</h1>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="form-floating">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control rounded-4"
                   id="email" name="email"
                   placeholder="nombre@ejemplo.com"
                   required
                   value="{{ old('email', $request->email) }}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating position-relative">
            <label for="password">Nueva Contraseña</label>
            <input type="password"
                   class="form-control rounded-4 pe-5"
                   id="password"
                   name="password"
                   placeholder="Nueva Contraseña"
                   required>
            <i class="mdi mdi-eye password-toggle"
               style="color: #42a5f5; position: absolute; right: 15px; top: 57%; transform: translateY(-50%); cursor: pointer;"></i>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating position-relative">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password"
                   class="form-control rounded-4 pe-5"
                   id="password_confirmation"
                   name="password_confirmation"
                   placeholder="Confirmar Contraseña"
                   required>
            <i class="mdi mdi-eye password-toggle"
               style="color: #42a5f5; position: absolute; right: 15px; top: 57%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>

        <div class="password-requirements">
            La contraseña debe contener al menos:
            <ul class="mt-1 mb-0">
                <li>8 caracteres mínimo</li>
                <li>1 letra mayúscula</li>
                <li>1 signo</li>
                <li>1 número</li>
            </ul>
        </div>

        <button class="btn btn-lg btn-primary mb-3" type="submit">
            Restablecer Contraseña
        </button>
    </form>
</div>

<script>
    // Script para mostrar/ocultar contraseña
    document.querySelectorAll('.password-toggle').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            this.classList.toggle('mdi-eye-off');
        });
    });
</script>

</body>
</html>
