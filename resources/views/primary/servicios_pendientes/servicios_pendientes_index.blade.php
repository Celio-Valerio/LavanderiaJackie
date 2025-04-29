@extends('layouts.principal')
@section('title', 'Lista de Servicios Pendientes')
@section('content')
    <div class="row">
        @if($usuario->rolpermiso->serviciospendientes_lista == 1)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de servicios pendientes</h1>
                            <div class="button-group d-flex gap-2">
                                <a href="{{ route('servicios_efectuados.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px">Programar Servicio</a>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <hr>

                        <!-- Filtros de fechas -->
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <label for="fecha-desde" class="form-label">Buscar desde</label>
                            <input type="date" id="fecha-desde" class="form-control d-inline-block w-auto">
                            <label for="fecha-hasta" class="form-label">hasta</label>
                            <input type="date" id="fecha-hasta" class="form-control d-inline-block w-auto">

                            <!-- Botón de recargar -->
                            <button id="reload-button" class="btn btn-link p-0" style="color: #007bff; font-size: 24px; margin-top: 5px;">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="serviciosPendientesTable" class="table table-striped table-bordered small-text" style="padding-top: 20px; padding-bottom: 10px">
                                <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 15%;">Cliente</th>
                                    <th style="width: 15%;">Servicio</th>
                                    <th style="width: 15%;">Fecha y hora</th>
                                    <th style="width: 10%;">Estado</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 20%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($serviciosEfectuados as $servicioEfectuado)
                                    <tr data-fecha="{{ \Carbon\Carbon::parse($servicioEfectuado->fecha)->format('Y-m-d') }}">
                                        <td class="row-index small-text-field"></td>
                                        <td class="small-text-field"><b>{{ $servicioEfectuado->cliente->first_name }} {{ $servicioEfectuado->cliente->last_name }}</b></td>
                                        <td class="small-text-field">{{ $servicioEfectuado->servicio->nombre }}</td>
                                        <td class="small-text-field">
                                            {{ \Carbon\Carbon::parse($servicioEfectuado->fecha)->locale('es')->isoFormat('LL') }} <!-- Fecha en español -->
                                            {{ \Carbon\Carbon::parse($servicioEfectuado->hora)->format('h:i A') }} <!-- Hora en formato 12 horas -->
                                        </td>
                                        <td class="small-text-field">
                                            <span class="badge {{ $servicioEfectuado->estado == 'Terminado' ? 'bg-warning' : ($servicioEfectuado->estado == 'Entregado' ? 'bg-success' : 'bg-danger') }}">{{ $servicioEfectuado->estado }}</span>
                                        </td>

                                        <td class="small-text-field">L. {{ number_format($servicioEfectuado->total, 2) }}</td>
                                        <td class="text-center small-text-field">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('servicios_pendientes.edit', $servicioEfectuado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                <button class="btn btn-secondary btn-sm imprimir-btn" data-id="{{ $servicioEfectuado->id }}" data-bs-toggle="modal" data-bs-target="#imprimirModal">Imprimir</button>
                                                <a href="{{ route('servicios_pendientes.show', $servicioEfectuado->id) }}" class="btn btn-info btn-sm">Ver</a>
                                                @if($servicioEfectuado->estado == 'Pendiente')
                                                    <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{$servicioEfectuado->id}}">
                                                        Terminar
                                                    </button>
                                                    <div class="modal fade" id="modal{{$servicioEfectuado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación de Notificación al Cliente</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    El cliente será notificado por correo de que su servicio ha sido terminado. ¿Desea continuar?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('actualizarEstado', ['id' => $servicioEfectuado->id]) }}" method="post" style="display: inline-block; width: 20%; ">
                                                                        @csrf
                                                                        <input type="submit" value="Si" class="btn btn-primary w-100">
                                                                    </form>
                                                                    <button type="button" class="btn btn-danger w-20" data-bs-dismiss="modal">Cancelar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay servicios pendientes registrados</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

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

        <!-- Modal de confirmación para imprimir -->
        <div class="modal fade" id="imprimirModal" tabindex="-1" aria-labelledby="imprimirModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Impresión</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Desea imprimir la factura?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-lg" id="confirmarImpresion">Sí</button>
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var table = $('#serviciosPendientesTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ servicios pendientes",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún servicio efectuado disponible en esta tabla",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ servicios pendientes",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ servicios pendientes)",
                        "sSearch": "",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        }
                    },
                    "columnDefs": [{
                        "targets": 0,
                        "orderable": false
                    }],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = 1;
                        api.rows({ search: 'applied' }).every(function(rowIdx) {
                            $(this.node()).find('td.row-index').html(startIndex++);
                        });
                    },
                    "responsive": true
                });

                function filterByDate() {
                    var fechaDesde = $('#fecha-desde').val();
                    var fechaHasta = $('#fecha-hasta').val();
                    table.draw();
                }

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var fechaDesde = $('#fecha-desde').val();
                        var fechaHasta = $('#fecha-hasta').val();
                        var fechaServicio = $(table.row(dataIndex).node()).data('fecha');

                        if (!fechaDesde || !fechaHasta) {
                            return true;
                        }

                        return fechaServicio >= fechaDesde && fechaServicio <= fechaHasta;
                    }
                );

                $('#fecha-desde, #fecha-hasta').change(filterByDate);

                $('#serviciosPendientesTable_length').addClass('text-end').css('float', 'right');
                $('#serviciosPendientesTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#serviciosPendientesTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#serviciosPendientesTable_filter input').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
                });

                // Funcionalidad de impresión
                let servicioId = null; // Inicializa la variable

                // Captura el ID del servicio al hacer clic en el botón de imprimir
                $(document).on('click', '.imprimir-btn', function() {
                    servicioId = $(this).data('id'); // Obtiene el ID del servicio
                    console.log("Servicio ID seleccionado: ", servicioId); // Depuración
                });

                $('#confirmarImpresion').on('click', function() {
                    if (servicioId) { // Verifica que el ID no sea undefined
                        window.open(`{{ url('servicios-pendientes/factura') }}/${servicioId}`, '_blank');
                        $('#imprimirModal').modal('hide');
                    } else {
                        alert('Error: No se pudo obtener el ID del servicio. Inténtelo de nuevo.');
                    }
                });

                // Botón de recargar
                $('#reload-button').on('click', function() {
                    $('#fecha-desde').val('');
                    $('#fecha-hasta').val('');
                    table.search('').draw(); // Limpiar búsqueda y recargar tabla
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const alert = document.getElementById('success-message');
                if (alert) {
                    setTimeout(() => {
                        alert.classList.remove('show');
                        alert.style.display = 'none';
                    }, 5000);
                }
            });
        </script>

@endsection
