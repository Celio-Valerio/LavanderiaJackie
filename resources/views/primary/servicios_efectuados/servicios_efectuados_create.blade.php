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
                        <h1 class="card-title" style="font-size: 30px !important;">Registrar Servicio Efectuado</h1>
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
                                    <select name="promo_id" id="promo_id" class="form-control @error('promo_id') is-invalid @enderror">
                                        <option value="">Seleccione una promoción</option>
                                        @foreach($promos as $promo)
                                            <option value="{{ $promo->id }}" data-descuento="{{ $promo->discount }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                                {{ $promo->name }} ({{ $promo->promo }}) <strong>{{ $promo->discount }}%</strong>
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input custom-checkbox-input" type="checkbox" id="no_aplica" name="no_aplica" {{ old('no_aplica') ? 'checked' : '' }}>
                                        <label class="form-check-label custom-checkbox-label" for="no_aplica">No Aplica</label>
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
                                    <input type="text" name="total" id="total" class="form-control" value="0.00" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Notas -->
                                <div class="col-md-12">
                                    <label for="notas" class="form-label">Notas</label>
                                    <textarea name="notas" id="notas" class="form-control @error('notas') is-invalid @enderror" rows="3" maxlength="500">{{ old('notas') }}</textarea>
                                    @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Estado -->
                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <div class="form-check custom-radio-wrapper">
                                        <input class="form-check-input custom-radio-input" type="radio" name="estado" id="estado_pendiente" value="Pendiente" {{ old('estado') == 'Pendiente' ? 'checked' : '' }}>
                                        <label class="form-check-label custom-radio-label" for="estado_pendiente">Pendiente</label>
                                    </div>
                                    <div class="form-check custom-radio-wrapper">
                                        <input class="form-check-input custom-radio-input" type="radio" name="estado" id="estado_terminado" value="Terminado" {{ old('estado') == 'Terminado' ? 'checked' : '' }}>
                                        <label class="form-check-label custom-radio-label" for="estado_terminado">Terminado</label>
                                    </div>
                                    <div class="form-check custom-radio-wrapper">
                                        <input class="form-check-input custom-radio-input" type="radio" name="estado" id="estado_entregado" value="Entregado" {{ old('estado') == 'Entregado' ? 'checked' : '' }}>
                                        <label class="form-check-label custom-radio-label" for="estado_entregado">Entregado</label>
                                    </div>
                                    @error('estado')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Envio -->
                                <div class="col-md-6">
                                    <label class="form-label">Envio</label>
                                    <div class="form-check custom-radio-wrapper">
                                        <input class="form-check-input custom-radio-input" type="radio" name="envio" id="envio_local" value="Local" {{ old('envio') == 'Local' ? 'checked' : '' }}>
                                        <label class="form-check-label custom-radio-label" for="envio_local">Local</label>
                                    </div>
                                    <div class="form-check custom-radio-wrapper">
                                        <input class="form-check-input custom-radio-input" type="radio" name="envio" id="envio_domicilio" value="A domicilio" {{ old('envio') == 'Envio a domicilio' ? 'checked' : '' }}>
                                        <label class="form-check-label custom-radio-label" for="envio_domicilio">A Domicilio</label>
                                    </div>
                                    @error('envio')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
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
            // Control de "No Aplica" para la promoción
            $('#no_aplica').change(function () {
                if ($(this).prop('checked')) {
                    $('#promo_id').val(''); // Restablecer a "Seleccione una promoción"
                    $('#promo_id').prop('disabled', true); // Desactivar el select
                    $('#promo_id').trigger('change'); // Actualizar el total sin descuento
                } else {
                    $('#promo_id').prop('disabled', false); // Activar el select
                    $('#promo_id').trigger('change'); // Volver a calcular el total
                }
            });

            // Calcular el total cuando cambian las libras, el servicio o la promoción
            $('#libras, #servicio_id, #promo_id').on('input change', function () {
                var precio = $('#servicio_id option:selected').data('precio');
                var libras = $('#libras').val();
                var total = 0;
                var descuento = 0;

                // Verificar si hay precio y libras
                if (precio && libras) {
                    total = precio * libras; // Calcular total base
                }

                // Verificar si la promoción está habilitada y hay una seleccionada
                if (!$('#no_aplica').prop('checked')) {
                    var promoId = $('#promo_id').val();
                    if (promoId) {
                        var descuentoPromo = $('#promo_id option:selected').data('descuento');
                        if (descuentoPromo) {
                            descuento = (total * descuentoPromo) / 100; // Calcular descuento
                            total = total - descuento; // Restar el descuento al total
                        }
                    }
                }

                // Mostrar el total con descuento aplicado (si corresponde)
                $('#total').val(total.toFixed(2)); // Mostrar el total final
            });

            // Limpiar el formulario
            $('#clearButton').on('click', function () {
                $('#servicioForm')[0].reset();  // Restablecer el formulario
                $('#total').val('0.00');  // Restablecer el total

                // Desmarcar el checkbox y habilitar el select de promociones
                $('#no_aplica').prop('checked', false);  // Desmarcar "No Aplica"
                $('#promo_id').prop('disabled', false);  // Habilitar el select de promociones

                // Restablecer el select de promociones a la opción por defecto
                $('#promo_id').val('');
            });
        });
    </script>
@endsection
