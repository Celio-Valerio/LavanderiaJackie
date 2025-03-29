@extends('layouts.print')

@section('content')
    <style>
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 24px; color: #333; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f8f9fa; }
        .total-row { font-weight: bold; }
    </style>

    <div class="header">
        <h1 class="title">Reporte de Servicios Efectuados</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($servicios as $index => $servicio)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $servicio->cliente->first_name }} {{ $servicio->cliente->last_name }}</td>
                <td>{{ $servicio->servicio->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}</td>
                <td>{{ $servicio->estado }}</td>
                <td>L. {{ number_format($servicio->total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr class="total-row">
            <td colspan="5" class="text-end">Total General:</td>
            <td>L. {{ number_format($servicios->sum('total'), 2) }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
