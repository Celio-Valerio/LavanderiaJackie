@extends('layouts.principal')
@section('title', 'Lista de roles')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->nombre == 'Administrador')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de roles</h1>
                                <div class="button-group d-flex gap-2">
                                    <a href="{{ route('roles.create') }}"
                                       class="btn btn-primary btn-sm d-flex align-items-center"
                                       style="border-radius: 5px; height: 40px; padding: 0 15px;">
                                        Agregar rol
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

                            <table id="gastosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                                <thead class="table table-bordered table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 20%;">Nombre</th>
                                    <th style="width: 20%;">Fecha</th>
                                    <th style="width: 20%;">Estado</th>
                                    <th style="width: 15%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($roles as $rol)
                                    <tr>
                                        <td class="row-index small-text-field"></td>
                                        <td class="small-text-field">{{$rol->nombre}}</td>
                                        <td class="small-text-field">{{ \Carbon\Carbon::parse($rol->fecha)->translatedFormat('l d \d\e F, Y') }}</td>
                                        <td class="small-text-field">
                                            @if($rol->estado == 'Activo')
                                                <span class="badge bg-success">{{ $rol->estado }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $rol->estado }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Botones de acción">
                                                @if($rol->nombre == "Administrador")
                                                    <a href="{{ route('roles.show', $rol->id) }}" class="btn btn-info btn-sm" title="Ver" data-bs-toggle="tooltip">
                                                        Ver
                                                    </a>
                                                    <span class="btn btn-dark btn-sm invisible">Editar</span>
                                                @else
                                                    <a href="{{ route('roles.show', $rol->id) }}" class="btn btn-info btn-sm" title="Ver" data-bs-toggle="tooltip">
                                                        Ver
                                                    </a>
                                                    <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-warning btn-sm" title="Editar" data-bs-toggle="tooltip">
                                                        Editar
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay roles registrados</td>
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
                    <p class="fs-5">No tienes permisos para acceder a este apartado. Solo los usuarios con rol de <strong>Administrador</strong> pueden ver esta sección.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4 px-4 py-2">Volver al inicio</a>
                </div>
            </div>
        @endif

        <script>
            $(document).ready(function() {
                var table = $('#gastosTable').DataTable({
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
                        "sEmptyTable": "Ninguna gasto disponible en esta tabla",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ roles",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ roles)",
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

                function filterByDate() {
                    var fechaDesde = $('#fecha-desde').val();
                    var fechaHasta = $('#fecha-hasta').val();
                    table.draw();
                }

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var fechaDesde = $('#fecha-desde').val();
                        var fechaHasta = $('#fecha-hasta').val();
                        var fechaGasto = $(table.row(dataIndex).node()).data('fecha');

                        if (!fechaDesde || !fechaHasta) {
                            return true;
                        }

                        return fechaGasto >= fechaDesde && fechaGasto <= fechaHasta;
                    }
                );

                $('#fecha-desde, #fecha-hasta').change(filterByDate);

                $('#gastosTable_length').addClass('text-end').css('float', 'right');
                $('#gastosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#gastosTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#gastosTable_filter input').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
                });

                // Botón de recargar
                $('#reload-button').on('click', function() {
                    $('#fecha-desde').val('');
                    $('#fecha-hasta').val('');
                    table.search('').draw();
                });
            });
        </script>


        <script>
            document.getElementById('export-pdf-btn').addEventListener('click', function(e) {
                e.preventDefault();

                const params = new URLSearchParams();
                const fDesde = document.getElementById('fecha-desde').value;
                const fHasta = document.getElementById('fecha-hasta').value;
                const search = document.querySelector('#gastosTable_filter input').value.trim();

                if (fDesde) params.append('fecha_desde', fDesde);
                if (fHasta) params.append('fecha_hasta', fHasta);
                if (search) params.append('search', search);

                const url = `{{ route('gastos.export-pdf') }}?${params.toString()}`;
                window.open(url, '_blank');
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
