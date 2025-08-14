<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesión</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        :root{ --brand:#2a9fd6; --brand-600:#1f86b7; --ring:rgba(42,159,214,.3); --error:#d93025 }
        *{ box-sizing:border-box }
        body{
            margin:0; font-family:'Figtree',sans-serif; background:linear-gradient(180deg,#e8f6fb,#fff);
            display:flex; align-items:center; justify-content:center; min-height:100vh; padding:20px;
        }
        .card{ background:#fff; padding:28px; border-radius:16px; max-width:420px; width:100%;
            box-shadow:0 10px 25px rgba(0,0,0,0.08); }
        .logo{ width:84px; height:auto; display:block; margin:0 auto; }
        .title{ text-align:center; font-size:1.6rem; font-weight:600; margin:10px 0 22px; color:var(--brand) }

        .field{ position:relative; margin-bottom:20px; }
        label{ display:block; font-size:.92rem; color:#555; margin-bottom:6px; }
        .icon{ position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#7b8b9b; font-size:20px; pointer-events:none }
        .input{ width:100%; padding:14px 44px; border-radius:12px; border:1px solid #dbe7ef; background:#f7fbfe; font-size:1rem; }
        .field:has(.toggle) .input{ padding-right:56px }
        .input:focus{ border-color:var(--brand); background:#fff; outline:none; box-shadow:0 0 0 4px var(--ring) }
        .toggle{ position:absolute; right:10px; top:50%; transform:translateY(-50%); border:none; background:transparent; cursor:pointer; color:#7b8b9b; font-size:20px; padding:6px; border-radius:8px }
        .toggle:focus{ outline:none; box-shadow:0 0 0 3px var(--ring) }

        .hint{ font-size:.82rem; color:#7c8794; margin-top:6px; min-height:1em; }
        .error{ font-size:.84rem; color:var(--error); margin-top:8px; min-height:1em; }

        .btn{ display:inline-flex; justify-content:center; align-items:center; width:100%; padding:14px; background:var(--brand); color:#fff; font-weight:600; font-size:1rem; border:none; border-radius:12px; cursor:pointer; transition:background .15s; }
        .btn:hover{ background:var(--brand-600) }

        .links{ text-align:center; margin-top:16px; font-size:.92rem }
        .links a{ color:var(--brand); font-weight:600; text-decoration:none }
        .links a:hover{ text-decoration:underline }
    </style>
</head>
<body>
<main role="main">
    <section class="card" aria-label="Formulario de inicio de sesión">
        @if (session('status'))
            <div id="status-message" style="background:#e6ffed;border:1px solid #34c759;color:#1b5e20;
        padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;text-align:center;
        transition: opacity 0.5s ease;">
                {{ session('status') }}
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const msg = document.getElementById('status-message');
                    if (msg) {
                        setTimeout(() => {
                            msg.style.opacity = '0';
                            setTimeout(() => msg.remove(), 500); // elimina después del fade
                        }, 4000); // 5 segundos visible
                    }
                });
            </script>
        @endif

        <header>
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Lavandería" class="logo" loading="lazy" decoding="async">
            <h1 class="title">Inicio de Sesión</h1>
        </header>
        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
            @csrf
            <div class="field">
                <label for="email">Correo electrónico</label>
                <i class="mdi mdi-email-outline icon" aria-hidden="true"></i>
                <input class="input" id="email" name="email" type="email" placeholder="tucorreo@ejemplo.com" value="{{ old('email') }}" required autocomplete="username" maxlength="30" pattern="[^\s]+">
                <div class="hint" id="emailHint">Usa el correo registrado en la lavandería.</div>
            </div>
            <div class="field">
                <label for="password">Contraseña</label>
                <i class="mdi mdi-lock-outline icon" aria-hidden="true"></i>
                <input class="input" id="password" name="password" type="password" placeholder="••••••••" required minlength="6" autocomplete="current-password" maxlength="20" pattern="[^\s]+">
                <button class="toggle" type="button" id="togglePassword" aria-pressed="false" aria-label="Mostrar u ocultar contraseña"><i class="mdi mdi-eye-off"></i></button>
                <div class="error" id="formError">@if ($errors->has('password') || $errors->has('email')){{ $errors->first('password') ?: $errors->first('email') }}@endif</div>
            </div>
            <button type="submit" class="btn" id="submitBtn"><span class="btn-text">Ingresar</span></button>
        </form>
        <div class="links">
            <p class="hint">¿Olvidaste tu contraseña?</p>
            @if (Route::has('password.security.email'))
                <a href="{{ route('password.security.email') }}">Recupérala con tu pregunta de seguridad</a>
            @endif
        </div>
    </section>
</main>
<script>
    document.getElementById('togglePassword').addEventListener('click', function(){
        const pwd = document.getElementById('password');
        const icon = this.querySelector('i');
        if(pwd.type==='password'){ pwd.type='text'; icon.classList.replace('mdi-eye-off','mdi-eye'); }
        else{ pwd.type='password'; icon.classList.replace('mdi-eye','mdi-eye-off'); }
    });

    // Bloquear espacios en blanco en inputs
    ['email','password'].forEach(id=>{
        const el=document.getElementById(id);
        el.addEventListener('input',()=>{ el.value = el.value.replace(/\s/g,''); });
    });
</script>
</body>
</html>
