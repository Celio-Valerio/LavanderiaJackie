@extends('layouts.principal')
@section('title', 'Lista de cuentas bancarias')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->bancos_lista == 1)
            <div class="row"></div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de Cuentas Bancarias</h1>
                            <div class="button-group d-flex gap-2">
                                <a href="{{ route('control_cuentas.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px">Registrar Transacción</a>
                            </div>
                        </div>

                        <hr>

                        <!-- Filtros de fechas -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <label for="fecha-desde" class="form-label">Buscar desde</label>
                                <input type="date" id="fecha-desde" class="form-control d-inline-block" style="width: auto;">
                                <label for="fecha-hasta" class="form-label">hasta</label>
                                <input type="date" id="fecha-hasta" class="form-control d-inline-block" style="width: auto;">

                                <!-- Botón de recargar -->
                                <button id="reload-button" class="btn btn-link p-0" style="color: #007bff; font-size: 24px; margin-top: 5px;">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>

                            <div>
                                <h4>Total: <strong><span id="totalSaldo">L. 0.00</span></strong></h4>
                            </div>
                        </div>

                        <table id="cuentasBancosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                            <thead class="table table-bordered table-dark">
                            <tr>
                                <th style="width: 5%;">N°</th>
                                <th style="width: 20%;">Banco</th>
                                <th style="width: 25%;">Número de Cuenta</th>
                                <th style="width: 15%;">Saldo</th>
                                <th style="width: 10%;">Fecha de Creación</th>
                                <th style="width: 15%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cuentaBanco as $cuenta)
                                <tr data-fecha="{{ \Carbon\Carbon::parse($cuenta->created_at)->format('Y-m-d') }}">
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field">{{ $cuenta->banco }}</td>
                                    <td class="small-text-field">{{ $cuenta->cuenta }}</td>
                                    <td class="small-text-field">L. {{ number_format($cuenta->saldo, 2) }}</td>
                                    <td class="small-text-field">{{ \Carbon\Carbon::parse($cuenta->created_at)->locale('es')->isoFormat('LL') }}</td>
                                    <td class="text-center small-text-field">
                                        <a href="{{ route('cuenta_bancos.show', $cuenta->id) }}" class="btn btn-info btn-sm">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay cuentas bancarias registradas</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

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

        <script>
            $(document).ready(function() {
                var table = $('#cuentasBancosTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ cuentas",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "No hay cuentas bancarias disponibles",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ cuentas",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ cuentas)",
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

                        // Calcular el total de saldo
                        var totalSaldo = 0;
                        api.rows({ search: 'applied' }).every(function() {
                            var data = this.data();
                            var saldo = parseFloat(data[3].replace('L. ', '').replace(',', ''));
                            totalSaldo += saldo;
                        });

                        // Actualizar el elemento HTML con el total de saldo
                        $('#totalSaldo').text('L. ' + totalSaldo.toLocaleString('es-HN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    },
                    "responsive": true
                });

                // Filtro por fechas
                function filterByDate() {
                    var fechaDesde = $('#fecha-desde').val();
                    var fechaHasta = $('#fecha-hasta').val();
                    table.draw();
                }

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var fechaDesde = $('#fecha-desde').val();
                        var fechaHasta = $('#fecha-hasta').val();
                        var fechaCreacion = $(table.row(dataIndex).node()).data('fecha');

                        if (!fechaDesde || !fechaHasta) {
                            return true;
                        }

                        return fechaCreacion >= fechaDesde && fechaCreacion <= fechaHasta;
                    }
                );

                $('#fecha-desde, #fecha-hasta').change(filterByDate);

                // Búsqueda global por todos los campos
                $('#cuentasBancosTable_filter input').attr('placeholder', 'Buscar por todos los datos').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
                });

                // Botón de recargar
                $('#reload-button').on('click', function() {
                    $('#fecha-desde').val('');
                    $('#fecha-hasta').val('');
                    table.search('').draw(); // Limpiar búsqueda y recargar tabla
                });
            });
        </script>
    </section>
@endsection
