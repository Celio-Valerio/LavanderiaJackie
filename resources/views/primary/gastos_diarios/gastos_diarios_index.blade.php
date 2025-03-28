@extends('layouts.principal')
@section('title', 'Lista de gastos diarios')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px;">Lista de gastos diarios</h1>
                        </div>
                        <hr>

                        <!-- Filtros de fechas -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <label for="fecha-desde" class="form-label">Desde</label>
                                <input type="date" id="fecha-desde" class="form-control" style="width: auto;">
                                <label for="fecha-hasta" class="form-label">Hasta</label>
                                <input type="date" id="fecha-hasta" class="form-control" style="width: auto;">
                                <button id="reload-button" class="btn btn-link p-0" style="color: #007bff; font-size: 24px;">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                            <div>
                                <h4>Total: <strong><span id="totalGramos">0 g</span></strong></h4>
                            </div>
                        </div>

                        <!-- Tabla de Gastos Diarios -->
                        <div class="table-responsive">
                            <table id="gastosDiariosTable" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($gastosDiarios as $gasto)
                                    <tr data-fecha="{{ \Carbon\Carbon::parse($gasto->fecha)->format('Y-m-d') }}">
                                        <td>{{ $gasto->id }}</td>
                                        <td>{{ $gasto->servicioEfectuado->cliente->first_name }} {{ $gasto->servicioEfectuado->cliente->last_name }}</td>
                                        <td>{{ $gasto->servicioEfectuado->servicio->nombre }}</td>
                                        <td>{{ \Carbon\Carbon::parse($gasto->fecha)->locale('es')->isoFormat('LL') }}</td>
                                        <td>
                                            @if($gasto->estado == 'Pendiente')
                                                <span class="badge bg-danger">{{ $gasto->estado }}</span>
                                            @elseif($gasto->estado == 'Entregado')
                                                <span class="badge bg-success">{{ $gasto->estado }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $gasto->estado }}</span>
                                            @endif
                                        </td>
                                        <td>Gramos</td>

                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('gastos-diarios.print', $gasto) }}"
                                                   class="btn btn-sm btn-success no-print"
                                                   title="Imprimir"
                                                   target="_blank"
                                                   data-bs-toggle="tooltip">
                                                    <i class="bi bi-printer"></i>
                                                </a>

                                                <a href="{{ route('gastos-diarios.pdf', $gasto) }}"
                                                   class="btn btn-sm btn-dark no-print"
                                                   title="Descargar PDF"
                                                   data-bs-toggle="tooltip">
                                                    <i class="bi bi-file-pdf"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                let table = $('#gastosDiariosTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ gastos",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún gasto disponible",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ gastos",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ gastos)",
                        "sSearch": "",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        }
                    },
                    "columnDefs": [{ "targets": 0, "orderable": false }],
                    "drawCallback": function() {
                        let api = this.api();
                        let total = 0;
                        api.rows({ search: 'applied' }).every(function() {
                            let cantidad = parseFloat($(this.node()).find('td:eq(6)').text().replace(' g', '').replace(',', ''));
                            total += cantidad;
                        });
                        $('#totalGramos').text(total.toLocaleString('es-HN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " g");
                    },
                    "responsive": true
                });

                function filterByDate() {
                    let fechaDesde = $('#fecha-desde').val();
                    let fechaHasta = $('#fecha-hasta').val();
                    table.draw();
                }

                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    let fechaDesde = $('#fecha-desde').val();
                    let fechaHasta = $('#fecha-hasta').val();
                    let fechaGasto = $(table.row(dataIndex).node()).data('fecha');

                    if (!fechaDesde || !fechaHasta) return true;
                    return fechaGasto >= fechaDesde && fechaGasto <= fechaHasta;
                });

                $('#fecha-desde, #fecha-hasta').change(filterByDate);

                let today = new Date().toISOString().split('T')[0];
                $('#fecha-desde, #fecha-hasta').val(today);

                $('#reload-button').on('click', function() {
                    $('#fecha-desde, #fecha-hasta').val(today);
                    table.search('').draw();
                });

            });
        </script>

    </section>

@endsection
