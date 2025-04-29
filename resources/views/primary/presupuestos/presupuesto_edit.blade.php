@extends('layouts.principal')
@section('title', 'Editar Presupuesto')

@section('content')
    <section class="section">
        @if($usuario->rolpermiso->presupuesto_editar == 1)
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
                                    <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton" formnovalidate>Reestablecer</button>
                                    <a href="{{ route('presupuestos.index') }}" class="btn btn-danger flex-fill">Cancelar</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
                <div class="text-center p-5 bg-white rounded shadow-lg" style="max-width: 600px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/16962/16962145.png"
                         alt="Sin permisos" class="img-fluid mb-4" style="max-height: 250px; border-radius: 10px;">
                    <h2 class="text-danger mb-3">Acceso Denegado</h2>
                    <p class="fs-5">No tienes permisos para acceder a este apartado.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4 px-4 py-2">Volver al inicio</a>
                </div>
            </div>
        @endif

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Obtener la fecha de Honduras (UTC-6) correctamente
                const getHondurasDate = () => {
                    let ahora = new Date();
                    let utcOffset = ahora.getTimezoneOffset() * 60000; // Offset local en ms
                    let hondurasOffset = -6 * 60 * 60000; // UTC-6 en ms
                    return new Date(ahora.getTime() + utcOffset + hondurasOffset);
                };

                // Capturar los valores originales SOLO en la primera carga de la página
                if (!sessionStorage.getItem("originalDataStored")) {
                    sessionStorage.setItem("originalDescripcion", document.getElementById('descripcion').value);
                    sessionStorage.setItem("originalMonto", document.getElementById('monto').value);
                    sessionStorage.setItem("originalFecha", document.getElementById('fecha').value);
                    sessionStorage.setItem("originalDataStored", "true"); // Bandera para evitar sobreescribir
                }

                // Restaurar valores desde sessionStorage
                document.getElementById('reloadButton').addEventListener('click', function () {
                    document.getElementById('descripcion').value = sessionStorage.getItem("originalDescripcion") || "";
                    document.getElementById('monto').value = sessionStorage.getItem("originalMonto") || "";
                    document.getElementById('fecha').value = sessionStorage.getItem("originalFecha") || getHondurasDate().toISOString().split('T')[0];
                });

                // Validación numérica
                window.validarSoloNumeros = function (input) {
                    input.value = input.value.replace(/\D/g, '').slice(0, 8);
                };

                // Capitalizar la primera letra
                document.getElementById('descripcion').addEventListener('input', function (e) {
                    let value = e.target.value.trim();
                    e.target.value = value.charAt(0).toUpperCase() + value.slice(1);
                });

                // Si la fecha está vacía, asignar la fecha de Honduras
                if (!document.getElementById('fecha').value) {
                    document.getElementById('fecha').value = getHondurasDate().toISOString().split('T')[0];
                }
            });
        </script>


    </section>
@endsection
