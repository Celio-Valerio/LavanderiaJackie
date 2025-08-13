@extends('layouts.principal')
@section('title', 'Lista de Clientes')
@section('content')
<section class="section">
        @if($usuario->rolpermiso->clientes_lista == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de clientes</h1>
                                <!-- Botón agregar cliente -->
                                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar cliente</a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <hr>

                            <table id="clientesTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                                <thead class="table table-bordered table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 25%;">Nombre</th>
                                    <th style="width: 25%;">Apellido</th>
                                    <th style="width: 10%;">Teléfono</th>
                                    <th style="width: 10%;">Tipo</th>
                                    <th style="width: 25%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($clientes as $cliente)
                                    @php
                                        $cantSer = $cliente->servicios->count();
                                    @endphp
                                    <tr>
                                        <td class="row-index small-text-field"></td>

                                        <td class="small-text-field" >{{ $cliente->first_name }}</td>
                                        <td class="small-text-field" >{{ $cliente->last_name }}</td>
                                        <td class="small-text-field" >{{ $cliente->phone }}</td>
                                        <td class="small-text-field" >
                                            @if ($cliente->type === 'Credito')
                                                <span class="badge bg-danger">Crédito</span>
                                            @else
                                                <span class="badge bg-success">{{ ucfirst($cliente->type) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($cantSer > 0)
                                                <a href="{{ route('historial.ver', $cliente->id) }}" class="btn btn-dark btn-sm">Historial</a>
                                            @else
                                                <span class="btn btn-dark btn-sm invisible">Historial</span>
                                            @endif
                                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay clientes registrados</td>
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
                var table = $('#clientesTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ clientes",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún cliente disponible en esta tabla",
                        "sInfo": "Se muestran los clientes del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ clientes)",
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
                $('#clientesTable_length').addClass('text-end').css('float', 'right');

                // Mover el input de búsqueda a la izquierda y agregar placeholder
                $('#clientesTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#clientesTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#clientesTable_filter input').css({
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
