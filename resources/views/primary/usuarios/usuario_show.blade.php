@extends('layouts.principal')
@section('title', 'Detalles del usuario')
@section('content')
<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 30px !important;">Detalles del usuario</h1>
                    <hr>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <!-- Primera fila con 3 datos -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <strong>Nombre:</strong> {{ $usuario->name }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Email:</strong> {{ $usuario->email }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No especificado' }}
                                    </div>
                                </div>

                                <!-- Segunda fila con 3 datos -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <strong>Dirección:</strong> {{ $usuario->direccion ?? 'No especificada' }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                @if($usuario->image)
                                    <img src="{{ asset('assets/img/perfiles/' . $usuario->image) }}" alt="Foto de perfil" class="img-fluid rounded-circle" style="max-width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('img/default-user.png') }}" alt="Foto de perfil por defecto" class="img-fluid rounded-circle" style="max-width: 200px; height: 200px; object-fit: cover;">
                                @endif
                            </div>
                        </div>

                        <!-- Botones fuera de la estructura de columnas -->
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary w-100">Volver a la lista</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning w-100">Editar usuario</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
