@extends('layouts.principal')
@section('title', 'Detalles del Empleado')
@section('content')
<style>
.card {
            background-image: url('{{ asset('assets/img/laundry-background.jpg') }}');
            background-size: fill;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.76);
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
        
        .info-label {
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .info-value {
            font-size: 20px;
            font-weight: 500;
            color: #333;
        }
        
        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 20px;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }
</style>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detalles del empleado</h5>
                        <hr>

                        <!-- Información Personal -->
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-label"><strong>Identidad:</strong></div>
                                <div class="info-value">{{ $empleado->identity_number }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label"><strong>Nombre:</strong></div>
                                <div class="info-value">{{ $empleado->first_name }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label"><strong>Apellido:</strong></div>
                                <div class="info-value">{{ $empleado->last_name }}</div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                       
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-label"><strong>Correo electrónico:</strong></div>
                                <div class="info-value">{{ $empleado->email }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label"><strong>Teléfono:</strong></div>
                                <div class="info-value">{{ $empleado->phone }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label"><strong>Dirección:</strong></div>
                                <div class="info-value">{{ $empleado->address }}</div>
                            </div>
                        </div>

                        <!-- Información Laboral -->
                     
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-label"><strong>Puesto:</strong></div>
                                <div class="info-value">{{ $empleado->puesto->name ?? 'No asignado' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label"><strong>Fecha de ingreso:</strong></div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($empleado->hire_date)->translatedFormat('l d \d\e F, Y') }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label"><strong>Salario:</strong></div>
                                <div class="info-value">L. {{ number_format($empleado->salary, 2, ',', '.') }}</div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('empleados.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning w-100">Editar Empleado</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
