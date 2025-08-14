@extends('layouts.principal')
@section('title', 'Lista de presupuestos')
@section('content')

<section class="section">
    @if($usuario->rolpermiso->presupuesto_lista == 1)
        <div class="row">
            @php
                $fechaAc = date('Y-m-d');
                $primerDiaMes = date('Y-m-01');
                $ultimoPre = $presupuestos->isNotEmpty() ? $presupuestos->last()->fecha : null;
            @endphp
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de presupuestos</h1>
                            @if ($ultimoPre < $primerDiaMes)
                                <!-- Botón agregar presupuesto -->
                                <a href="{{ route('presupuestos.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar presupuesto</a>
                            @else
                                <label for="lblInfo" class="card-title">El presupuesto del mes ya ha sido registrado.</label>
                            @endif
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
                            <button id="reload-button" class="btn btn-link p-0" style="color: #007bff; font-size: 24px; margin-top: 5px;" onclick="location.reload();">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>

                        <table id="gastosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                            <thead class="table table-bordered table-dark">
                            <th style="width: 5%;">N°</th>
                            <th style="width: 20%;">Fecha</th>
                            <th style="width: 20%;">Descripción</th>
                            <th style="width: 20%;">Monto</th>
                            <th style="width: 15%;">Disponible</th>
                            <th style="width: 15%;">Acciones</th>
                            </thead>
                            <tbody>

                            @forelse($presupuestos as $presupuesto)
                                <tr data-fecha="{{ \Carbon\Carbon::parse($presupuesto->fecha)->format('Y-m-d') }}">
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field">{{ \Carbon\Carbon::parse($presupuesto->fecha)->translatedFormat('l d \d\e F, Y') }}</td>
                                    <td class="small-text-field">{{$presupuesto->descripcion}}</td>
                                    <td class="small-text-field">L.{{number_format($presupuesto->cantidad, 2, '.', ',')}}</td>
                                    <td class="small-text-field">L.{{number_format($presupuesto->cantidad - $presupuesto->gastado, 2, '.', ',')}}</td>
                                    <td class="text-center small-text-field">
                                        <a href="{{ route('presupuestos.show', $presupuesto->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('presupuestos.edit', $presupuesto->id) }}" class="btn btn-warning btn-sm">Editar</a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay presupuestos registrados</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

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
                                        "sLengthMenu": "Mostrar _MENU_ presupuestos",
                                        "sZeroRecords": "No se encontraron resultados",
                                        "sEmptyTable": "No hay presupuestos registrados",
                                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ presupuestos",
                                        "sInfoEmpty": "Mostrando 0 a 0 de 0 presupuestos",
                                        "sInfoFiltered": "(filtrado de _MAX_ presupuestos en total)",
                                        "sSearch": "Buscar:",
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
                                        var startIndex = settings._iDisplayStart + 1;

                                        // Actualizar la numeración de filas
                                        api.rows({ page: 'current' }).every(function(rowIdx) {
                                            $(this.node()).find('td.row-index').html(startIndex++);
                                        });

                                        // Calcular el total de montos visibles en la página actual
                                        var total = api.column(3, { page: 'current' }).data().reduce(function(a, b) {
                                            return parseFloat(a) + parseFloat(b.replace(/,/g, ''));
                                        }, 0);

                                        $('#totalMonto').html(total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                    }
                                });

                           // Estilo para mover el select de paginación y búsqueda
                            $('#gastosTable_length').addClass('text-end').css('float', 'right');
                            $('#gastosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                            $('#gastosTable_filter input')
                                .attr('placeholder', 'Buscar por todos los datos')
                                .attr('maxlength', '100') // Limita a 100 caracteres en el HTML
                                .css({
                                    'width': '300px',
                                    'border-radius': '5px',
                                    'padding': '5px'
                                })
                                .on('keydown', function(e) {
                                    // Evitar espacios al inicio
                                    if (e.which === 32 && !$(this).val().length) {
                                        return false;
                                    }
                                })
                                .on('input', function() {
                                    // Eliminar espacios al inicio si se pega texto con espacios
                                    let value = $(this).val().replace(/^\s+/, '');
                                    // Asegurar que no supere los 100 caracteres
                                    if (value.length > 100) {
                                        value = value.substring(0, 100);
                                    }
                                    $(this).val(value);
                                });

                                // Filtro de fechas
                                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                                    var fechaDesde = $('#fecha-desde').val();
                                    var fechaHasta = $('#fecha-hasta').val();
                                    var fechaGasto = $(table.row(dataIndex).node()).data('fecha');

                                    if (fechaDesde && fechaHasta) {
                                        return fechaGasto >= fechaDesde && fechaGasto <= fechaHasta;
                                    }
                                    return true;
                                });

                                $('#fecha-desde, #fecha-hasta').change(function() {
                                    table.draw();
                                });
                            });

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

@endsection
