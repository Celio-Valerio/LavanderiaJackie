@extends('layouts.principal')
@section('title', 'Lista de Servicios Efectuados')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de servicios efectuados</h1>
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
                        <div class="mb-3">
                            <label for="fecha-desde" class="form-label">Desde:</label>
                            <input type="date" id="fecha-desde" class="form-control" style="display: inline-block; width: auto;">
                            <label for="fecha-hasta" class="form-label">Hasta:</label>
                            <input type="date" id="fecha-hasta" class="form-control" style="display: inline-block; width: auto;">
                        </div>

                        <table id="serviciosEfectuadosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                            <br>
                            <thead class="table table-bordered table-dark">
                            <tr>
                                <th style="width: 5%;">N°</th>
                                <th style="width: 15%;">Cliente</th>
                                <th style="width: 20%;">Servicio</th>
                                <th style="width: 15%;">Fecha y hora</th>
                                <th style="width: 10%;">Estado</th>
                                <th style="width: 10%;">Total</th>
                                <th style="width: 25%;">Acciones</th>
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
                                        @if($servicioEfectuado->estado == 'Pendiente')
                                            <span class="badge bg-danger">{{ $servicioEfectuado->estado }}</span>
                                        @elseif($servicioEfectuado->estado == 'Entregado')
                                            <span class="badge bg-primary">{{ $servicioEfectuado->estado }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $servicioEfectuado->estado }}</span>
                                        @endif
                                    </td>

                                    <td class="small-text-field">L. {{ number_format($servicioEfectuado->total, 2) }}</td>
                                    <td class="text-center small-text-field">
                                        <a href="{{ route('servicios_efectuados.edit', $servicioEfectuado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="{{ route('servicios_efectuados.show', $servicioEfectuado->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('servicios_efectuados.factura', $servicioEfectuado->id) }}" class="btn btn-success btn-sm">Factura</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay servicios efectuados registrados</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

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
                        "sLengthMenu": "Mostrar _MENU_ servicios efectuados",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún servicio efectuado disponible en esta tabla",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ servicios efectuados",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ servicios efectuados)",
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
                    "responsive": true // Hacer la tabla responsiva
                });

                // Filtro de fechas con valores predeterminados
                var fechaInicial = '2025-01-01';
                var fechaFinal = new Date().toISOString().split('T')[0]; // Fecha actual en formato YYYY-MM-DD
                $('#fecha-desde').val(fechaInicial);
                $('#fecha-hasta').val(fechaFinal);

                $('#fecha-desde, #fecha-hasta').change(function() {
                    var fechaDesde = $('#fecha-desde').val();
                    var fechaHasta = $('#fecha-hasta').val();

                    table.rows().every(function() {
                        var row = this.node();
                        var fechaServicio = $(row).data('fecha');

                        if (fechaDesde && fechaHasta) {
                            if (fechaServicio >= fechaDesde && fechaServicio <= fechaHasta) {
                                $(row).show();
                            } else {
                                $(row).hide();
                            }
                        } else {
                            $(row).show(); // Si no se aplica filtro, mostrar todas las filas
                        }
                    });
                });

                $('#serviciosEfectuadosTable_length').addClass('text-end').css('float', 'right');
                $('#serviciosEfectuadosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#serviciosEfectuadosTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#serviciosEfectuadosTable_filter input').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
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
    </section>
@endsection


