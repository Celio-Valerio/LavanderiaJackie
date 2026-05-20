@extends('layouts.principal')
@section('title', 'Lista de Empleados')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->empleados_lista == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de empleados</h1>
                                <!-- Botón agregar empleado -->
                                <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar empleado</a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <hr>

                            <table id="empleadosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                                <thead class="table table-bordered table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 15%;">Nombre</th>
                                    <th style="width: 15%;">Apellido</th>
                                    <th style="width: 10%;">Teléfono</th>
                                    <th style="width: 15%;">Puesto</th>
                                    <th style="width: 10%;">Estado</th>
                                    <th style="width: 25%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($empleados as $empleado)
                                    <tr>
                                        <td class="row-index small-text-field" ></td>
                                        <td class="small-text-field" >{{ $empleado->first_name }}</td>
                                        <td class="small-text-field" >{{ $empleado->last_name }}</td>
                                        <td class="small-text-field" >{{ $empleado->phone }}</td>
                                        <td class="small-text-field" >{{ $empleado->puesto->name }}</td>
                                        <td class="small-text-field">

                                            <span class="badge {{ $empleado->estado  == 'Inactivo' ? 'bg-danger' : ($empleado->estado  == 'Activo' ? 'bg-success' : 'bg-danger') }}">{{ $empleado->estado  }}</span>
                                        </td>
                                        <td class="text-center small-text-field">
                                            <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="{{ route('empleados.constancia', $empleado->id) }}" class="btn btn-success btn-sm">Constancia</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay empleados registrados</td>
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
                    var table = $('#empleadosTable').DataTable({
                        "paging": true,
                        "pageLength": 5,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "lengthMenu": [5, 10, 25, 50],
                        "language": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ empleados",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún empleado disponible en esta tabla",
                            "sInfo": "Se muestran los empleados del _START_ al _END_ de _TOTAL_.",
                            "sInfoEmpty": "No hay resultados ",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ empleados)",
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

                    // Estilos del buscador (como ya tienes)
                    $('#empleadosTable_length').addClass('text-end').css('float', 'right');
                    $('#empleadosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                    $('#empleadosTable_filter input')
                        .attr('placeholder', 'Buscar por todos los datos')
                        .css({ 'width': '300px', 'border-radius': '5px', 'padding': '5px' });

                    // === VALIDACIÓN DEL INPUT DE BÚSQUEDA ===
                    const $input = $('#empleadosTable_filter input');

                    // Solo letras (con tildes y ñ), números y espacios
                    const allowRegex = /[^0-9A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]/g;

                    // Evitar espacio al inicio y doble espacio al teclear
                    $input.on('keydown', function(e) {
                        if (e.key === ' ' || e.keyCode === 32) {
                            const pos = this.selectionStart;
                            const val = this.value;
                            // Bloquea si el cursor está al inicio o si el carácter anterior ya es un espacio
                            if (pos === 0 || (val && val[pos - 1] === ' ')) {
                                e.preventDefault();
                            }
                        }
                    });

                    // Sanitizar en cada cambio (tecleo/pegar/autocompletar)
                    $input.on('input', function() {
                        let v = this.value;

                        // 1) Remover caracteres no permitidos
                        v = v.replace(allowRegex, '');

                        // 2) Reemplazar múltiples espacios por uno
                        v = v.replace(/\s{2,}/g, ' ');

                        // 3) Quitar espacios iniciales
                        v = v.replace(/^\s+/, '');

                        // Solo si cambió, actualiza el input
                        if (v !== this.value) this.value = v;

                        // Actualizar búsqueda de DataTables con el valor saneado
                        table.search(this.value).draw();
                    });
                    // === FIN VALIDACIÓN ===
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
