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
            const servicioPendiente = @json($servicioPendiente); // Datos del servicio pendiente

            // Función para reestablecer el formulario
            document.getElementById('reestablecerButton').addEventListener('click', function() {
                // Recargar los datos originales desde la base de datos
                document.getElementById('cliente_id').value = servicioPendiente.cliente_id;
                document.getElementById('servicio_id').value = servicioPendiente.servicio_id;
                document.getElementById('libras').value = servicioPendiente.libras;
                document.getElementById('total').value = servicioPendiente.total;
                document.getElementById('promo_id').value = servicioPendiente.promo_id;
                document.getElementById('no_aplica').checked = !servicioPendiente.promo_id;
                document.getElementById('envio_local').checked = servicioPendiente.envio === 'Local';
                document.getElementById('envio_domicilio').checked = servicioPendiente.envio === 'A domicilio';
                document.getElementById('envio_cliente').checked = servicioPendiente.pago_envio === 'Cliente';
                document.getElementById('envio_empresa').checked = servicioPendiente.pago_envio === 'Empresa';
                document.getElementById('notas').value = servicioPendiente.notas;
                document.getElementById('direccion').value = servicioPendiente.direccion;
                document.getElementById('precio_envio').value = servicioPendiente.pago_envio === 'Empresa' ? servicioPendiente.precio_envio : '';

                // Actualizar campos dinámicos
                toggleEnvioFields();
                togglePrecioEnvio();
                calculateTotal();
            });

            // Resto del código JavaScript (igual que en el formulario de creación)
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const promoSelect = document.getElementById('promo_id');
            const librasInput = document.getElementById('libras');
            const form = document.getElementById('servicioForm');

            // Guardar la promoción inicial seleccionada
            const initialPromo = promoSelect.value;

            librasInput.addEventListener('input', (event) => {
                let value = event.target.value.replace(/\D/g, '');
                value = value.substring(0, 3);
                event.target.value = value;
            });

            function obtenerNombreDia() {
                const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                const hoy = new Date();
                return dias[hoy.getDay()];
            }

            function verificarDiaPromocion(promo) {
                const diasPromocion = JSON.parse(promo.dataset.dias);
                const diaActual = obtenerNombreDia();

                document.getElementById('diasPromocion').innerText = diasPromocion.join(', ');
                document.getElementById('diaActual').innerText = diaActual;

                return diasPromocion.includes(diaActual);
            }

            function verificarLibrasEnRango(promo) {
                const libras = parseInt(librasInput.value);
                const desde = parseInt(promo.dataset.desde);
                const hasta = parseInt(promo.dataset.hasta);

                document.getElementById('rangoLibrasDesde').innerText = desde;
                document.getElementById('rangoLibrasHasta').innerText = hasta;
                document.getElementById('librasIngresadas').innerText = libras;

                return libras >= desde && libras <= hasta;
            }

            function mostrarAdvertenciaDia(promo) {
                if (!verificarDiaPromocion(promo)) {
                    document.getElementById('mensajeDia').classList.remove('d-none');
                    return true; // Mostrar advertencia
                } else {
                    document.getElementById('mensajeDia').classList.add('d-none');
                    return false; // No mostrar advertencia
                }
            }

            function mostrarAdvertenciaLibras(promo) {
                if (!verificarLibrasEnRango(promo)) {
                    document.getElementById('mensajeLibras').classList.remove('d-none');
                    return true; // Mostrar advertencia
                } else {
                    document.getElementById('mensajeLibras').classList.add('d-none');
                    return false; // No mostrar advertencia
                }
            }

            promoSelect.addEventListener('change', function() {
                const promo = promoSelect.options[promoSelect.selectedIndex];

                // Solo validar si la promoción ha cambiado
                if (promoSelect.value !== initialPromo) {
                    let mostrarModal = false;

                    if (mostrarAdvertenciaLibras(promo)) {
                        mostrarModal = true;
                    }

                    if (mostrarAdvertenciaDia(promo)) {
                        mostrarModal = true;
                    }

                    if (mostrarModal) {
                        $('#modalAdvertencia').modal('show');
                    } else {
                        $('#modalAdvertencia').modal('hide');
                    }
                } else {
                    // Si no ha cambiado, solo mostrar advertencia de día si es necesario
                    if (mostrarAdvertenciaDia(promo)) {
                        $('#modalAdvertencia').modal('show');
                    } else {
                        $('#modalAdvertencia').modal('hide');
                    }
                }
            });

            form.addEventListener('submit', function(e) {
                const promo = promoSelect.options[promoSelect.selectedIndex];

                // Solo validar si la promoción ha cambiado
                if (promoSelect.value !== initialPromo) {
                    if (!verificarDiaPromocion(promo) || !verificarLibrasEnRango(promo)) {
                        e.preventDefault();
                        $('#modalAdvertencia').modal('show');
                    }
                }
            });
        });

    </script>

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
                        $('#precio_envio').val(''); // Reset envio price si está vacío
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
                    $('#precio_envio').val(''); // Set envio price to 0.00
                }

                // Validación: Si hay un error, mantener el valor del precio de envío
                if (isNaN(total)) {
                    total = parseFloat($('#total').val()) || 0; // Mantener el total previo
                }

                // Formatear el total con comas para miles y punto para decimales
                var totalFormateado = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                // Asignar el total formateado
                $('#total').val(totalFormateado);
            }

            // Actualizar campos de envío al cambiar opciones
            $('#envio_local, #envio_domicilio').on('change', function () {
                toggleEnvioFields();
                calculateTotal();

                // Si se selecciona "Envío: Local", quitar la selección de "¿Quién paga el envío?"
                if ($('#envio_local').is(':checked')) {
                    $('#envio_cliente, #envio_empresa').prop('checked', false); // Desmarcar ambos
                }
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
                $('#libras').val('');
                $('#total').val('');
                $('#direccion').val('');
                $('#no_aplica').prop('checked', false);
                $('#envio_local').prop('checked', false);
                $('#envio_domicilio').prop('checked', false);
                $('#servicio_id').prop('disabled', false).val('');
                $('#promo_id').prop('disabled', false).val('');
                $('#direccionWrapper, #envioWrapper, #precioEnvioWrapper').addClass('d-none');
            });

            // Inicializar
            toggleEnvioFields();
            togglePrecioEnvio();
        });
    </script>

    <script>
        // Limitar la entrada a un máximo de 5 dígitos
        function limitInputToFiveDigits(input) {
            const maxDigits = 5;

            // Eliminar valores no numéricos (seguridad adicional)
            input.value = input.value.replace(/\D/g, '');

            // Si la longitud excede el máximo, cortar la entrada
            if (input.value.length > maxDigits) {
                input.value = input.value.slice(0, maxDigits);
            }

            // Asegurarse de que no supere el valor máximo permitido
            const maxValue = 999;
            if (parseInt(input.value, 10) > maxValue) {
                input.value = maxValue;
            }
        }
    </script>
    <!-- Resto del código JavaScript (igual que en el formulario de creación) -->
@endsection
