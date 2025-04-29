@extends('layouts.principal')
@section('title', 'Lista de cupones vencidos')
@section('content')
    <section class="section">
        @if($usuario->rolpermiso->cuponesvencidos_lista == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de cupones vencidos</h1>
                                <!-- Botón agregar cupones -->
                                <a href="{{ route('cupones.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar cupón</a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <hr>

                            <!-- Filtros de fechas y botón de recargar -->
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <div>
                                    <label for="fecha-desde" class="form-label">Buscar desde</label>
                                    <input type="date" id="fecha-desde" class="form-control" style="display: inline-block; width: auto;">
                                    <label for="fecha-hasta" class="form-label">hasta</label>
                                    <input type="date" id="fecha-hasta" class="form-control" style="display: inline-block; width: auto;">
                                </div>
                                <!-- Botón de recargar -->
                                <button id="reload-button" class="btn btn-link p-0" style="color: #007bff; font-size: 24px; margin-top: 5px;">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>

                            <table id="cuponesTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px; text-align: center;">
                                <thead class="table table-bordered table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 15%;">Nombre</th>
                                    <th style="width: 15%;">Estado</th>
                                    <th style="width: 10%;">Tipo de cupón</th>
                                    <th style="width: 15%;">Valor</th>
                                    <th style="width: 10%;">Inicia</th>
                                    <th style="width: 10%;">Finaliza</th>
                                    <th style="width: 20%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($cupones as $cupon)
                                    @php
                                        $fecha_hoy = date('Y-m-d');
                                    @endphp
                                    @if($fecha_hoy > $cupon->fecha_hasta)
                                        <tr data-fecha="{{ \Carbon\Carbon::parse($cupon->fecha_desde)->format('Y-m-d') }}">
                                            <td class="row-index small-text-field"></td>
                                            <td class="small-text-field" >{{ $cupon->nombre }}</td>

                                            <td class="small-text-field">
                                                <span class="badge bg-danger">Vencido</span>
                                            </td>

                                            <td class="small-text-field">
                                                @if($cupon->tipo == 'Valor')
                                                    <span class="badge bg-dark">{{ $cupon->tipo }}</span>
                                                @elseif($cupon->tipo == 'Cantidad')
                                                    <span class="badge bg-dark">{{ $cupon->tipo }}</span>
                                                @elseif($cupon->tipo == 'Descuento')
                                                    <span class="badge bg-dark">{{ $cupon->tipo }}</span>
                                                @endif
                                            </td>


                                            <td class="small-text-field">
                                                @if($cupon->tipo == 'Valor')
                                                    <span>L. {{ $cupon->valor }}</span> <!-- Redondear el valor -->
                                                @elseif($cupon->tipo == 'Cantidad')
                                                    <span>{{ round($cupon->valor) }} lavadas</span> <!-- Redondear el valor -->
                                                @elseif($cupon->tipo == 'Descuento')
                                                    <span>{{ round($cupon->valor) }} %</span> <!-- Redondear el valor -->
                                                @endif
                                            </td>

                                            <td class="small-text-field">{{ \Carbon\Carbon::parse($cupon->fecha_desde)->format('d/m/Y') }}</td>
                                            <td class="small-text-field">{{ \Carbon\Carbon::parse($cupon->fecha_hasta)->format('d/m/Y') }}</td>


                                            <td class="text-center">
                                                <a href="{{ route('cupones.show', $cupon->id) }}" class="btn btn-info btn-sm">Ver</a>
                                                <a href="{{ route('cupones.edit', $cupon->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay cupones registrados</td>
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


        <script>
            $(document).ready(function() {
                var table = $('#cuponesTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ cupones",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún cupón disponible en esta tabla",
                        "sInfo": "Se muestran los cupones del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ cupones)",
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
                    }
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
                        var row = table.row(dataIndex).node();
                        var fechaCupon = $(row).data('fecha');

                        if (!fechaDesde || !fechaHasta) {
                            return true;
                        }

                        return fechaCupon >= fechaDesde && fechaCupon <= fechaHasta;
                    }
                );

                $('#fecha-desde, #fecha-hasta').on('change', filterByDate);

                // Botón de recargar
                $('#reload-button').on('click', function() {
                    $('#fecha-desde').val('');
                    $('#fecha-hasta').val('');
                    table.search('').draw();
                });

                // Estilos para DataTables
                $('#cuponesTable_length').addClass('text-end').css('float', 'right');
                $('#cuponesTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#cuponesTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#cuponesTable_filter input').css({
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
