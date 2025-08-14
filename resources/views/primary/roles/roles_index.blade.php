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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
        
        <script>
            $(document).ready(function() {
                // Inicializar DataTable
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

                // Función para normalizar fechas
                function normalizarFecha(fecha) {
                    if (!fecha) return null;
                    // Convertir formato "lunes 12 de agosto, 2023" a Date
                    const meses = {
                        'enero': '01', 'febrero': '02', 'marzo': '03', 'abril': '04',
                        'mayo': '05', 'junio': '06', 'julio': '07', 'agosto': '08',
                        'septiembre': '09', 'octubre': '10', 'noviembre': '11', 'diciembre': '12'
                    };
                    
                    const partes = fecha.match(/(\d+) de (\w+), (\d+)/);
                    if (!partes) return null;
                    
                    const dia = partes[1].padStart(2, '0');
                    const mes = meses[partes[2].toLowerCase()];
                    const año = partes[3];
                    
                    return `${año}-${mes}-${dia}`;
                }

                // Filtrado por fechas
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var fechaDesde = $('#fecha-desde').val();
                        var fechaHasta = $('#fecha-hasta').val();
                        
                        // Obtener la fecha de la columna 2 (índice 1)
                        var fechaTexto = table.cell(dataIndex, 2).data();
                        var fechaGasto = normalizarFecha(fechaTexto);
                        
                        if (!fechaDesde && !fechaHasta) return true;
                        if (!fechaGasto) return false;
                        
                        if (fechaDesde && !fechaHasta) {
                            return fechaGasto >= fechaDesde;
                        }
                        
                        if (!fechaDesde && fechaHasta) {
                            return fechaGasto <= fechaHasta;
                        }
                        
                        return fechaGasto >= fechaDesde && fechaGasto <= fechaHasta;
                    }
                );

                // Aplicar filtro cuando cambian las fechas
                $('#fecha-desde, #fecha-hasta').change(function() {
                    table.draw();
                });

                // Botón de recargar
                $('#reload-button').on('click', function() {
                    $('#fecha-desde').val('');
                    $('#fecha-hasta').val('');
                    table.search('').draw();
                });

                // Estilos para DataTables
                $('#gastosTable_length').addClass('text-end').css('float', 'right');
                $('#gastosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#gastosTable_filter input')
                    .attr('placeholder', 'Buscar por todos los datos')
                    .attr('maxlength', '100')
                    .css({
                        'width': '300px',
                        'border-radius': '5px',
                        'padding': '5px'
                    })
                    .on('keydown', function(e) {
                        if (e.which === 32 && !$(this).val().length) {
                            return false;
                        }
                    })
                    .on('input', function() {
                        let value = $(this).val().replace(/^\s+/, '');
                        if (value.length > 100) {
                            value = value.substring(0, 100);
                        }
                        $(this).val(value);
                    });
            });

            // Validación para el formulario de creación/edición de roles
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form[role="form"]');
                
                forms.forEach(form => {
                    const nombreInput = form.querySelector('input[name="nombre"]');
                    
                    if (nombreInput) {
                        nombreInput.addEventListener('input', function(e) {
                            // Permitir solo letras, números y espacios
                            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');
                        });
                        
                        form.addEventListener('submit', function(e) {
                            if (!/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreInput.value)) {
                                e.preventDefault();
                                alert('El nombre del rol solo puede contener letras, números y espacios');
                                nombreInput.focus();
                            }
                        });
                    }
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