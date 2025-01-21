@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entradas de Materia Prima</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('control_entrada_materia_prima.create') }}" class="btn btn-primary mb-3">Añadir Nueva Entrada</a>

    <table class="table">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Materia Prima</th>
                <th>Cantidad (kg)</th>
                <th>Precio Unitario (por kg)</th>
                <th>Precio Total</th>
                <th>Encargado</th>
                <th>Fecha de Llegada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @php
            $totalPrecio = 0; // Inicializamos la variable para el total
        @endphp

        @foreach($entradas as $entrada)
            <tr>
                <td>{{ $entrada->proveedor->nombre }}</td>
                <td>{{ $entrada->materiaPrima->nombre }}</td>
                <td>{{ $entrada->cantidad }}</td>
                <td>Bs{{ number_format($entrada->precio_unitario_por_kilo, 2) }}</td>
                <td>Bs{{ number_format($entrada->precio_total, 2) }}</td>
                <td>{{ $entrada->encargado }}</td>
                <td>{{ $entrada->fecha_llegada }}</td>
                <td>
                    <a href="{{ route('control_entrada_materia_prima.edit', $entrada->id) }}" class="btn btn-warning">Editar</a>
                </td>
            </tr>

            @php
                $totalPrecio += $entrada->precio_total; // Sumamos el precio total
            @endphp
        @endforeach
        </tbody>
    </table>


    <div class="alert alert-info">
        <strong>Total Precio: </strong> Bs{{ number_format($totalPrecio, 2) }}
    </div>
</div>
@endsection
