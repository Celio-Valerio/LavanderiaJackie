@extends('layouts.principal')
@section('title', 'Lista de Servicios')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->servicios_lista == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de servicios</h1>
                                <div class="button-group d-flex gap-2">
                                    <a href="{{ route('servicios.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px">Agregar Servicio</a>
                                </div>

                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <hr>

                            <table id="serviciosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                                <br>
                                <thead class="table table-bordered table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 25%;">Nombre</th>
                                    <th style="width: 45%;">Descripción</th>
                                    <th style="width: 10%;">Precio</th>
                                    <th style="width: 15%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($servicios as $servicio)
                                    <tr>
                                        <td class="row-index small-text-field"></td>
                                        <td class="small-text-field"><b>{{ $servicio->nombre }}</b></td>
                                        <td class="small-text-field">{{ $servicio->descripcion }}</td>
                                        <td class="small-text-field">L. {{ number_format($servicio->precio, 2) }}</td>
                                        <td class="text-center small-text-field">
                                            <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay servicios registrados</td>
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
                var table = $('#serviciosTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ servicios",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún servicio disponible en esta tabla",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ servicios",
                        "sInfoEmpty": "No hay resultados",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ servicios)",
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

                $('#serviciosTable_length').addClass('text-end').css('float', 'right');
                $('#serviciosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#serviciosTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#serviciosTable_filter input').css({
                    'width': '300px',
                    'border-radius': '5px',
                    'padding': '5px'
                });
            });
        </script>

        <script>
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
    </section>
@endsection
