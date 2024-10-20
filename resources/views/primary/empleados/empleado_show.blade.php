@extends('layouts.principal')
@section('title', 'Detalles del Empleado')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <h1 class="card-title" style="font-size: 30px !important;">Detalles del empleado</h1>
                        <hr>

                        <!-- Información del Empleado -->
                        <div class="row mb-3">
                            <!-- Nombre, Correo, Teléfono, Puesto, Número de Emergencia y Nombre del Contacto de Emergencia en una fila -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Nombre:</strong></label>
                                <p>{{ $empleado->first_name }} {{ $empleado->last_name }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Correo Electrónico:</strong></label>
                                <p>{{ $empleado->email }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Identidad:</strong></label>
                                <p>{{ $empleado->identity }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Teléfono:</strong></label>
                                <p>{{ $empleado->phone }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Puesto:</strong></label>
                                <p>{{ $empleado->puesto->name ?? 'No asignado' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Número de Emergencia:</strong></label>
                                <p>{{ $empleado->emergency_number }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Nombre del Contacto de Emergencia:</strong></label>
                                <p>{{ $empleado->emergency_contact_name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Fecha de Ingreso y Salario en otra fila -->
                            <div class="col-md-4">
                                <label class="form-label"><strong>Fecha de Ingreso:</strong></label>
                                {{ \Carbon\Carbon::setLocale('es') }}
                                <p>{{ \Carbon\Carbon::parse($empleado->hire_date)->translatedFormat('l d \d\e F, Y') }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><strong>Salario:</strong></label>
                                <p>L. {{ number_format($empleado->salary, 2, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Dirección del Empleado -->
                            <div class="col-md-12">
                                <label class="form-label"><strong>Dirección:</strong></label>
                                <p>{{ $empleado->address }}</p>
                            </div>
                        </div>

                       

                        
                        <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('empleados.index') }}" class="btn btn-secondary w-100">Volver a la Lista</a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning w-100">Editar Empleado</a>
                            </div>
                            <div class="col-md-4"></div> <!-- Espacio vacío para mantener la alineación -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
