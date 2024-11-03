@extends('layouts.principal')
@section('title', 'Lista de Maquinaria')
@section('content')

    <style>
        .bg-purple {
            background-color: purple !important;
        }

        .bg-orange {
            background-color: orange !important;
        }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de maquinaria</h1>
                            <!-- Botón agregar maquinaria -->
                            <a href="{{ route('maquinarias.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar maquinaria</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <hr>

                        <table id="maquinariasTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                            <thead class="table table-bordered table-dark">
                            <tr>
                                <th style="width: 5%;">N°</th>
                                <th style="width: 35%;">Nombre</th>
                                <th style="width: 25%;">Tipo</th>
                                <th style="width: 15%;">Estado</th>
                                
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($maquinarias as $maquinaria)
                                <tr>
                                    <td class="row-index"></td>
                                    <td>{{ $maquinaria->name }} <b>{{ $maquinaria->brand }}</b> <b>{{ $maquinaria->model }}</b></td>
                                    <td>{{ $maquinaria->type }}</td>
                                    <td>
                                        @if($maquinaria->status == 'Operativa')
                                            <span class="badge bg-success">{{ $maquinaria->status }}</span>
                                        @elseif($maquinaria->status == 'En mantenimiento')
                                            <span class="badge bg-warning">{{ $maquinaria->status }}</span>
                                        @elseif($maquinaria->status == 'Dada de baja')
                                            <span class="badge bg-danger">{{ $maquinaria->status }}</span>
                                        @elseif($maquinaria->status == 'Bajo revisión')
                                            <span class="badge bg-info">{{ $maquinaria->status }}</span>
                                        @elseif($maquinaria->status == 'Fuera de servicio')
                                            <span class="badge bg-dark">{{ $maquinaria->status }}</span>
                                        @elseif($maquinaria->status == 'Próxima a revisión')
                                            <span class="badge bg-warning">{{ $maquinaria->status }}</span> <!-- Puedes usar un color diferente si deseas -->
                                        @elseif($maquinaria->status == 'En pruebas')
                                            <span class="badge bg-purple">{{ $maquinaria->status }}</span> <!-- Asegúrate de tener una clase CSS para este color -->
                                        @else
                                            <span class="badge bg-secondary">{{ $maquinaria->status }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('maquinarias.edit', $maquinaria->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay maquinarias registradas</td>
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
                var table = $('#maquinariasTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ maquinarias",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ninguna maquinaria disponible en esta tabla",
                        "sInfo": "Se muestran las maquinas del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ maquinas)",
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
                $('#maquinariasTable_length').addClass('text-end').css('float', 'right');

                // Mover el input de búsqueda a la izquierda y agregar placeholder
                $('#maquinariasTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#maquinariasTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#maquinariasTable_filter input').css({
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
