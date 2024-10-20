@extends('layouts.principal')
@section('title', 'Actualizar Máquina')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Actualizar Máquina</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="maquinaForm" action="{{ route('maquinas.update', $maquina->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT') <!-- Enviar método PUT para la actualización -->

                            <div class="row mb-3">
                                <!-- Campo de Nombre -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre', $maquina->nombre) }}" placeholder="Ej: Excavadora" maxlength="50" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Modelo -->
                                <div class="col-md-6">
                                    <label for="modelo" class="form-label">Modelo</label>
                                    <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" id="modelo" value="{{ old('modelo', $maquina->modelo) }}" placeholder="Ej: 2021" maxlength="10" required>
                                    @error('modelo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Marca -->
                                <div class="col-md-6">
                                    <label for="marca" class="form-label">Marca</label>
                                    <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror" id="marca" value="{{ old('marca', $maquina->marca) }}" placeholder="Ej: Caterpillar" maxlength="50" required>
                                    @error('marca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Año de Compra -->
                                <div class="col-md-6">
                                    <label for="anio_compra" class="form-label">Año de Compra</label>
                                    <input type="number" name="anio_compra" class="form-control @error('anio_compra') is-invalid @enderror" id="anio_compra" value="{{ old('anio_compra', $maquina->anio_compra) }}" min="1900" max="{{ date('Y') }}" required maxlength="4" oninput="this.value = this.value.slice(0, 4);">
                                    @error('anio_compra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Descripción -->
                                <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Máquina para construcción" maxlength="500" rows="3">{{ old('descripcion', $maquina->descripcion) }}</textarea>
                                    @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reloadButton">Reestablecer</button>
                                <a href="{{ route('maquinas.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Función para capitalizar la primera letra y la letra después de un espacio
            function capitalizeInput(input) {
                let value = input.value.toLowerCase();
                input.value = value.replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
            }

            // Almacena los valores iniciales del formulario
            const form = document.getElementById('maquinaForm');
            let initialValues = new FormData(form);

            // Asignar eventos a los campos nombre y modelo
            document.getElementById('nombre').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('modelo').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('reloadButton').addEventListener('click', function() {
                // Restaura los valores anteriores
                for (const [key, value] of initialValues.entries()) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = value; // Restaura el valor
                    }
                }
                // Reiniciar la validación de los campos
                form.classList.remove('was-validated');
            });
        </script>

    </section>

@endsection
