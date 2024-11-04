@extends('layouts.principal')
@section('title', 'Lista de Promociones')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de Promociones</h1>
                            <a href="{{ route('promociones.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar Promoción</a>
                            <a href="{{ route('promociones.view') }}" class="btn btn-dark btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Modo Vista</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <hr>

                        <table id="promocionesTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                            <thead class="table table-bordered table-dark">
                            <tr>
                                <th style="width: 5%;">N°</th>
                                <th style="width: 20%;">Nombre</th>
                                <th style="width: 15%;">Precio</th>
                                <th style="width: 10%;">Descuento</th>
                                <th style="width: 30%;">Días</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($promociones as $promo)
                                <tr>
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field"><b>{{ $promo->name }}</b></td>
                                    <td class="small-text-field">L. {{ $promo->price}}</td>
                                    <td class="small-text-field">{{ $promo->discount }} %</td>
                                    <td class="small-text-field">{{ implode(', ', json_decode($promo->days, true)) }}</td>
                                    <td class="text-center small-text-field">
                                        <a href="{{ route('promociones.show', $promo->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('promociones.edit', $promo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay promociones registradas</td>
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
                var table = $('#promocionesTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ promociones",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ninguna promoción disponible en esta tabla",
                        "sInfo": "Se muestran las promociones del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ promociones)",
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

                // Estilo para mover el select a la derecha
                $('#promocionesTable_length').addClass('text-end').css('float', 'right');

                // Mover el input de búsqueda a la izquierda y agregar placeholder
                $('#promocionesTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#promocionesTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#promocionesTable_filter input').css({
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
