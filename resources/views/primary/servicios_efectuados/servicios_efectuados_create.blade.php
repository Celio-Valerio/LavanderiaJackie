@extends('layouts.principal')
@section('title', 'Registrar Servicio Efectuado')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Estilos personalizados para checkboxes y radio buttons */
        .custom-checkbox-wrapper,
        .custom-radio-wrapper {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: start;
            margin-bottom: 10px;
        }

        .custom-checkbox-input,
        .custom-radio-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .custom-checkbox-label,
        .custom-radio-label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        /* Estilo para checkboxes (Azul) */
        .custom-checkbox-label::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #007bff;
            border-radius: 5px;
            transform: translateY(-50%);
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Estilo para radios (Verde) */
        .custom-radio-label::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #28a745;
            border-radius: 50%;
            transform: translateY(-50%);
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .custom-radio-input:checked + .custom-radio-label::before {
            background-color: #28a745;
            border-color: #28a745;
        }

        .custom-checkbox-label::after,
        .custom-radio-label::after {
            content: '✔';
            position: absolute;
            top: 50%;
            left: 5px;
            font-size: 14px;
            color: #fff;
            opacity: 0;
            transform: translateY(-50%);
            transition: opacity 0.3s;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label::after,
        .custom-radio-input:checked + .custom-radio-label::after {
            opacity: 1;
        }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar servicio efectuado</h1>
                        <hr>

                        <!-- Formulario -->
                        <form id="servicioForm" action="{{ route('servicios_efectuados.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row">
                                <!-- Cliente -->
                                <div class="col-md-6">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <select name="cliente_id" id="cliente_id" class="form-control select2 @error('cliente_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->first_name }} {{ $cliente->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Servicio -->
                                <div class="col-md-6">
                                    <label for="servicio_id" class="form-label">Servicio</label>
                                    <select name="servicio_id" id="servicio_id" class="form-control @error('servicio_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un servicio</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>{{ $servicio->nombre }} <strong> - L. {{ $servicio->precio }}</strong></option>
                                        @endforeach
                                    </select>
                                    @error('servicio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Promoción -->
                                <div class="col-md-6">
                                    <label class="form-label">Promoción</label>
                                    <div class="d-flex align-items-center">
                                        <select name="promo_id" id="promo_id" class="form-control @error('promo_id') is-invalid @enderror me-2" {{ old('no_aplica') ? 'disabled' : '' }}>
                                            <option value="">Seleccione una promoción</option>
                                            @foreach($promos as $promo)
                                                <option value="{{ $promo->id }}" data-descuento="{{ $promo->discount }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                                    {{ $promo->name }} ({{ $promo->promo }}) <strong>{{ $promo->discount }}%</strong>
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox-input" type="checkbox" id="no_aplica" name="no_aplica" {{ old('no_aplica') ? 'checked' : '' }}>
                                            <label class="form-check-label custom-checkbox-label ms-1" for="no_aplica">Aplica</label>
                                        </div>
                                    </div>
                                    @error('promo_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Libras -->
                                <div class="col-md-3">
                                    <label for="libras" class="form-label">Libras</label>
                                    <input type="number" name="libras" id="libras" class="form-control @error('libras') is-invalid @enderror" value="{{ old('libras') }}" min="1" max="99" required>
                                    @error('libras')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Total -->
                                <div class="col-md-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="text" name="total" id="total" class="form-control" value="{{ old('total') }}" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Columna 2: Estado -->
                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check custom-radio-wrapper me-3">
                                            <input class="form-check-input custom-radio-input" type="radio" name="estado" id="estado_pendiente" value="Pendiente" {{ old('estado') == 'Pendiente' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="estado_pendiente">Pendiente</label>
                                        </div>
                                        <div class="form-check custom-radio-wrapper me-3">
                                            <input class="form-check-input custom-radio-input" type="radio" name="estado" id="estado_terminado" value="Terminado" {{ old('estado') == 'Terminado' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="estado_terminado">Terminado</label>
                                        </div>
                                        <div class="form-check custom-radio-wrapper">
                                            <input class="form-check-input custom-radio-input" type="radio" name="estado" id="estado_entregado" value="Entregado" {{ old('estado') == 'Entregado' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="estado_entregado">Entregado</label>
                                        </div>
                                    </div>
                                    @error('estado')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Columna 1: Envío -->
                                <div class="col-md-6">
                                    <!-- Fila 1 y 2: Envío -->
                                    <label class="form-label">Envio</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check custom-radio-wrapper me-3">
                                            <input class="form-check-input custom-radio-input" type="radio" name="envio" id="envio_local" value="Local" {{ old('envio') == 'Local' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_local">Local</label>
                                        </div>
                                        <div class="form-check custom-radio-wrapper">
                                            <input class="form-check-input custom-radio-input" type="radio" name="envio" id="envio_domicilio" value="A domicilio" {{ old('envio') == 'A domicilio' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_domicilio">A domicilio</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-3">

                                <!-- Columna 2: Notas -->
                                <div class="col-md-6">
                                    <!-- Fila 3 a 6: Notas -->
                                    <label for="notas" class="form-label">Notas</label>
                                    <textarea name="notas" id="notas" class="form-control @error('notas') is-invalid @enderror" rows="4" maxlength="500">{{ old('notas') }}</textarea>
                                    @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Columna 1: Dirección -->
                                <div class="col-md-6">
                                    <!-- Fila 3 a 6: Dirección -->
                                    <div id="direccionWrapper">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <textarea name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" rows="4" maxlength="500">{{ old('direccion') }}</textarea>
                                        @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3" id="envioWrapper" class="mt-2 d-none">
                                <!-- Columna 1: ¿Quién paga el envío? -->
                                <div class="col-md-6">
                                    <label class="form-label">¿Quién paga el envío?</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check custom-radio-wrapper me-3">
                                            <input class="form-check-input custom-radio-input" type="radio" name="pago_envio" id="envio_cliente" value="Cliente" {{ old('pago_envio') == 'Cliente' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_cliente">Cliente</label>
                                        </div>
                                        <div class="form-check custom-radio-wrapper">
                                            <input class="form-check-input custom-radio-input" type="radio" name="pago_envio" id="envio_empresa" value="Empresa" {{ old('pago_envio') == 'Empresa' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_empresa">Empresa</label>
                                        </div>
                                        @error('pago_envio')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Columna 2: Precio del envío -->
                                <div class="col-md-6">
                                    <!-- Fila 7 y 8: Precio del envío -->
                                    <div id="precioEnvioWrapper">
                                        <label for="precio_envio" class="form-label">Precio de Envío</label>
                                        <input type="number"
                                               name="precio_envio"
                                               id="precio_envio"
                                               class="form-control @error('precio_envio') is-invalid @enderror"
                                               value="{{ old('precio_envio', 0) }}">
                                        @error('precio_envio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Registrar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="clearButton">Limpiar</button>
                                <a href="{{ route('servicios_efectuados.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            function toggleEnvioFields() {
                if ($('#envio_domicilio').is(':checked')) {
                    $('#direccionWrapper').removeClass('d-none');
                    $('#envioWrapper').removeClass('d-none');
                } else {
                    $('#direccionWrapper').addClass('d-none');
                    $('#envioWrapper').addClass('d-none');
                    $('#precioEnvioWrapper').addClass('d-none');

                    calculateTotal(); // Recalculate total
                }
            }

            function togglePrecioEnvio() {
                if ($('#envio_empresa').is(':checked')) {
                    $('#precioEnvioWrapper').removeClass('d-none');
                } else {
                    $('#precioEnvioWrapper').addClass('d-none');
                    // Mantener el precio de envío si existe, no resetear
                    if ($('#precio_envio').val() === "") {
                        $('#precio_envio').val(0); // Reset envio price si está vacío
                    }
                    calculateTotal(); // Recalculate total
                }
            }

            // Control de "No Aplica" para la promoción
            $('#no_aplica').change(function () {
                if ($(this).prop('checked')) {
                    $('#promo_id').val('');
                    $('#promo_id').prop('disabled', true); // Deshabilitar selección
                    $('#promo_id').trigger('change');
                } else {
                    $('#promo_id').prop('disabled', false); // Habilitar si aplica
                    $('#promo_id').trigger('change');
                }
            });

            // Función para calcular el total
            function calculateTotal() {
                var precio = $('#servicio_id option:selected').data('precio') || 0;
                var libras = parseFloat($('#libras').val()) || 0;
                var total = precio * libras;
                var descuento = 0;

                if (!$('#no_aplica').prop('checked')) {
                    var descuentoPromo = $('#promo_id option:selected').data('descuento') || 0;
                    descuento = (total * descuentoPromo) / 100;
                    total -= descuento;
                }

                // Añadir precio de envío si aplica
                if ($('#envio_empresa').is(':checked')) {
                    var precioEnvio = parseFloat($('#precio_envio').val()) || 0;
                    total += precioEnvio;
                } else if ($('#envio_local').is(':checked') || $('#envio_cliente').is(':checked')) {
                    $('#precio_envio').val(0); // Set envio price to 0.00
                }

                // Validación: Si hay un error, mantener el valor del precio de envío
                if (isNaN(total)) {
                    total = parseFloat($('#total').val()) || 0; // Mantener el total previo
                }

                $('#total').val(total.toFixed(2));
            }

            // Actualizar campos de envío al cambiar opciones
            $('#envio_local, #envio_domicilio').on('change', function () {
                toggleEnvioFields();
                calculateTotal();
            });

            $('#envio_cliente, #envio_empresa').on('change', function () {
                togglePrecioEnvio();
                calculateTotal();
            });

            // Actualizar el total al cambiar valores relevantes
            $('#libras, #servicio_id, #promo_id, #precio_envio').on('input change', calculateTotal);

            // Limpiar el formulario
            $('#clearButton').on('click', function () {
                $('#servicioForm')[0].reset();
                $('#total').val('0.00');
                $('#no_aplica').prop('checked', false);
                $('#promo_id').prop('disabled', false).val('');
                $('#direccionWrapper, #envioWrapper, #precioEnvioWrapper').addClass('d-none');
            });

            // Inicializar
            toggleEnvioFields();
            togglePrecioEnvio();
        });
    </script>
@endsection
