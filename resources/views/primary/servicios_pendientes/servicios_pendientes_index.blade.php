@extends('layouts.principal')
@section('title', 'Lista de Servicios Pendientes')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 24px; margin: 0;">Lista de Servicios Pendientes</h1>
                            <div class="button-group d-flex gap-2">
                                <a href="{{ route('servicios_pendientes.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                                    Programar Servicio
                                </a>
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
                        <div class="mb-3">
                            <label for="fecha-desde" class="form-label">Desde:</label>
                            <input type="date" id="fecha-desde" class="form-control d-inline-block w-auto">
                            <label for="fecha-hasta" class="form-label">Hasta:</label>
                            <input type="date" id="fecha-hasta" class="form-control d-inline-block w-auto">
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
                                    <th style="width: 15%;">Total</th>
                                    <th style="width: 25%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($serviciosPendientes as $servicioPendiente)
                                    <tr data-fecha="{{ \Carbon\Carbon::parse($servicioPendiente->fecha)->format('Y-m-d') }}">
                                        <td class="row-index"></td>
                                        <td><b>{{ $servicioPendiente->cliente->first_name }} {{ $servicioPendiente->cliente->last_name }}</b></td>
                                        <td>{{ $servicioPendiente->servicio->nombre }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($servicioPendiente->fecha)->locale('es')->isoFormat('LL') }}
                                            {{ \Carbon\Carbon::parse($servicioPendiente->hora)->format('h:i A') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">{{ $servicioPendiente->estado }}</span>
                                        </td>
                                        <td>L. {{ number_format($servicioPendiente->total, 2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('servicios_pendientes.edit', $servicioPendiente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="{{ route('servicios_pendientes.show', $servicioPendiente->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            <button class="btn btn-secondary btn-sm imprimir-btn" data-id="{{ $servicioPendiente->id }}" data-bs-toggle="modal" data-bs-target="#imprimirModal">Imprimir</button>
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
        </div>

        <!-- Modal de confirmación para imprimir -->
        <div class="modal fade" id="imprimirModal" tabindex="-1" aria-labelledby="imprimirModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Impresión</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de que desea imprimir la factura?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmarImpresion">Imprimir</button>
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
                        "sEmptyTable": "Ningún servicio pendiente disponible en esta tabla",
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
                let servicioId;
                $('.imprimir-btn').on('click', function() {
                    servicioId = $(this).data('id');
                });

                $('#confirmarImpresion').on('click', function() {
                    window.open(`{{ url('servicios-pendientes/factura') }}/${servicioId}`, '_blank');
                    $('#imprimirModal').modal('hide');
                });
            });
        </script>

    </section>

@endsection
