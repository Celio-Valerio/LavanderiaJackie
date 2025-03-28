@extends('layouts.principal')
@section('title', 'Detalles del Cupón')
@section('content')

<style>
.card {
            background-image: url('{{ asset('assets/img/cupon.gif') }}');
            background-size: fill;
            background-position: center center;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.76);
            border-radius: 15px;
            transition: background-color 0.3s ease;
        }

        .card-title {
            font-size: 30px !important;
            color: #333;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        </style>


<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 30px !important;">Detalles del Cupón {{ $cupon->nombre }}</h1>
                    <hr>

                    <div class="row mb-3">
                        <!-- Información básica del cupón -->
                        <div class="col-md-6">
                            <h5>Información General</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Nombre del Cupón</th>
                                        <td>{{ $cupon->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tipo</th>
                                        <td>{{ $cupon->tipo }}</td>
                                    </tr>
                                    <tr>
                                        <th>Valor</th>
                                        <td>
                                            @if($cupon->tipo == 'Descuento')
                                                {{ $cupon->valor }}%
                                            @elseif($cupon->tipo == 'Valor')
                                                L. {{ number_format($cupon->valor, 2) }}
                                            @else
                                                {{ $cupon->valor }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Descripción</th>
                                        <td>{{ $cupon->descripcion }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vigencia</th>
                                        <td>{{ \Carbon\Carbon::parse($cupon->fecha_desde)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($cupon->fecha_hasta)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Estado</th>
                                        <td>
                                            <span class="badge bg-{{ $cupon->estado == 'Activo' ? 'success' : 'danger' }}">
                                                {{ $cupon->estado }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Lista de clientes asignados -->
                        <div class="col-md-6">
                            <h5>Clientes Asignados</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cupon->clientes as $cliente)
                                            <tr>
                                                <td>{{ $cliente->first_name }} {{ $cliente->last_name }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">No hay clientes asignados</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row gx-2">  <!-- Usamos row de Bootstrap con gutter horizontal -->
                        <div class="col">  <!-- Cada col ocupa igual ancho -->
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                {{ $cupon->estado == 'Activo' ? 'Desactivar' : 'Activar' }} Cupón
                            </button>
                        </div>

                        <div class="col">
                            <a href="{{ route('cupones.index') }}" class="btn btn-danger w-100">
                                Regresar
                            </a>
                        </div>

                        <div class="col">
                            <a href="{{ route('cupones.print', $cupon) }}"
                               class="btn btn-success w-100 no-print"
                               target="_blank">
                                <i class="bi bi-printer"></i> Imprimir
                            </a>
                        </div>

                        <div class="col">
                            <a href="{{ route('cupones.pdf', $cupon) }}"
                               class="btn btn-danger w-100 no-print">
                                <i class="bi bi-file-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Adertencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿{{ $cupon->estado == 'Activo' ? 'Deseas desactivar' : 'Deseas activar' }} el cupón?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('cupones.toggle-estado', $cupon->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
