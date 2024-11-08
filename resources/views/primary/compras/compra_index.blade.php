@extends('layouts.principal')
@section('title', 'Lista de Compras')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de Compras</h1>
                            <!-- Botón agregar compra -->
                            <a href="{{ route('compras.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar Compra</a>
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

                        <table id="comprasTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                            <thead class="table table-bordered table-dark">
                            <tr>
                                <th style="width: 5%;">N°</th>
                                <th style="width: 20%;">Factura</th>
                                <th style="width: 15%;">Fecha</th>
                                <th style="width: 25%;">Proveedor</th>
                                <th style="width: 20%;">Total en Lempiras</th>
                                <th style="width: 15%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($compras as $compra)
                                <tr data-fecha="{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('Y-m-d') }}">
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field">{{ $compra->numero_factura }}</td>
                                    <td class="small-text-field">{{ ucfirst(\Carbon\Carbon::parse($compra->fecha_compra)->translatedFormat('l d \d\e F, Y')) }}</td>
                                    <td class="small-text-field">{{ $compra->proveedor->full_name ?? 'Sin proveedor' }}</td>
                                    <td class="small-text-field">
                                        L. {{ number_format($compra->detalles->sum(function($detalle) {
                                            return $detalle->cantidad * $detalle->precio;
                                        }), 2) }}
                                    </td>
                                    <td class="text-center small-text-field">
                                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay compras registradas</td>
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
                var table = $('#comprasTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ compras",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ninguna compra disponible en esta tabla",
                        "sInfo": "Se muestran las compras del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ compras)",
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
                        "orderable": false // Deshabilitar ordenamiento en la columna del índice
                    }],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = 1; // Comenzar el índice en 1

                        // Actualizar el índice en la columna correspondiente
                        api.rows({ search: 'applied' }).every(function(rowIdx) {
                            $(this.node()).find('td.row-index').html(startIndex++); // Incrementar el índice
                        });
                    }
                });

                // Filtro de fechas con valores predeterminados
                var fechaInicial = '2000-01-01';
                var fechaFinal = new Date().toISOString().split('T')[0]; // Fecha actual en formato YYYY-MM-DD
                $('#fecha-desde').val(fechaInicial);
                $('#fecha-hasta').val(fechaFinal);

                $('#fecha-desde, #fecha-hasta').change(function() {
                    var fechaDesde = $('#fecha-desde').val();
                    var fechaHasta = $('#fecha-hasta').val();

                    table.rows().every(function() {
                        var row = this.node();
                        var fechaCompra = $(row).data('fecha');

                        if (fechaDesde && fechaHasta) {
                            if (fechaCompra >= fechaDesde && fechaCompra <= fechaHasta) {
                                $(row).show();
                            } else {
                                $(row).hide();
                            }
                        } else {
                            $(row).show(); // Si no se aplica filtro, mostrar todas las filas
                        }
                    });
                });

                // Estilo para mover el select a la derecha
                $('#comprasTable_length').addClass('text-end').css('float', 'right');

                // Mover el input de búsqueda a la izquierda y agregar placeholder
                $('#comprasTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#comprasTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#comprasTable_filter input').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
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
