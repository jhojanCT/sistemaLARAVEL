@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cierres Diarios</h2>

    <form action="{{ route('cierres.cerrar') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary mb-3">Cerrar Día</button>
    </form>

    <h3>Historial de Cierres</h3>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Fecha</th>
                <th>Saldo Inicial</th>
                <th>Total Ventas</th>
                <th>Total Pagos</th>
                <th>Saldo Final</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cierres as $cierre)
            <tr>
                <td>{{ $cierre->fecha->format('d/m/Y') }}</td>
                <td>Bs{{ number_format(optional($cierre->apertura)->saldo_inicial ?? 0, 2) }}</td>
                <td>Bs{{ number_format($cierre->total_ventas_producto + $cierre->total_ventas_materia_prima, 2) }}</td>
                <td>Bs{{ number_format($cierre->total_pagos, 2) }}</td>
                <td>Bs{{ number_format($cierre->saldo_final, 2) }}</td>
                <td>
                    <a href="{{ route('cierres.show', $cierre->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
