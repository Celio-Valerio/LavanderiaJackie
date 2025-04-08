@extends('layouts.principal')
@section('title', 'Lista de gastos')
@section('content')

<section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $fechaAc = date('Y-m-d');
                            $primerDiaMes = date('Y-m-01');
                            $ultimoDiaMes = date('Y-m-t');
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de gastos</h1>
                            <!-- Botón agregar gasto -->
                            <a href="{{ route('gastos.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar gasto</a>
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

        <table id="gastosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
        <thead class="table table-bordered table-dark">
            <th style="width: 5%;">N°</th>
            <th style="width: 20%;">Fecha</th>
            <th style="width: 20%;">Descripción</th>
            <th style="width: 15%;">Gastos fijos</th>
            <th style="width: 15%;">Gastos productos</th>
            <th style="width: 15%;">Acciones</th>
        </thead>
    <tbody>
    @php
        $totalGastosFijos = 0;
        $totalGastosProductos = 0;
    @endphp
    @forelse($gastos as $gasto)
    @php
        $totalGastosFijos += $gasto->totalG;
        $totalGastosProductos += $gasto->totalP;
    @endphp
    <tr data-fecha="{{ \Carbon\Carbon::parse($gasto->fecha)->format('Y-m-d') }}">
        <td class="row-index small-text-field"></td>
        <td class="small-text-field">{{ \Carbon\Carbon::parse($gasto->fecha)->translatedFormat('l d \d\e F, Y') }}</td>
        <td class="small-text-field">{{$gasto->descripcion}}</td>
        <td class="small-text-field">L.{{number_format($gasto->totalG, 2, '.', ',')}}</td>
        <td class="small-text-field">L.{{number_format($gasto->totalP ?? 0, 2, '.', ',')}}</td>
        <td class="text-center small-text-field">
            <a href="{{ route('gastos.show', $gasto->id) }}" class="btn btn-info btn-sm">Ver</a>
            <a href="{{ route('gastos.edit', $gasto->id) }}" class="btn btn-warning btn-sm">Editar</a>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">No hay gastos registrados</td>
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
                        "sLengthMenu": "Mostrar _MENU_ gastos",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ninguna gasto disponible en esta tabla",
                        "sInfo": "Se muestran los gastos del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ gastos)",
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

                        var total = api.column(2, { page: 'current' }).data().reduce(function(a, b) {
                            return a + b * 1; // Sumar los montos
                        }, 0);
                        $('#totalMonto').html(total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")); // Mostrar el total con comas
                    }
                });





                // Estilo para mover el select a la derecha
                $('#gastosTable_length').addClass('text-end').css('float', 'right');

                // Mover el input de búsqueda a la izquierda y agregar placeholder
                $('#gastosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#gastosTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#gastosTable_filter input').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
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
                        var fechaGasto = $(row).data('fecha');

                        if (fechaDesde && fechaHasta) {
                            if (fechaGasto >= fechaDesde && fechaGasto <= fechaHasta) {
                                $(row).show();
                            } else {
                                $(row).hide();
                            }
                        } else {
                            $(row).show(); // Si no se aplica filtro, mostrar todas las filas
                        }
                    });
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
@endsection
