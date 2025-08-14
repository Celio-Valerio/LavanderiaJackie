<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restablecer contraseña</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Reset y fondo principal */
        body {
            font-family: 'Figtree', sans-serif;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom right, #e0f7fa, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            width: 100%; height: 100%;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(0,188,212,0.2) 0%, transparent 40%),
                radial-gradient(circle at 80% 30%, rgba(3,169,244,0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(0,150,136,0.1) 0%, transparent 50%),
                radial-gradient(circle at 30% 50%, rgba(255,255,255,0.2) 0%, transparent 30%);
            z-index: 0;
            pointer-events: none;
        }

        /* Figuras de fondo */
        .background-figures {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 10% 20%, #ff6f61, #ffcc33);
            opacity: 0.1;
            z-index: 0;
            animation: moveFigures 20s infinite ease-in-out;
        }
        @keyframes moveFigures {
            0%   { transform: translate(0, 0); }
            50%  { transform: translate(30px, 30px); }
            100% { transform: translate(0, 0); }
        }

        /* Burbujas en movimiento */
        .background-bubbles {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
        }
        .background-bubbles::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 50px; height: 50px;
            border-radius: 50%;
            background: rgba(66,165,245,0.4);
            animation: bubbleMovement 15s infinite ease-in-out;
            opacity: 0.5;
        }
        .bubble {
            position: absolute;
            width: 40px; height: 40px;
            border-radius: 50%;
            background: rgba(66,165,245,0.3);
            animation: bubbleMovement 25s infinite ease-in-out;
            opacity: 0.4;
        }
        @keyframes bubbleMovement {
            0%   { transform: translate(-30%, 50%); opacity: 0.5; }
            25%  { transform: translate(-20%, -30%); opacity: 0.3; }
            50%  { transform: translate(10%, -20%); opacity: 0.6; }
            75%  { transform: translate(40%, 10%); opacity: 0.4; }
            100% { transform: translate(-30%, 50%); opacity: 0.5; }
        }

        /* SVG de formas geométricas */
        .background-shapes {
            position: absolute;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: 0;
            opacity: 0.25;
            pointer-events: none;
        }

        /* Tarjeta de restablecer contraseña */
        .login-card {
            background-color: rgba(255,255,255,0.9);
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 2rem;
            animation: float 6s ease-in-out infinite;
            width: 100%;
            max-width: 450px;
            z-index: 1;
            position: relative;
        }
        @keyframes float {
            0%   { transform: translateY(0); }
            50%  { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        /* Formulario e inputs */
        .form-floating {
            position: relative;
            margin-bottom: 20px;
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 65%;
            transform: translateY(-50%);
            color: #757575;
            font-size: 1.25rem;
            pointer-events: none;
        }
        .form-control {
            width: 100%;
            box-sizing: border-box;
            background-color: #f4f7fb;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 0.75rem 45px 0.75rem 45px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #42a5f5;
            background-color: #ffffff;
            outline: none;
        }

        /* Botón de mostrar/ocultar contraseña */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 65%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #757575;
            cursor: pointer;
            padding: 0;
            font-size: 1.25rem;
            z-index: 2;
        }
        .password-toggle:hover {
            color: #42a5f5;
        }

        /* Botón principal */
        .btn-primary {
            display: block;
            width: 100%;
            padding: 1rem;
            font-size: 1.2rem;
            border-radius: 12px;
            border: 1px solid #42a5f5;
            background-color: #42a5f5;
            color: #fff;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #1e88e5;
            border-color: #1e88e5;
            transform: scale(1.05);
        }
        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(66,165,245,0.5);
        }

        /* Textos auxiliares */
        .text-muted {
            color: #757575;
            font-size: 0.9rem;
        }
        .text-center {
            text-align: center;
        }
        .text-center a {
            color: #42a5f5;
            font-weight: bold;
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
        .text-danger {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 0.25rem;
        }

        /* Encabezado */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header img {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
        }
        .login-header h1 {
            color: #42a5f5;
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }
    </style>
</head>
<body>

<!-- Fondos animados -->
<div class="background-figures"></div>
<div class="background-bubbles">
    <div class="bubble" style="top:10%; left:15%;  animation-delay: 0s;"></div>
    <div class="bubble" style="top:70%; left:80%;  animation-delay: 2s;"></div>
    <div class="bubble" style="top:30%; left:50%;  animation-delay: 4s;"></div>
    <div class="bubble" style="top:85%; left:30%;  animation-delay: 6s;"></div>
    <div class="bubble" style="top:45%; left:90%;  animation-delay: 8s;"></div>
    <div class="bubble" style="top:60%; left:10%;  animation-delay: 10s;"></div>
    <div class="bubble" style="top:20%; left:70%;  animation-delay: 12s;"></div>
</div>

<!-- SVG con formas geométricas -->
<svg class="background-shapes" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
    <!-- 7 Círculos animados -->
    <circle cx="5" cy="15" r="1.2" stroke="#42a5f5" stroke-width="0.3" fill="none">
        <animate attributeName="cy" values="15;18;15" dur="12s" repeatCount="indefinite"/>
    </circle>
    <circle cx="25" cy="65" r="1.8" stroke="#26c6da" stroke-width="0.3" fill="none">
        <animate attributeName="cx" values="25;28;25" dur="15s" repeatCount="indefinite"/>
    </circle>
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
    <!-- 7 Triángulos animados -->
    <polygon points="10,25 12,22 14,25" stroke="#ffa726" stroke-width="0.3" fill="none">
        <animateTransform attributeName="transform" type="translate" values="0,0;0,-3;0,0" dur="10s" repeatCount="indefinite"/>
    </polygon>
    <polygon points="30,45 32,42 34,45" stroke="#ef5350" stroke-width="0.3" fill="none">
        <animateTransform attributeName="transform" type="translate" values="0,0;0,-2;0,0" dur="12s" repeatCount="indefinite"/>
    </polygon>
    <!-- Más formas geométricas sin animación adicional -->
    <circle cx="10" cy="20" r="1.5" stroke="#42a5f5" stroke-width="0.4" fill="none">
        <animate attributeName="cy" values="20;22;20" dur="5s" repeatCount="indefinite"/>
    </circle>
    <circle cx="30" cy="60" r="2" stroke="#26c6da" stroke-width="0.4" fill="none"/>
    <circle cx="50" cy="40" r="1" stroke="#ab47bc" stroke-width="0.4" fill="none"/>
    <polygon points="20,30 22,26 24,30" stroke="#ffa726" stroke-width="0.4" fill="none">
        <animateTransform attributeName="transform" type="translate" values="0,0;0,-1;0,0" dur="6s" repeatCount="indefinite"/>
    </polygon>
    <polygon points="70,70 72,66 74,70" stroke="#ef5350" stroke-width="0.4" fill="none"/>
    <g stroke="#66bb6a" stroke-width="0.4">
        <line x1="60" y1="20" x2="62" y2="22"/>
        <line x1="62" y1="20" x2="60" y2="22"/>
    </g>
    <g stroke="#29b6f6" stroke-width="0.4">
        <line x1="80" y1="80" x2="82" y2="82"/>
        <line x1="82" y1="80" x2="80" y2="82"/>
    </g>
    <polygon points="40,60 41,58 43,58 44,60 42,62" stroke="#ec407a" stroke-width="0.4" fill="none"/>
    <polygon points="15,15 16,14 18,14 19,15 19,17 18,18 16,18 15,17" stroke="#7e57c2" stroke-width="0.4" fill="none"/>
    <polygon points="85,30 86,28 88,29 89,32 87,34 85,33" stroke="#26a69a" stroke-width="0.4" fill="none">
        <animateTransform attributeName="transform" type="rotate" from="0 87 31" to="360 87 31" dur="20s" repeatCount="indefinite"/>
    </polygon>
</svg>


<!-- Tarjeta de restablecer contraseña -->
<div class="login-card animate__animated animate__fadeIn">

    <div class="login-header">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Lavandería">
        <h1>Restablecer contraseña</h1>
        <hr>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('status'))
        <div style="background:#e6ffed;border:1px solid #34c759;color:#1b5e20;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;text-align:center;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.security.reset') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="form-floating position-relative">
            <label for="password">Nueva contraseña</label>
            <i class="mdi mdi-lock-outline input-icon"></i>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Nueva contraseña"
                required
                maxlength="20"
            >
            <button type="button" class="password-toggle" id="togglePassword">
                <i class="mdi mdi-eye-off"></i>
            </button>
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-floating position-relative">
            <label for="password_confirmation">Confirmar contraseña</label>
            <i class="mdi mdi-lock-outline input-icon"></i>
            <input
                type="password"
                class="form-control"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Confirmar contraseña"
                required
                maxlength="20"
            >
            <button type="button" class="password-toggle" id="togglePasswordConfirmation">
                <i class="mdi mdi-eye-off"></i>
            </button>
        </div>

        <button type="submit" class="btn-primary">Cambiar contraseña</button>
    </form>

    <script>
        (function () {
            const allowedRegex = /[^A-Za-z0-9$\-._@]/g; // todo lo NO permitido
            const inputs = [document.getElementById('password'), document.getElementById('password_confirmation')];

            function sanitize(value) {
                // 1) Eliminar espacios (cualquier whitespace) y 2) eliminar no permitidos
                value = value.replace(/\s+/g, '');         // sin espacios
                value = value.replace(allowedRegex, '');   // solo letras/números/$-._@
                return value;
            }

            function attachGuards(el) {
                // Bloquear barra espaciadora y entradas no deseadas por teclado
                el.addEventListener('keydown', function (e) {
                    if (e.key === ' ' || e.key === 'Spacebar') {
                        e.preventDefault();
                    }
                });

                // Limpiar en tiempo real (tanto tipeo como pegar/arrastrar)
                el.addEventListener('input', function (e) {
                    const cleaned = sanitize(e.target.value);
                    if (e.target.value !== cleaned) {
                        const pos = e.target.selectionStart;
                        e.target.value = cleaned;
                        // Ajuste simple del cursor
                        e.target.setSelectionRange(cleaned.length, cleaned.length);
                    }
                });

                // Extra: evitar pegar contenido inválido antes de que entre al input
                el.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text');
                    const cleaned = sanitize(text);
                    const start = el.selectionStart;
                    const end = el.selectionEnd;
                    const before = el.value.slice(0, start);
                    const after = el.value.slice(end);
                    const next = (before + cleaned + after).slice(0, el.maxLength || 9999);
                    el.value = next;
                    const caret = (before + cleaned).length;
                    el.setSelectionRange(caret, caret);
                });
            }

            inputs.forEach(attachGuards);

            // Toggles de visibilidad (ya los tenías)
            document.getElementById('togglePassword').addEventListener('click', function() {
                const pwd = document.getElementById('password');
                const icon = this.querySelector('i');
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    icon.classList.replace('mdi-eye-off', 'mdi-eye');
                } else {
                    pwd.type = 'password';
                    icon.classList.replace('mdi-eye', 'mdi-eye-off');
                }
            });
            document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
                const pwd = document.getElementById('password_confirmation');
                const icon = this.querySelector('i');
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    icon.classList.replace('mdi-eye-off', 'mdi-eye');
                } else {
                    pwd.type = 'password';
                    icon.classList.replace('mdi-eye', 'mdi-eye-off');
                }
            });
        })();
    </script>
</div>


</body>
</html>
