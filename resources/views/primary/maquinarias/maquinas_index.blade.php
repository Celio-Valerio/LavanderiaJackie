@extends('layouts.principal')
@section('title', 'Lista de Maquinas')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de Maquinas</h1>
                        <!-- Botón agregar máquina -->
                        <a href="{{ route('maquinas.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar Máquina</a>
                    </div>

                    @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                    @endif
                    <hr>

                    <table id="maquinasTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                        <thead class="table table-bordered table-dark">
                        <tr>
                            <th style="width: 5%;">N°</th>
                            <th style="width: 25%;">Nombre</th>
                            <th style="width: 25%;">Marca</th>
                            <th style="width: 25%;">Modelo</th>
                            <th style="width: 20%;">Estado</th> 
                            <th style="width: 20%;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($maquinas as $maquina)
                            <tr>
                                <td class="row-index"></td>
                                <td>{{ $maquina->nombre }}</td>
                                <td>{{ $maquina->marca }}</td>
                                <td>{{ $maquina->modelo }}</td>
                                <td>{{ $maquina->estado }}</td> <!-- Mostrar el estado de la máquina -->
                                <td class="text-center">
                                    <a href="{{ route('maquinas.show', $maquina->id) }}" class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        @csrf
                                        @method('DELETE')
                                       
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay máquinas registradas</td>
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
            var table = $('#maquinasTable').DataTable({
                "paging": true,
                "pageLength": 5,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ máquinas",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ninguna máquina disponible en esta tabla",
                    "sInfo": "Mostrar _START_ a _END_ de _TOTAL_ máquinas",
                    "sInfoEmpty": "Mostrar 0 a 0 de 0 máquinas",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ máquinas)",
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
            $('#maquinasTable_length').addClass('text-end').css('float', 'right');

            // Mover el input de búsqueda a la izquierda y agregar placeholder
            $('#maquinasTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
            $('#maquinasTable_filter input').attr('placeholder', 'Buscar por todos los datos');
            $('#maquinasTable_filter input').css({
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
