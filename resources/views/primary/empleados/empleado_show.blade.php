@extends('layouts.principal')
@section('title', 'Detalles del Empleado')
@section('content')

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detalles del empleado</h5>
                        <hr>

                        <!-- Información del Empleado -->
                        <div class="row mb-3">
                            <!-- Nombre, Correo y Teléfono en una fila -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Nombre: </strong>{{ $empleado->first_name }} {{ $empleado->last_name }}</label>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Correo electrónico: </strong>{{ $empleado->email }}</label>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Teléfono: </strong>{{ $empleado->phone }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Puesto, Fecha de Ingreso y Salario en otra fila -->
                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Puesto: </strong>{{ $empleado->puesto->name ?? 'No asignado' }}</label>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Fecha de ingreso: </strong>{{ \Carbon\Carbon::parse($empleado->hire_date)->translatedFormat('l d \d\e F, Y') }}</label>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small-text-field"><strong>Salario: </strong>L. {{ number_format($empleado->salary, 2, ',', '.') }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Dirección del Empleado -->
                            <div class="col-md-12">
                                <label class="form-label small-text-field"><strong>Dirección: </strong>{{ $empleado->address }}</label>
                            </div>
                        </div>

                        <!-- Botones de acción (1 columna cada uno en la misma fila) -->
                        <div class="row">
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
