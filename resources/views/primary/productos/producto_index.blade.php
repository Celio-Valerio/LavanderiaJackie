@extends('layouts.principal')
@section('title', 'Lista de Productos')
@section('content')

    <section class="section">
        @if($usuario->rolpermiso->productos_lista == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de productos</h1>
                                <!-- Botón agregar producto -->
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar producto</a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <hr>

                            <table id="productosTable" class="table table-striped table-bordered" style="padding-top: 20px; padding-bottom: 10px">
                                <thead class="table table-bordered table-dark">
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 30%;">Producto</th>
                                    <th style="width: 15%;">Precio</th>
                                    <th style="width: 30%;">Proveedor</th>
                                    <th style="width: 20%;">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($productos as $producto)
                                    <tr>
                                        <td class="row-index small-text-field"></td>
                                        <td class="small-text-field"><b>{{ $producto->nombre }}</b></td>
                                        <td class="small-text-field">L. {{ $producto->precio }}</td>
                                        <td class="small-text-field">{{ $producto->proveedor->full_name }}</td>
                                        <td class="text-center small-text-field">
                                            <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay productos registrados</td>
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
                    var table = $('#productosTable').DataTable({
                        paging: true,
                        pageLength: 5,
                        lengthChange: true,
                        searching: true,
                        ordering: true,
                        lengthMenu: [5, 10, 25, 50],
                        language: {
                            sProcessing: "Procesando...",
                            sLengthMenu: "Mostrar _MENU_ productos",
                            sZeroRecords: "No se encontraron resultados",
                            sEmptyTable: "Ningún producto disponible en esta tabla",
                            "sInfo": "Se muestran los productos del _START_ al _END_ de _TOTAL_.",
                            sInfoEmpty: "No hay resultados ",
                            sInfoFiltered: "(filtrado de un total de MAX productos)",
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

                    // Estilo
                    $('#productosTable_length').addClass('text-end').css('float', 'right');
                    $('#productosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                    $('#productosTable_filter input')
                        .attr('placeholder', 'Buscar por todos los datos')
                        .css({ width: '300px', 'border-radius': '5px', padding: '5px' });

                    // === VALIDACIÓN DEL INPUT DE BÚSQUEDA ===
                    const $searchInput = $('#productosTable_filter input');

                    // Permite: letras (incluye ñ/Ñ), números, vocales con tilde, espacio, punto y coma
                    const disallowed = /[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9\.,\s]/g;

                    // Bloquear espacio al inicio y doble espacio al teclear
                    $searchInput.on('keydown', function(e) {
                        if (e.key === ' ' || e.keyCode === 32) {
                            const pos = this.selectionStart;
                            const val = this.value;
                            if (pos === 0 || (val && val[pos - 1] === ' ')) {
                                e.preventDefault(); // no espacio inicial ni doble espacio
                            }
                        }
                    });

                    // Limpiar en tiempo real y aplicar búsqueda
                    $searchInput.on('input', function() {
                        let v = this.value;

                        // 1) quitar caracteres no permitidos
                        v = v.replace(disallowed, '');

                        // 2) colapsar espacios múltiples y eliminar espacios iniciales
                        v = v.replace(/\s{2,}/g, ' ').replace(/^\s+/, '');

                        if (v !== this.value) this.value = v;

                        // 3) filtrar DataTables
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
