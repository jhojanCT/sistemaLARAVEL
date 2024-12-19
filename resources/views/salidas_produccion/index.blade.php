<!-- resources/views/salidas_produccion/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Salidas de Producción</h1>

        <!-- Mostrar mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('salidas_produccion.create') }}" class="btn btn-primary">Crear Nueva Salida</a>
        <!-- Tabla de salidas de producción -->
        <table class="table">
            <thead>
                <tr>

                    <th>Entrada de Producción</th>
                    <th>Producto</th> <!-- Nueva columna para mostrar el producto -->
                    <th>Cantidad Productos Hechos</th>
                    <th>Precio Producción</th>
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
        <td>{{ $salida->precio_produccion }}</td>
        <td>{{ $salida->fecha_salida }}</td>
        <td>
            @if($salida->esperado_aprobacion !== 'aprobado') <!-- Verifica si no está aprobado -->
                <form action="{{ route('salidas_produccion.aprobar', $salida) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Aprobar</button>
                </form>
            @else
                <span class="text-success">Aprobado</span> <!-- Muestra "Aprobado" si ya está aprobado -->
            @endif
        </td>
    </tr>
@endforeach
            </tbody>
        </table>


    </div>
@endsection
