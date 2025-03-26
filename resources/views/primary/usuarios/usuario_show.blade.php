@extends('layouts.principal')
@section('title', 'Detalles del usuario')
@section('content')


<style>
.card {
            background-image: url('{{ asset('assets/img/FONDO.jpg') }}');
            background-size: fill;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.67);
            border-radius: 15px;
            transition: background-color 0.3s ease;
        }

        .card-title {
            font-size: 30px !important;
            color: #333;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        </style>
<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 30px !important;">Detalles del usuario {{ $usuario->name }}</h1>
                    <hr>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <!-- Tabla de datos del empleado -->
                                <h4>Datos del usuario</h4>
                                <table class="table table-bordered mb-4">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Nombre</th>
                                            <td>{{  $usuario->name  }}</td>
                                        </tr>
                                       
                                    </tbody>
                                </table>

                                <!-- Tabla de datos del usuario -->
                                <h4>Datos del empleado</h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Nombre</th>
                                            <td>{{ $usuario->empleado->first_name }} {{$usuario->empleado->last_name}}</td>
                                        </tr>

                                        <tr>
                                            <th>Puesto</th>
                                            <td>{{ $usuario->empleado->puesto->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $usuario->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Teléfono</th>
                                            <td>{{ $usuario->telefono ?? 'No especificado' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dirección</th>
                                            <td>{{ $usuario->direccion ?? 'No especificada' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Fecha de registro</th>
                                            <td>{{ $usuario->created_at->format('d/m/Y ') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Última actualización</th>
                                            <td>{{ $usuario->updated_at->format('d/m/Y ') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                @if($usuario->image)
                                    <img src="{{ asset('assets/img/perfiles/' . $usuario->image) }}" alt="Foto de perfil" class="img-fluid rounded-circle" style="max-width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('img/default-user.png') }}" alt="Foto de perfil por defecto" class="img-fluid rounded-circle" style="max-width: 200px; height: 200px; object-fit: cover;">
                                @endif
                            </div>
                        </div>

                        <!-- Botones de acción -->
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
