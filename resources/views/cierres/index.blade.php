@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cierres Diarios</h2>

    <form action="{{ route('cierres.cerrar') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Cerrar Día</button>
    </form>

    <h3>Historial de Cierres</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Total Ventas</th>
                <th>Total Pagos</th>
                <th>Saldo Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cierres as $cierre)
            <tr>
                <td>{{ $cierre->fecha }}</td>
                <td>{{ $cierre->total_ventas_producto + $cierre->total_ventas_materia_prima }}</td>
                <td>{{ $cierre->total_pagos }}</td>
                <td>{{ $cierre->saldo_final }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
