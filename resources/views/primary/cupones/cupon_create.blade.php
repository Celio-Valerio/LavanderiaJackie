@extends('layouts.principal')
@section('title', 'Registrar Cupón')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar Cupón</h1>
                        <hr>
                        <!-- Inicio del formulario -->
                        <form id="cuponForm" action="{{ route('cupones.store') }}" method="POST" novalidate>
                            @csrf <!-- Protección contra CSRF -->

                            <div class="row mb-3">
                                <!-- Selección de Cliente -->
                                <div class="col-md-6">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <select name="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror" id="cliente_id" required>
                                        <option value="" disabled selected>Seleccione un cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" data-visitas="{{ $cliente->visitas_disponibles }}">
                                                {{ $cliente->first_name }} {{ $cliente->last_name }} - {{ $cliente->visitas_disponibles }} visitas
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Visitas Disponibles (Solo lectura) -->
                                <div class="col-md-3">
                                    <label for="visitas_disponibles" class="form-label">Puntos (visitas)</label>
                                    <input type="text" id="visitas_disponibles" class="form-control" value="0" readonly>
                                </div>

                                <!-- Campo de Cantidad (Para tipo Cantidad) -->
                                <div class="col-md-3">
                                    <label for="cantidad" class="form-label">Puntos a utilizar</label>
                                    <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" id="cantidad" value="{{ old('cantidad') }}" placeholder="Ej: 5" min="1">
                                    @error('cantidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Campo de Nombre del Cupón -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre del Cupón</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Descuento especial" maxlength="100" required>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Tipo de Cupón -->
                                <div class="col-md-3">
                                    <label for="tipo" class="form-label">Tipo de Cupón</label>
                                    <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" id="tipo" required>
                                        <option value="" disabled selected>Seleccione el tipo</option>
                                        <option value="Valor" {{ old('tipo') == 'Valor' ? 'selected' : '' }}>Valor</option>
                                        <option value="Descuento" {{ old('tipo') == 'Descuento' ? 'selected' : '' }}>Descuento</option>
                                        <option value="Cantidad" {{ old('tipo') == 'Cantidad' ? 'selected' : '' }}>Cantidad</option>
                                    </select>
                                    @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Valor del Cupón -->
                                <div class="col-md-3">
                                    <label for="valor" class="form-label" id="valorLabel">Valor del Cupón</label>
                                    <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror" id="valor" value="{{ old('valor') }}" placeholder="Ej: 100">
                                    @error('valor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Ej: Descripción del cupón." maxlength="500" rows="3">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('cliente_id').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let visitasDisponibles = selectedOption.getAttribute('data-visitas') || 0;
                document.getElementById('visitas_disponibles').value = visitasDisponibles;
            });

            document.getElementById('tipo').addEventListener('change', function() {
                let tipo = this.value;
                let valorInput = document.getElementById('valor');
                let valorLabel = document.getElementById('valorLabel');

                if (tipo === 'Valor') {
                    valorLabel.textContent = 'Valor en lempiras';
                    valorInput.placeholder = 'Ej: 1000.00';
                    valorInput.value = '';
                    valorInput.setAttribute('maxlength', '8');
                    valorInput.setAttribute('pattern', '^[0-9]+(\.[0-9]{1,2})?$');
                } else if (tipo === 'Descuento') {
                    valorLabel.textContent = 'Porcentaje';
                    valorInput.placeholder = 'Ej: 15';
                    valorInput.value = '';
                    valorInput.setAttribute('maxlength', '2');
                    valorInput.setAttribute('pattern', '^[0-9]{1,2}$');
                } else if (tipo === 'Cantidad') {
                    valorLabel.textContent = 'Cantidad de lavadas';
                    valorInput.placeholder = 'Ej: 5';
                    valorInput.value = '';
                    valorInput.setAttribute('maxlength', '3');
                    valorInput.setAttribute('pattern', '^[0-9]{1,3}$');
                }
            });

            document.getElementById('clearButton').addEventListener('click', function () {
                const form = document.getElementById('cuponForm');
                form.reset();
                document.getElementById('visitas_disponibles').value = "0";
                form.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
            });

            document.getElementById('valor').addEventListener('input', function () {
                let tipo = document.getElementById('tipo').value;
                let valor = this.value;

                if (tipo === 'Valor') {
                    this.value = valor.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').slice(0, 8);
                } else if (tipo === 'Descuento' || tipo === 'Cantidad') {
                    this.value = valor.replace(/[^0-9]/g, '').slice(0, tipo === 'Descuento' ? 2 : 3);
                }
            });
        </script>

    </section>

@endsection
