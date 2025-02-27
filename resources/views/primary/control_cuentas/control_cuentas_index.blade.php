@extends('layouts.principal')
@section('title', 'Lista de transacciones')
@section('content')

    <section class="section">
        <div class="row"></div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de transacciones</h1>
                        <div class="button-group d-flex gap-2">
                            <a href="{{ route('control_cuentas.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px">Registrar Transacción</a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filtros de fechas -->
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <label for="fecha-desde" class="form-label">Buscar desde</label>
                            <input type="date" id="fecha-desde" class="form-control d-inline-block" style="width: auto;">
                            <label for="fecha-hasta" class="form-label">hasta</label>
                            <input type="date" id="fecha-hasta" class="form-control d-inline-block" style="width: auto;">

                            <div class="d-flex align-items-center gap-2">
                                <!-- Filtro por tipo de transacción -->
                                <select id="tipo-transaccion" class="form-select d-inline-block" style="width: auto;">
                                    <option value="">Todos</option>
                                    <option value="Retiro">Retiro</option>
                                    <option value="Deposito">Deposito</option>
                                </select>
                            </div>

                            <!-- Botón de recargar -->
                            <button id="reload-button" class="btn btn-link p-0" style="color: #007bff; font-size: 24px; margin-top: 5px;">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>

                        <div>
                            <h4>Total: <strong><span id="totalSaldo">L. 0.00</span></strong></h4>
                        </div>
                    </div>

                    <table id="transaccionesTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                        <thead class="table table-bordered table-dark">
                        <tr>
                            <th style="width: 5%;">N°</th>
                            <th style="width: 20%;">Banco</th>
                            <th style="width: 20%;">N° Cuenta</th>
                            <th style="width: 15%;">Fecha de Transacción</th>
                            <th style="width: 15%;">Transacción</th>
                            <th style="width: 15%;">Valor</th>
                            <th style="width: 10%;">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transacciones as $index => $transaccion)
                            <tr data-fecha="{{ \Carbon\Carbon::parse($transaccion->fecha)->format('Y-m-d') }}" data-transaccion="{{ $transaccion->transaccion }}" data-monto="{{ $transaccion->monto }}">
                                <td class="row-index small-text-field">{{ $index + 1 }}</td>
                                <td class="small-text-field"><b>{{ $transaccion->cuentaBanco->banco }}</b></td>
                                <td class="small-text-field">{{ $transaccion->cuentaBanco->cuenta }}</td>
                                <td class="small-text-field">
                                    {{ \Carbon\Carbon::parse($transaccion->fecha)->locale('es')->isoFormat('LL') }}
                                </td>
                                <td class="small-text-field">
                                    @if($transaccion->transaccion == 'Retiro')
                                        <span class="badge bg-danger">{{ $transaccion->transaccion }}</span>
                                    @elseif($transaccion->transaccion == 'Deposito')
                                        <span class="badge bg-success">{{ $transaccion->transaccion }}</span>
                                    @elseif($transaccion->transaccion == 'Saldo inicial')
                                        <span class="badge bg-primary">{{ $transaccion->transaccion }}</span>
                                    @endif
                                </td>
                                <td class="small-text-field">L. {{ number_format($transaccion->monto, 2) }}</td>
                                <td class="text-center small-text-field">
                                    <a href="{{ route('control_cuentas.show', $transaccion->id) }}" class="btn btn-info btn-sm">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay transacciones registradas</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var table = $('#transaccionesTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ transacciones",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningúna transacción en esta tabla",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ transacciones",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ transacciones)",
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
                        var total = 0;
                        var api = this.api();

                        api.rows({ search: 'applied' }).every(function() {
                            var rowData = this.data();
                            var monto = parseFloat($(this.node()).data('monto'));
                            var tipoTransaccion = $(this.node()).data('transaccion');

                            if (tipoTransaccion === 'Retiro') {
                                total -= monto;
                            } else {
                                total += monto;
                            }
                        });

                        $('#totalSaldo').text('L. ' + total.toLocaleString('es-HN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    },
                    "responsive": true
                });

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var fechaDesde = $('#fecha-desde').val();
                        var fechaHasta = $('#fecha-hasta').val();
                        var tipoTransaccion = $('#tipo-transaccion').val();
                        var fechaServicio = $(table.row(dataIndex).node()).data('fecha');
                        var transaccionTipo = $(table.row(dataIndex).node()).data('transaccion');

                        if ((fechaDesde && fechaServicio < fechaDesde) || (fechaHasta && fechaServicio > fechaHasta)) {
                            return false;
                        }

                        if (tipoTransaccion && transaccionTipo !== tipoTransaccion) {
                            return false;
                        }

                        return true;
                    }
                );

                $('#fecha-desde, #fecha-hasta, #tipo-transaccion').change(function() {
                    table.draw();
                });

                $('#reload-button').on('click', function() {
                    $('#fecha-desde').val('');
                    $('#fecha-hasta').val('');
                    $('#tipo-transaccion').val('');
                    table.search('').draw();
                });

                // Cambiar la posición y el diseño del filtro de búsqueda y el select
                $('#transaccionesTable_filter').css('float', 'left').addClass('text-start');
                $('#transaccionesTable_length').css('float', 'right').addClass('text-end');
                $('#transaccionesTable_filter input').attr('placeholder', 'Buscar por todos los datos').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
                });

                function reordenarNumeracion() {
                    $('#transaccionesTable tbody tr').each(function(index) {
                        $(this).find('td:first').text(index + 1);
                    });
                }

                // Reordenar la numeración cada vez que la tabla se redibuje
                $('#transaccionesTable').on('draw.dt', function() {
                    reordenarNumeracion();
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
