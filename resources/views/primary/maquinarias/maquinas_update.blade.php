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
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre', $maquina->nombre) }}" placeholder="Ej: lavadora ,Secadora, Plancha" maxlength="50" required>
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
                                    <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror" id="marca" value="{{ old('marca', $maquina->marca) }}" placeholder="Ej: LG " maxlength="50" required>
                                    @error('marca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                              

                            <div class="row mb-3">
                                <!-- Campo de Capacidad -->
                                <div class="col-md-6">
                                    <label for="capacidad" class="form-label">Capacidad</label>
                                    <input type="text" name="capacidad" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" value="{{ old('capacidad', $maquina->capacidad) }}" placeholder="Ej: 5 kg" maxlength="50" required>
                                    @error('capacidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Proveedor -->
                                <div class="col-md-6">
                                    <label for="proveedor" class="form-label">Proveedor</label>
                                    <input type="text" name="proveedor" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" value="{{ old('proveedor', $maquina->proveedor) }}" placeholder="Ej: Empresa XYZ" maxlength="100" required>
                                    @error('proveedor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                           

                                <!-- Campo de Estado -->
                                <div class="col-md-6">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select name="estado" class="form-select @error('estado') is-invalid @enderror" id="estado" required>
                                        <option value="">Seleccione un estado</option>
                                        <option value="Activo" {{ old('estado', $maquina->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="Inactivo" {{ old('estado', $maquina->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="En mantenimiento" {{ old('estado', $maquina->estado) == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                    </select>
                                    @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                           

                                <!-- Campo de Descripción -->
                                <div class="col-md-6">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Máquina en mantenimiento" maxlength="500" rows="3">{{ old('descripcion', $maquina->descripcion) }}</textarea>
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

            // Asignar eventos a los campos nombre, modelo, marca y proveedor
            document.getElementById('nombre').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('modelo').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('marca').addEventListener('input', function(e) {
                capitalizeInput(e.target);
            });

            document.getElementById('proveedor').addEventListener('input', function(e) {
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

       <script>
            // Función para capitalizar solo la primera letra de la primera palabra
            function capitalizeFirstLetter(input) {
                let value = input.value;
                input.value = value.charAt(0).toUpperCase() + value.slice(1);
            }

            // Función para restringir caracteres si es necesario
            function restrictInput(e) {
                let key = e.key;
                let regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s,.]*$/;

                if (!regex.test(key) && key !== 'Backspace' && key !== 'Tab' && key !== 'Enter') {
                    e.preventDefault();
                }
            }

            
        </script>

        <script>
            document.getElementById('reloadButton').addEventListener('click', function () {
                const maquinaId = "{{ $maquina->id }}"; // Obtener el ID del cliente

                // Hacer una solicitud AJAX para obtener los datos más recientes del cliente
                fetch(`/maquinas/${maquinaId}/reload`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar los valores del formulario con los datos del servidor
                        document.getElementById('nombre').value = data.nombre;
                        document.getElementById('modelo').value = data.modelo;
                        document.getElementById('capacidad').value = data.capacidad;
                        document.getElementById('marca').value = data.marca;
                        document.getElementById('proveedor').value = data.proveedor;
                        document.getElementById('estado').value = data.estado;
                        document.getElementById('descripcion').value = data.descripcion;

                    
                    });
            });
        </script>
    </section>


    </section>

@endsection