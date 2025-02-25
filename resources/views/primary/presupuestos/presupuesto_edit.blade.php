@extends('layouts.principal')
@section('title', 'Editar Presupuesto')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Editar Presupuesto</h1>
                        <hr>
                        <form id="presupuestoEditForm" action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <textarea name="descripcion" id="descripcion" maxlength="255" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $presupuesto->descripcion) }}</textarea>
                                        @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monto">Monto:</label>
                                        <input type="text" name="monto" id="monto" class="form-control @error('monto') is-invalid @enderror" maxlength="8" value="{{ old('monto', $presupuesto->cantidad) }}" oninput="validarSoloNumeros(this)">
                                        @error('monto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha:</label>
                                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $presupuesto->fecha) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                <a href="{{ route('presupuestos.index') }}" class="btn btn-danger flex-fill">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Guardar valores originales al cargar la página
                const originalData = {
                    descripcion: document.getElementById('descripcion').value,
                    monto: document.getElementById('monto').value,
                    fecha: document.getElementById('fecha').value
                };

                // Permitir solo números en el campo de monto
                window.validarSoloNumeros = function (input) {
                    input.value = input.value.replace(/\D/g, '').slice(0, 8);
                };

                // Capitalizar la primera letra de la descripción
                document.getElementById('descripcion').addEventListener('input', function (e) {
                    let value = e.target.value;
                    e.target.value = value.charAt(0).toUpperCase() + value.slice(1);
                });

                document.getElementById('reloadButton').addEventListener('click', function () {
                    document.getElementById('descripcion').value = originalData.descripcion;
                    document.getElementById('monto').value = originalData.monto;

                    // Convertir la fecha al formato correcto antes de asignarla
                    let fechaOriginal = new Date(originalData.fecha);
                    let fechaFormateada = fechaOriginal.toISOString().split('T')[0]; // Formato YYYY-MM-DD
                    document.getElementById('fecha').value = fechaFormateada;
                });

            });
        </script>
    </section>
@endsection
