@extends('layouts.principal')
@section('title', 'Editar Servicio Efectuado')
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
                        <h1 class="card-title" style="font-size: 30px !important;">Editar servicio efectuado</h1>
                        <hr>

                        <!-- Formulario -->
                        <form id="servicioForm" action="{{ route('servicios_efectuados.update', $servicioPendiente->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Cliente -->
                                <div class="col-md-6">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <div class="d-flex align-items-start">
                                        <!-- Select de cliente -->
                                        <select name="cliente_id" id="cliente_id" class="form-control select2 @error('cliente_id') is-invalid @enderror" required>
                                            <option value="">Seleccione un cliente</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ $servicioPendiente->cliente_id == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->first_name }} {{ $cliente->last_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Botón para agregar cliente -->
                                        <a href="{{ route('clientes.create') }}" class="btn btn-primary ms-2" title="Agregar nuevo cliente">
                                            <i class="bi bi-plus-circle"></i>
                                        </a>
                                    </div>
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
                                            <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" {{ $servicioPendiente->servicio_id == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre }} <strong> - L. {{ $servicio->precio }}</strong>
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('servicio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Libras y Total -->
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="libras" class="form-label">Libras</label>
                                    <input type="number" name="libras" id="libras" class="form-control @error('libras') is-invalid @enderror" value="{{ $servicioPendiente->libras }}" maxlength="5" required>
                                    @error('libras')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="text" name="total" id="total" class="form-control" value="{{ $servicioPendiente->total }}" readonly>
                                </div>

                                <!-- Promoción -->
                                <div class="col-md-6">
                                    <label class="form-label">Promoción</label>
                                    <div class="d-flex align-items-center">
                                        <select name="promo_id" id="promo_id" class="form-control @error('promo_id') is-invalid @enderror me-2" {{ $servicioPendiente->promo_id ? '' : 'disabled' }}>
                                            <option value="">Seleccione una promoción</option>
                                            @foreach($promos as $promo)
                                                @php
                                                    $diasPromo = json_decode($promo->days);
                                                    $diasAbreviados = implode(', ', array_map(function($dia) {
                                                        return substr($dia, 0, 1);
                                                    }, $diasPromo));
                                                @endphp
                                                <option value="{{ $promo->id }}"
                                                        data-descuento="{{ $promo->discount }}"
                                                        data-dias="{{ json_encode($diasPromo) }}"
                                                        data-desde="{{ $promo->desde }}"
                                                        data-hasta="{{ $promo->hasta }}"
                                                    {{ $servicioPendiente->promo_id == $promo->id ? 'selected' : '' }}>
                                                    {{ $promo->name }} ({{ $promo->desde }} lbs -{{ $promo->hasta }} lbs
                                                    {{ $diasAbreviados }})
                                                    <strong>{{ $promo->discount }}%</strong>
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox-input" type="checkbox" id="no_aplica" name="no_aplica" {{ $servicioPendiente->promo_id ? '' : 'checked' }}>
                                            <label class="form-check-label custom-checkbox-label ms-1" for="no_aplica"></label>
                                        </div>
                                    </div>
                                    @error('promo_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Envío -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Envio</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check custom-radio-wrapper me-3">
                                            <input class="form-check-input custom-radio-input" type="radio" name="envio" id="envio_local" value="Local" {{ $servicioPendiente->envio == 'Local' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_local">Local</label>
                                        </div>
                                        <div class="form-check custom-radio-wrapper">
                                            <input class="form-check-input custom-radio-input" type="radio" name="envio" id="envio_domicilio" value="A domicilio" {{ $servicioPendiente->envio == 'A domicilio' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_domicilio">A domicilio</label>
                                        </div>
                                    </div>
                                    @error('envio')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="envioWrapper" class="mt-2 {{ $servicioPendiente->envio == 'A domicilio' ? '' : 'd-none' }}">
                                    <label class="form-label">¿Quién paga el envío?</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check custom-radio-wrapper me-3">
                                            <input class="form-check-input custom-radio-input" type="radio" name="pago_envio" id="envio_cliente" value="Cliente" {{ $servicioPendiente->pago_envio == 'Cliente' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_cliente">Cliente</label>
                                        </div>
                                        <div class="form-check custom-radio-wrapper">
                                            <input class="form-check-input custom-radio-input" type="radio" name="pago_envio" id="envio_empresa" value="Empresa" {{ $servicioPendiente->pago_envio == 'Empresa' ? 'checked' : '' }}>
                                            <label class="form-check-label custom-radio-label" for="envio_empresa">Empresa</label>
                                        </div>
                                        @error('pago_envio')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Notas y Dirección -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="notas" class="form-label">Notas</label>
                                    <textarea name="notas" id="notas" class="form-control @error('notas') is-invalid @enderror" rows="4" maxlength="500">{{ $servicioPendiente->notas }}</textarea>
                                    @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div id="direccionWrapper" class="{{ $servicioPendiente->envio == 'A domicilio' ? '' : 'd-none' }}">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <textarea name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" rows="4" maxlength="500">{{ $servicioPendiente->direccion }}</textarea>
                                        @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Precio del Envío -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div id="precioEnvioWrapper" class="{{ $servicioPendiente->pago_envio == 'Empresa' ? '' : 'd-none' }}">
                                        <label for="precio_envio" class="form-label">Precio de Envío</label>
                                        <input type="number" name="precio_envio" id="precio_envio" class="form-control @error('precio_envio') is-invalid @enderror" value="{{ $servicioPendiente->precio_envio }}" oninput="limitInputToFiveDigits(this)">
                                        @error('precio_envio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-primary flex-fill me-1">Actualizar</button>
                                <button type="button" class="btn btn-warning flex-fill me-1" id="reestablecerButton">Reestablecer</button>
                                <a href="{{ route('servicios_pendientes.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de advertencia -->
    <div class="modal fade" id="modalAdvertencia" tabindex="-1" aria-labelledby="modalAdvertenciaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdvertenciaLabel">Advertencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="mensajeLibras" class="d-none">
                        <p>La cantidad de libras que ingresaste (<strong><span id="librasIngresadas"></span> lbs</strong>) no está dentro del rango permitido para esta promoción. El rango de libras permitido para esta promoción es de <strong><span id="rangoLibrasDesde"></span> lbs a <span id="rangoLibrasHasta"></span> lbs</strong>.</p>
                        <p>Por favor, ajusta la cantidad de libras dentro de este rango para poder aplicar la promoción.</p>
                    </div>

                    <div id="mensajeDia" class="d-none">
                        <hr>
                        <p>La promoción seleccionada no es válida para el día de hoy (<strong><span id="diaActual"></span></strong>). Los días en los que esta promoción es válida son: <strong><span id="diasPromocion"></span></strong>.</p>
                        <p>Por favor, elige un día en que la promoción sea válida.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos originales del servidor
            const initialData = @json($servicioPendiente);

            // Elementos clave del formulario
            const form = document.getElementById('servicioForm');
            const resetButton = document.getElementById('reestablecerButton');
            const envioRadios = document.querySelectorAll('input[name="envio"]');
            const pagoEnvioRadios = document.querySelectorAll('input[name="pago_envio"]');

            // Configuración inicial
            initializeForm();

            /* EVENT LISTENERS PRINCIPALES */
            // Reestablecer formulario
            resetButton.addEventListener('click', resetFormToInitialState);

            // Cambios en envío
            envioRadios.forEach(radio => {
                radio.addEventListener('change', handleEnvioChange);
            });

            // Cambios en pago de envío
            pagoEnvioRadios.forEach(radio => {
                radio.addEventListener('change', handlePagoEnvioChange);
            });

            // Cambios en campos relacionados con el cálculo
            document.getElementById('libras').addEventListener('input', calculateTotal);
            document.getElementById('servicio_id').addEventListener('change', calculateTotal);
            document.getElementById('promo_id').addEventListener('change', calculateTotal);
            document.getElementById('no_aplica').addEventListener('change', togglePromocion);
            document.getElementById('precio_envio').addEventListener('input', calculateTotal);

            /* FUNCIONES PRINCIPALES */
            function initializeForm() {
                // Cargar estado inicial de promoción
                togglePromocion();

                // Configurar visibilidad inicial
                handleEnvioChange();
                handlePagoEnvioChange();

                // Calcular total inicial
                calculateTotal();
            }

            function resetFormToInitialState() {
                // Restaurar valores desde el servidor
                document.getElementById('cliente_id').value = initialData.cliente_id;
                document.getElementById('servicio_id').value = initialData.servicio_id;
                document.getElementById('libras').value = initialData.libras;
                document.getElementById('total').value = initialData.total;
                document.getElementById('promo_id').value = initialData.promo_id;
                document.getElementById('no_aplica').checked = !initialData.promo_id;
                document.querySelector(`input[name="envio"][value="${initialData.envio}"]`).checked = true;
                document.querySelector(`input[name="pago_envio"][value="${initialData.pago_envio}"]`).checked = true;
                document.getElementById('notas').value = initialData.notas;
                document.getElementById('direccion').value = initialData.direccion;
                document.getElementById('precio_envio').value = initialData.precio_envio;

                // Restaurar estados visuales
                togglePromocion();
                handleEnvioChange();
                handlePagoEnvioChange();
                calculateTotal();
            }

            function handleEnvioChange() {
                const isDomicilio = document.getElementById('envio_domicilio').checked;

                // Mostrar/ocultar secciones
                document.getElementById('direccionWrapper').classList.toggle('d-none', !isDomicilio);
                document.getElementById('envioWrapper').classList.toggle('d-none', !isDomicilio);

                // Limpiar campos si se ocultan
                if (!isDomicilio) {
                    document.getElementById('direccion').value = '';
                    document.querySelectorAll('input[name="pago_envio"]').forEach(radio => radio.checked = false);
                    document.getElementById('precio_envio').value = '';
                    document.getElementById('precioEnvioWrapper').classList.add('d-none');
                }

                calculateTotal();
            }

            function handlePagoEnvioChange() {
                const isEmpresa = document.getElementById('envio_empresa').checked;
                document.getElementById('precioEnvioWrapper').classList.toggle('d-none', !isEmpresa);

                // Limpiar precio si se oculta
                if (!isEmpresa) document.getElementById('precio_envio').value = '';

                calculateTotal();
            }

            function togglePromocion() {
                const noAplica = document.getElementById('no_aplica').checked;
                document.getElementById('promo_id').disabled = noAplica;

                if (noAplica) {
                    document.getElementById('promo_id').value = '';
                }

                calculateTotal();
            }

            function calculateTotal() {
                const precio = parseFloat(document.getElementById('servicio_id').selectedOptions[0]?.dataset.precio) || 0;
                const libras = parseFloat(document.getElementById('libras').value) || 0;
                const descuento = parseFloat(document.getElementById('promo_id').selectedOptions[0]?.dataset.descuento) || 0;
                const precioEnvio = parseFloat(document.getElementById('precio_envio').value) || 0;

                let total = precio * libras;

                // Aplicar descuento si hay promoción
                if (!document.getElementById('no_aplica').checked && descuento > 0) {
                    total -= total * (descuento / 100);
                }

                // Agregar envío si corresponde
                if (document.getElementById('envio_empresa').checked) {
                    total += precioEnvio;
                }

                // Formatear y actualizar total
                document.getElementById('total').value = total.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });
    </script>
@endsection
