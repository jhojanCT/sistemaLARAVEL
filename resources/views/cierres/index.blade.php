

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Cierres Diarios</h1>

    <form action="{{ route('cierres.cerrar') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Cerrar Día</button>
    </form>


    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Total Ventas Materia Prima</th>
                <th>Total Ventas Producto</th>
                <th>Total Compras Materia Prima</th>
                <th>Total Pagos</th>
                <th>Saldo Final</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cierres as $cierre)
            <tr>
                <td>{{ $cierre->fecha->format('Y-m-d') }}</td>
                <td>Bs{{ number_format($cierre->total_ventas_materia_prima, 2) }}</td>
                <td>Bs{{ number_format($cierre->total_ventas_producto, 2) }}</td>
                <td>Bs{{ number_format($cierre->total_compras_materia_prima, 2) }}</td>
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