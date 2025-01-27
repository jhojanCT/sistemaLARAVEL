<!-- resources/views/salidas_produccion/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Salidas de Producción</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('salidas_produccion.create') }}" class="btn btn-primary">Crear Nueva Salida</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Entrada de Producción</th>
                    <th>Producto</th>
                    <th>Cantidad Productos Hechos</th>
                    <th>Costo Producción por Unidad</th> <!-- Cambiado aquí -->
                    <th>Costo Total</th> <!-- Nueva columna -->
                    <th>Fecha de Salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salidas as $salida)
                    <tr>
                        <td>{{ $salida->entradaProduccion->id }}</td>
                        <td>{{ $salida->entradaProduccion->producto->nombre }}</td>
                        <td>{{ $salida->cantidad_productos_hechos }}</td>
                        <td>{{ $salida->precio_produccion }}</td> <!-- Costo por unidad -->
                        <td>{{ $salida->cantidad_productos_hechos * $salida->precio_produccion }}</td> <!-- Costo total -->
                        <td>{{ $salida->fecha_salida }}</td>
                        <td>
                            @if($salida->esperado_aprobacion !== 'aprobado')
                                <form action="{{ route('salidas_produccion.aprobar', $salida) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Aprobar</button>
                                </form>
                            @else
                                <span class="text-success">Aprobado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
