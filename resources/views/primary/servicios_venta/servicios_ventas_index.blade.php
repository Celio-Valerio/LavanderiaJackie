@extends('layouts.principal')
@section('title', 'Lista de Servicios Vendidos')
@section('content')

    <section class="section">
        <div class="row"></div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de servicios vendidos</h1>
                        <div class="button-group d-flex gap-2">
                            <a href="{{ route('servicios_efectuados.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px">Programar Servicio</a>
                            <button id="reload-button" class="btn btn-primary d-inline-block w-auto" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
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
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <label for="fecha-desde" class="form-label">Buscar desde</label>
                            <input type="date" id="fecha-desde" class="form-control d-inline-block" style="width: auto;">
                            <label for="fecha-hasta" class="form-label">hasta</label>
                            <input type="date" id="fecha-hasta" class="form-control d-inline-block" style="width: auto;">
                        </div>
                        <div>
                            <h4>Total: <strong><span id="totalServicios">L. 0.00</span></strong></h4>
                        </div>
                    </div>

                    <table id="serviciosEfectuadosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                        <thead class="table table-bordered table-dark">
                        <tr>
                            <th style="width: 5%;">N°</th>
                            <th style="width: 20%;">Cliente</th>
                            <th style="width: 25%;">Fecha</th>
                            <th style="width: 10%;">Estado</th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 15%;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($serviciosEfectuados as $servicioEfectuado)
                            @if($servicioEfectuado->estado != 'Pendiente')
                                <tr data-fecha="{{ \Carbon\Carbon::parse($servicioEfectuado->fecha)->format('Y-m-d') }}">
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field"><b>{{ $servicioEfectuado->cliente->first_name }} {{ $servicioEfectuado->cliente->last_name }}</b></td>
                                    <td class="small-text-field">
                                        {{ \Carbon\Carbon::parse($servicioEfectuado->fecha)->locale('es')->isoFormat('LL') }} <!-- Fecha en español -->
                                        {{ \Carbon\Carbon::parse($servicioEfectuado->hora)->format('h:i A') }} <!-- Hora en formato 12 horas -->
                                    </td>
                                    <td class="small-text-field">
                                        @if($servicioEfectuado->estado == 'Pendiente')
                                            <span class="badge bg-danger">{{ $servicioEfectuado->estado }}</span>
                                        @elseif($servicioEfectuado->estado == 'Entregado')
                                            <span class="badge bg-success">{{ $servicioEfectuado->estado }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ $servicioEfectuado->estado }}</span>
                                        @endif
                                    </td>

                                    <td class="small-text-field">L. {{ number_format($servicioEfectuado->total, 2) }}</td>
                                    <td class="text-center small-text-field">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-secondary btn-sm imprimir-btn" data-id="{{ $servicioEfectuado->id }}" data-bs-toggle="modal" data-bs-target="#imprimirModal">Imprimir</button>

                                            <a href="{{ route('servicios_efectuados.edit', $servicioEfectuado->id) }}" class="btn btn-warning btn-sm">Editar</a>

                                            <a href="{{ route('servicios_efectuados.show', $servicioEfectuado->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            @if($servicioEfectuado->estado == 'Terminado')
                                                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{$servicioEfectuado->id}}">
                                                    Entregar
                                                </button>
                                                <div class="modal fade" id="modal{{$servicioEfectuado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación de Entrega</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Se procederá con la confirmación de entrega. ¿Desea continuar?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('actualizarEstadoE', ['id' => $servicioEfectuado->id]) }}" method="post" style="display: inline-block;">
                                                                    @csrf
                                                                    <input type="submit" value="Terminado" class="btn btn-primary">
                                                                </form>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay servicios efectuados registrados</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

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
                        <button type="button" class="btn btn-primary" id="confirmarImpresion">Sí</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var table = $('#serviciosEfectuadosTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ servicios vendidos",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún servicio efectuado disponible en esta tabla",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ servicios vendidos",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ servicios vendidos)",
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

                        // Calcular el total
                        var total = 0;
                        api.rows({ search: 'applied' }).every(function() {
                            var data = this.data();
                            var totalServicio = parseFloat(data[4].replace('L. ', '').replace(',', ''));
                            total += totalServicio;
                        });

                        // Actualizar el elemento HTML con el total
                        $('#totalServicios').text('L. ' + total.toFixed(2));
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

                $('#serviciosEfectuadosTable_length').addClass('text-end').css('float', 'right');
                $('#serviciosEfectuadosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#serviciosEfectuadosTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#serviciosEfectuadosTable_filter input').css({
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
                    window.open(`{{ url('servicios-efectuados/factura') }}/${servicioId}`, '_blank');
                    $('#imprimirModal').modal('hide');
                });

                // Botón de recarga
                $('#reload-button').on('click', function() {
                    location.reload();
                });

                // Inicializar filtros de fechas
                const today = new Date();
                const desde = new Date(today);
                desde.setDate(today.getDate() - 25);
                const hasta = new Date(today);
                hasta.setDate(today.getDate() + 25);

                $('#fecha-desde').val(desde.toISOString().split('T')[0]);
                $('#fecha-hasta').val(hasta.toISOString().split('T')[0]);
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
    </section>
@endsection
