@extends('layouts.principal')
@section('title', 'Lista de Usuarios')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de usuarios</h1>
                            <!-- Botón agregar usuario -->
                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar usuario</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <hr>

                        <table id="usuariosTable" class="table table-striped table-bordered" style="padding-top: 10px">
                            <thead class="table table-bordered table-dark">
                            <tr>
                                <th style="width: 5%;">N°</th>
                                <th style="width: 30%;">Nombre</th>
                                <th style="width: 30%;">Correo Electrónico</th>
                                <th style="width: 15%;">Teléfono</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($usuarios as $usuario)
                                <tr>
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field">{{ $usuario->name }}</td>
                                    <td class="small-text-field">{{ $usuario->email }}</td>
                                    <td class="small-text-field">{{ $usuario->telefono }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay usuarios registrados</td>
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
                var table = $('#usuariosTable').DataTable({
                    paging: true,
                    pageLength: 5,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    lengthMenu: [5, 10, 25, 50],
                    language: {
                        sProcessing: "Procesando...",
                        sLengthMenu: "Mostrar _MENU_ usuarios",
                        sZeroRecords: "No se encontraron resultados",
                        sEmptyTable: "Ningún usuario disponible en esta tabla",
                        sInfo: "Se muestran los usuarios del _START_ al _END_ de _TOTAL_.",
                        sInfoEmpty: "No hay resultados ",
                        sInfoFiltered: "(filtrado de un total de _MAX_ usuarios)",
                        sSearch: "",
                        oPaginate: {
                            sFirst: "Primero",
                            sLast: "Último",
                            sNext: "Siguiente",
                            sPrevious: "Anterior"
                        }
                    },
                    columnDefs: [{
                        targets: 0,
                        orderable: false
                    }],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var startIndex = 1;
                        api.rows({ search: 'applied' }).every(function(rowIdx) {
                            $(this.node()).find('td.row-index').html(startIndex++);
                        });
                    }
                });

                // Ajustes de diseño
                $('#usuariosTable_length').addClass('text-end').css('float', 'right');
                $('#usuariosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#usuariosTable_filter input')
                    .attr('placeholder', 'Buscar por todos los datos')
                    .css({
                        width: '300px',
                        'border-radius': '5px',
                        padding: '5px'
                    });

                // Validación del campo de búsqueda
                const $searchInput = $('#usuariosTable_filter input');
                const allowedCharsRegex = /[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9.@\-_ ]/g; // Solo letras, números, punto, @, guion medio, guion bajo y espacios

                $searchInput.on('keydown', function(e) {
                    if (e.key === ' ' || e.keyCode === 32) {
                        const pos = this.selectionStart;
                        const val = this.value;
                        // No permitir espacio inicial ni doble espacio
                        if (pos === 0 || (val && val[pos - 1] === ' ')) {
                            e.preventDefault();
                        }
                    }
                });

                $searchInput.on('input', function() {
                    let val = this.value;
                    // Eliminar caracteres no permitidos
                    val = val.replace(allowedCharsRegex, '');
                    // Reemplazar múltiples espacios por uno solo
                    val = val.replace(/\s{2,}/g, ' ');
                    // Quitar espacios iniciales
                    val = val.replace(/^\s+/, '');
                    if (val !== this.value) {
                        this.value = val;
                    }
                    // Aplicar filtro en DataTables
                    table.search(this.value).draw();
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
