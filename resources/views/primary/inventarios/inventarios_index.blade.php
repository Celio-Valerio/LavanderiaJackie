@extends('layouts.principal')
@section('title', 'Inventario')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de productos en el inventario</h1>
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
                                <th style="width: 25%;">Producto</th>
                                <th style="width: 15%;">Precio de compra</th>
                                <th style="width: 15%;">Existencia</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($productos as $producto)
                                <tr>
                                    <td class="row-index small-text-field"></td>
                                    <td class="small-text-field"><b>{{ $producto->nombre }}</b></td>
                                    <td class="small-text-field">L. {{ $producto->precio }}</td>
                                    <td class="small-text-field">{{ $producto->stock }} unidades</td>
                                    <td class="text-center small-text-field">
                                        @if($producto->stock > 0)
                                            <button
                                                type="button" class="btn btn-primary btn-sm d-flex align-items-center btn-registrar-consumo" data-bs-toggle="modal" data-bs-target="#modal{{$producto->id}}" data-id="{{$producto->id}}" data-stock="{{$producto->stock}}"
                                            >
                                                Registrar consumo
                                            </button>
                                        @endif
                                            <div class="modal fade" id="modal{{$producto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$producto->id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$producto->id}}">
                                                                Registrar consumo de {{$producto->nombre}}
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('inventarios.store') }}" method="post" class="form-registrar-consumo">
                                                                @csrf
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <h2 style="text-align: left;" class="modal-title fs-5">
                                                                            Cantidad de consumo:
                                                                        </h2>
                                                                        <input type="text" name="consumo" class="form-control consumo-input" maxlength="4" oninput="validarSoloNumeros(this)">
                                                                        <div class="invalid-feedback cantidad-vacia" style="text-align: left;"></div>
                                                                    </div>
                                                                    <input type="hidden" name="idProducto" class="id-producto" value="{{$producto->id}}">
                                                                    <input type="hidden" name="cantProducto" class="cant-producto" value="{{$producto->stock}}">
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex justify-content-between">
                                                                    <button type="button" class="btn btn-primary btn-enviar-modal flex-fill me-1">Registrar</button>
                                                                    <button type="button" class="btn btn-danger flex-fill" data-bs-dismiss="modal">Cancelar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay productos del inventario registrados</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Detectar cuando se cierra cualquier modal
                document.querySelectorAll('.modal').forEach(function (modal) {
                    modal.addEventListener('hidden.bs.modal', function () {
                        // Obtener el input "consumo" específico dentro del modal cerrado
                        var consumoInput = modal.querySelector('.form-control');
                        var cantidadVacia = modal.querySelector('.invalid-feedback');
                        if (consumoInput && cantidadVacia) {
                            cantidadVacia.style.display = 'none';
                            consumoInput.value = '';
                        }
                    });

                    // Detectar el botón "Cancelar" dentro del modal
                    modal.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function (cancelButton) {
                        cancelButton.addEventListener('click', function () {
                            var consumoInput = modal.querySelector('.form-control');
                            var cantidadVacia = modal.querySelector('.invalid-feedback');
                            if (consumoInput && cantidadVacia) {
                                cantidadVacia.style.display = 'none';
                                consumoInput.value = '';
                            }
                        });
                    });
                });
            });

        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Validar solo números
                window.validarSoloNumeros = function (input) {
                    input.value = input.value
                        .replace(/[^0-9]/g, "") // Permite solo números
                        .replace(/^0+(?!$)/, ""); // Elimina ceros iniciales, a menos que sea el único dígito
                };

                // Manejar clic en "Registrar" dentro del modal
                document.querySelectorAll(".btn-enviar-modal").forEach((button) => {
                    button.addEventListener("click", function () {
                        const modal = button.closest(".modal");
                        const consumoInput = modal.querySelector(".consumo-input");
                        const cantidadVacia = modal.querySelector(".cantidad-vacia");
                        const cantProducto = parseInt(modal.querySelector(".cant-producto").value);

                        // Resetear mensajes de error
                        cantidadVacia.style.display = "none";
                        cantidadVacia.textContent = "";

                        const consumo = parseInt(consumoInput.value || "0");
                        let isValid = true;

                        if (consumo <= 0) {
                            cantidadVacia.style.display = "block";
                            cantidadVacia.textContent = "La cantidad debe ser mayor que 0.";
                            isValid = false;
                        }

                        if (consumo > cantProducto) {
                            cantidadVacia.style.display = "block";
                            cantidadVacia.textContent = "La cantidad de consumo no puede ser mayor que la cantidad disponible.";
                            isValid = false;
                        }

                        if (isValid) {
                            modal.querySelector(".form-registrar-consumo").submit();
                        }
                    });
                });
            });

        </script>

        <script>
            $(document).ready(function() {
                var table = $('#productosTable').DataTable({
                    "paging": true,
                    "pageLength": 5,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "lengthMenu": [5, 10, 25, 50],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ productos",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún producto disponible en esta tabla",
                        "sInfo": "Se muestran los productos del _START_ al _END_ de _TOTAL_.",
                        "sInfoEmpty": "No hay resultados ",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ productos)",
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
                $('#productosTable_length').addClass('text-end').css('float', 'right');

                // Mover el input de búsqueda a la izquierda y agregar placeholder
                $('#productosTable_filter').addClass('text-start').removeClass('text-end').css('float', 'left');
                $('#productosTable_filter input').attr('placeholder', 'Buscar por todos los datos');
                $('#productosTable_filter input').css({
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
        <script>
            // Maneja el evento de abrir el modal y pasa el ID del producto al modal
            $('#modalRegistrarConsumo').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // El botón que abre el modal
                var productoId = button.data('id'); // Obtener el id del producto

                // Establece el ID del producto en el campo oculto
                var modal = $(this);
                modal.find('#producto_id').val(productoId);
            });

            // Validar que el input solo permita números
            function validarSoloNumeros(input) {
                input.value = input.value.replace(/[^0-9]/g, ''); // Solo permite números
            }

        </script>
    </section>
@endsection
